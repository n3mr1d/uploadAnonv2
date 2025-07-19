<?php

namespace App\Http\Controllers;

use App\Models\Pastebin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class PastebinController extends Controller
{
    public function index()
    {
        return view('pastebin', ['title' => 'Pastebin']);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'min:3'],
            'password' => ['nullable'],
            'expiry' => ['required']
        ]);

        $markdownContent = $validated['message'];

        $expiry = $validated['expiry'];
        $expires_at = null;
        switch ($expiry) {
            case '1d':
                $expires_at = now()->addDay();
                break;
            case '7d':
                $expires_at = now()->addDays(7);
                break;
            case '3m':
                $expires_at = now()->addMonths(3);
                break;
            case '1y':
                $expires_at = now()->addYear();
                break;
            case 'never':
            default:
                $expires_at = null;
                break;
        }

        $uuid = Str::uuid();
        $stored_name = Str::random(12);
        $deleted_token = Str::random(21);

        $paste = Pastebin::create([
            'uuid' => $uuid,
            'stored_names' => $stored_name,
            'title' => 'Untitled',
            'mime_type' => 'text/markdown',
            'size' => strlen($markdownContent),
            'extension' => 'md',
            'password' => $validated['password'] ?? null,
            'expires_at' => $expires_at,
            'delete_token' => $deleted_token,
        ]);

        Storage::disk('public')->put("pastebin/{$stored_name}.md", $markdownContent);

        if (!empty($validated['password'])) {
            $cookieName = 'pastebin_password_' . $uuid;
            $cookieValue = md5($validated['password']);
            Cookie::queue($cookieName, $cookieValue, 1440);
        }

        return redirect()->route('pastebin.show', [$uuid])->with([
            'success' => 'Pastebin created successfully!',
            'delete_token' => $deleted_token
        ]);
    }

    public function show(Request $request, $uuid)
    {
        $paste = Pastebin::where('uuid', '=',$uuid)->first();

        if (!$paste) {
            abort(404, 'Pastebin Not Found');
        }

        // Cek expired
        if ($paste->expires_at && now()->greaterThan($paste->expires_at)) {
            Storage::disk('public')->delete("pastebin/{$paste->stored_names}.md");
            $paste->delete();
            abort(404, 'This Pastebin has expired and is no longer available.');
        }

        // Jika ada password
        if (!is_null($paste->password)) {
            $cookieKey = 'pastebin_password_' . $uuid;
            $cookieValue = $request->cookie($cookieKey);

            // Jika sudah ada cookie dan cocok, tampilkan paste
            if ($cookieValue && $cookieValue === md5($paste->password)) {
                $content = Storage::disk('public')->get("pastebin/{$paste->stored_names}.md");
                $convert = new GithubFlavoredMarkdownConverter();
                $result = $convert->convert($content);
                $paste->increment('view_count');
                return view('show.pastebin', [
                    'title' => 'View Paste',
                    'content' => $result,
                    'paste' => $paste,
                    'uuid' => $uuid,
                ]);
            }

            // Jika POST, cek password
            if ($request->isMethod('post')) {
                $inputPassword = $request->input('password');
                if ($inputPassword === $paste->password) {
                    $content = Storage::disk('public')->get("pastebin/{$paste->stored_names}.md");
                    Cookie::queue($cookieKey, md5($paste->password), 1440);
                    $convert = new GithubFlavoredMarkdownConverter();
                    $result = $convert->convert($content);
                    $paste->increment('view_count');
                    return view('show.pastebin', [
                        'title' => 'View Paste',
                        'content' => $result,
                        'paste' => $paste,
                        'uuid' => $uuid,
                    ]);
                } else {
                    return view('protectedFiles', [
                        'title' => 'Protected Files',
                        'uuid' => $uuid,
                        'error' => 'Incorrect password. Please try again.',
                        'paste' => $paste,
                    ]);
                }
            }

            // Jika GET atau belum ada cookie/password salah, tampilkan form password
            return view('protectedFiles', [
                'title' => 'Protected Files',
                'uuid' => $uuid,
                'error' => null,
                'paste' => $paste,
            ]);
        }

        // Tidak ada password, langsung tampilkan paste
        $content = Storage::disk('public')->get("pastebin/{$paste->stored_names}.md");
        $convert = new GithubFlavoredMarkdownConverter();
        $result = $convert->convert($content);
        $paste->increment('view_count');
        return view('show.pastebin', [
            'title' => 'View Paste',
            'content' => $result,
            'paste' => $paste,
            'uuid' => $uuid,
        ]);
    }
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'exists:pastebins,delete_token'],
        ]);

        // Cari pastebin berdasarkan delete_token
        $pastebin = Pastebin::where('delete_token', '=',$validated['token'])->first();

        if (!$pastebin) {
            abort(404, 'Token invalid');
        }

        $filePath = "pastebin/{$pastebin->stored_names}.md";
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        $pastebin->delete();

        return redirect()->route('pastebin.index')->with('success', 'Pastebin deleted successfully.');
    }

 
   
}
