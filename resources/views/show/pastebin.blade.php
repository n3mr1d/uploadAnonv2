<x-htmlhead :title="$title">
    <div class="min-h-screen bg-gray-900 text-gray-100 py-8 px-4">
        <x-alertfunction></x-alertfunction>
        <div class="flex w-full justify-center gap-4 mt-8">
            <a href="{{ route('index') }}" class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">Upload File</a>
            <a href="{{ route('pastebin.index') }}" class="px-4 py-2 rounded bg-gray-800 hover:bg-gray-700 text-gray-100 font-semibold transition">Pastebin</a>
            @if (session()->has('delete_token'))
                <form action="{{ route('pastebin.destory') }}" method="POST" class="inline-block">
                    @csrf
                    <input type="hidden" name="token" value="{{ session('delete_token') }}">
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                        Delete Text
                    </button>
                </form>
            @endif
        </div>
        <div class="max-w-3xl mx-auto rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-100">{{ $paste->title ?? 'Preview Markdown' }}</h1>
            <div class="prose prose-invert max-w-none w-full h-96 bg-gray-900 text-gray-100 border border-gray-700 rounded p-4 overflow-auto" style="min-height: 24rem;">
                {!! $content !!}
            </div>
            <div class="mt-10 flex flex-col sm:flex-row sm:justify-between items-center gap-4  rounded-xl shadow-lg px-6 py-4 border border-indigo-500/30">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="font-semibold text-gray-100">Views:</span>
                    <span class="text-lg font-mono text-yellow-300">{{ $paste->view_count ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @if($paste->expires_at)
                        <span class="font-semibold text-gray-100">Expires:</span>
                        <span class="text-lg font-mono text-cyan-200">{{ \Carbon\Carbon::parse($paste->expires_at)->diffForHumans() }}</span>
                    @else
                        <span class="font-semibold text-gray-100">Never Expires</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <style>
        /* Custom scrollbar for dark mode */
        ::-webkit-scrollbar {
            width: 8px;
            background: #2d3748;
        }
        ::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 4px;
        }
        /* Tailwind prose dark mode fix */
        .prose-invert pre {
            background-color: #1a202c !important;
        }
        .prose-invert code {
            background-color: #2d3748 !important;
            color: #fbbf24 !important;
        }
        .prose-invert blockquote {
            border-left-color: #fbbf24 !important;
        }
        .prose-invert table {
            background-color: #2d3748 !important;
        }
    </style>
</x-htmlhead>