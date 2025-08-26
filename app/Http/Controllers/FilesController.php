<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
    public function index()
    {
        return view('welcome', ['title' => 'Files Uploader']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'files' => 'required|array|max:100',
            'files.*' => 'file|max:102400',
            'password' => 'nullable|string|max:255',
            'expiry' => 'nullable|string|in:1d,7d,3m,1y,never',
        ]);

        $files = $request->file('files');
        $password = $request->input('password');
        $expiry = $request->input('expiry', '1d');

        if (!$files || count($files) < 1) {
            return back()->withErrors(['files' => 'No files uploaded.']);
        }

        $storedImages = [];
        $storedFiles = [];
        $imageMimeTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'image/bmp', 'image/svg+xml'
        ];

        $bulkId = null;
        if (count($files) > 1) {
            $bulkId = Str::random(10);
        }

        foreach ($files as $file) {
            $uuid = (string) Str::uuid();
            $extension = $file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
            $size = $file->getSize();
            $storedName = $uuid . '.' . $extension;

            // Set expiry date
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

            $passwordValue = $password ? $password : null;
            $delete_token = Str::random(12);

            // Simpan file ke storage/app/public/files
            $file->storeAs('files', $storedName, 'public');

            DB::table('files')->insert([
                'uuid' => $uuid,
                'original' => $originalName,
                'stored_name' => $storedName,
                'mime_type' => $mimeType,
                'size' => $size,
                'bulk_id' => $bulkId,
                'extension' => $extension,
                'password' => $passwordValue,
                'download_count' => 0,
                'view_count' => 0,
                'uploader_ip' => $request->ip(),
                'delete_token' => $delete_token,
                'expires_at' => $expires_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $item = [
                'uuid' => $uuid,
                'size' => $size,
                'expire_at' => $expires_at,
                'original_name' => $originalName,
                'delete_token' => $delete_token,
                'mime_type' => $mimeType,
            ];

            if (in_array($mimeType, $imageMimeTypes)) {
                $storedImages[] = $item;
            } else {
                $storedFiles[] = $item;
            }
        }

        $totalFiles = count($storedImages) + count($storedFiles);

        if ($totalFiles === 1) {
            $data = array_merge($storedImages, $storedFiles);
            $fileData = $data[0];

            return redirect()->route('show.files', ['uuid' => $fileData['uuid']])
                ->with([
                    'success' => 'Upload file ' . $fileData['original_name'] . ' success.',
                    'delete_token' => $fileData['delete_token']
                ]);
        } else {
            return redirect()->route('show.bulk', [$bulkId])
                ->with('success', 'Upload ' . $totalFiles . ' file success.');
        }
    }

    public function bulshow($bulk_id)
    {
        $files = Files::where('bulk_id', $bulk_id)->get();

        if ($files->isEmpty()) {
            abort(404, 'Bulk not found');
        }

        return view('bulkKontainer', [
            'title' => 'Bulk Kontainer',
            'files' => $files,
        ]);
    }

    public function showonefile(Request $request, $uuid)
    {
        $file = Files::where('uuid', $uuid)->first();

        if (!$file) {
            abort(404, 'File not found');
        }

        $imageMimeTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'image/bmp', 'image/svg+xml'
        ];
        $isImage = in_array($file->mime_type, $imageMimeTypes);

        if ($isImage) {
            return $this->showImage($request, $file);
        } else {
            return $this->showFile($request, $file);
        }
    }

    // Pisahkan logic image
    protected function showImage(Request $request, $file)
    {
        $uuid = $file->uuid;
        $file->increment('view_count');
        $imagePath = "files/{$file->stored_name}";
        if (!Storage::disk('public')->exists($imagePath)) {
            abort(404, 'Image file not found in storage');
        }
        $url = config('app.url') . '/storage/app/public/' . $imagePath;

        if ($file->password) {
            $cookieKey = 'files_password_' . $uuid;
            $cookieValue = $request->cookie($cookieKey);

            if ($cookieValue && $cookieValue === md5($file->password)) {
                return view('show.image', [
                    'title' => 'Show Image',
                    'image' => $file,
                    'url' => $url
                ]);
            }

            if ($request->isMethod('post')) {
                $inputPassword = $request->input('password');
                if ($inputPassword === $file->password) {
                    Cookie::queue($cookieKey, md5($file->password), 1440);
                    return view('show.image', [
                        'title' => 'Show Image',
                        'image' => $file,
                        'url' => $url
                    ]);
                } else {
                    return view('protectednottext', [
                        'title' => 'Protected Files',
                        'info' => $file,
                        'error' => 'Incorrect password. Please try again.'
                    ]);
                }
            }

            return view('protectednottext', [
                'title' => 'Protected Files',
                'info' => $file,
                'error' => null
            ]);
        }

        return view('show.image', [
            'title' => 'Show Image',
            'image' => $file,
            'url' => $url
        ]);
    }

    // Pisahkan logic file (non-image)
    protected function showFile(Request $request, $file)
    {
        $file->increment('view_count');
        $filepath = "files/{$file->stored_name}";
        if (!Storage::disk('public')->exists($filepath)) {
            abort(404, 'File not found in storage');
        }
        $url = url('/storage/app/public/' . $filepath);

        if ($file->password) {
            $uuid = $file->uuid;
            $cookieKey = 'files_password_' . $uuid;
            $cookieValue = $request->cookie($cookieKey);

            if ($cookieValue && $cookieValue === md5($file->password)) {
                return view('show.filedownload', [
                    'uuid' => $file->uuid,
                    'original_name' => $file->original ?? $file->stored_name,
                    'delete_token' => $file->delete_token,
                    'title' => 'File Detail',
                    'url' => $url,
                    'file' => $file,
                ]);
            }

            if ($request->isMethod('post')) {
                $inputPassword = $request->input('password');
                if ($inputPassword === $file->password) {
                    Cookie::queue($cookieKey, md5($file->password), 1440);
                    return view('show.filedownload', [
                        'uuid' => $file->uuid,
                        'original_name' => $file->original ?? $file->stored_name,
                        'delete_token' => $file->delete_token,
                        'title' => 'File Detail',
                        'url' => $url,
                        'file' => $file,
                    ]);
                } else {
                    return view('protectednottext', [
                        'title' => 'Protected Files',
                        'info' => $file,
                        'error' => 'Incorrect password. Please try again.'
                    ]);
                }
            }

            return view('protectednottext', [
                'title' => 'Protected Files',
                'info' => $file,
                'error' => null
            ]);
        }

        return view('show.filedownload', [
            'title' => 'File Detail',
            'file' => $file,
            'url' => $url
        ]);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'exists:files,delete_token'],
        ]);

        $file = Files::where('delete_token', $validated['token'])->first();

        if (!$file) {
            abort(404, 'Token invalid');
        }

        $filePath = "files/{$file->stored_name}";
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        $file->delete();

        return redirect()->route('index')->with('success', 'File ' . $file->original . ' deleted successfully.');
    }
    public function desbulk(Request $request){
        $validated = $request->validate([
            'token' => ['required', 'exists:files,delete_token'],
        ]);

        $file = Files::where('delete_token', $validated['token'])->first();

        if (!$file) {
            abort(404, 'Token invalid');
        }

        $filePath = "files/{$file->stored_name}";
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        $file->delete();

        return back()->with('success', 'File ' . $file->original . ' deleted successfully.');
    }
}
