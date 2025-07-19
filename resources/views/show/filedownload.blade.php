<x-htmlhead :title="$title">
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex flex-col items-center justify-center py-10 px-4">
        <x-alertfunction></x-alertfunction>
        <div class="w-full max-w-2xl bg-gray-800/80 rounded-2xl shadow-2xl p-8 flex flex-col items-center border border-gray-700">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="flex flex-col items-center">
                    <div class="bg-cyan-900/40 rounded-full p-2 mb-2">
                        <svg class="w-7 h-7 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-cyan-200 font-semibold">Expires</span>
                    <span class="text-sm font-mono text-cyan-100">
                        @if($file->expires_at)
                            {{ \Carbon\Carbon::parse($file->expires_at)->diffForHumans() }}
                        @else
                            Never
                        @endif
                    </span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-blue-900/40 rounded-full p-2 mb-2">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-blue-200 font-semibold">Size</span>
                    <span class="text-sm font-mono text-blue-100">
                        @php
                            function human_filesize($bytes, $decimals = 2) {
                                $size = ['B','KB','MB','GB','TB','PB','EB','ZB','YB'];
                                $factor = floor((strlen($bytes) - 1) / 3);
                                return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
                            }
                        @endphp
                        {{ human_filesize($file->size ?? 0) }}
                    </span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-pink-900/40 rounded-full p-2 mb-2">
                        <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-pink-200 font-semibold">Extension</span>
                    <span class="text-sm font-mono text-pink-100">{{ $file->extension ?? '-' }}</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-purple-900/40 rounded-full p-2 mb-2">
                        <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8a9 9 0 100-18 9 9 0 000 18z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-purple-200 font-semibold">MIME Type</span>
                    <span class="text-sm font-mono text-purple-100 text-center break-all">{{ $file->mime_type ?? '-' }}</span>
                </div>
            </div>

            <div class="w-full bg-gray-900/80 rounded-xl shadow-lg p-6 mb-8 border border-gray-700">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-semibold">Filename:</span>
                        <span class="text-gray-100 font-mono break-all">{{ $file->stored_name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-semibold">Original Name:</span>
                        <span class="text-gray-100 font-mono break-all">{{ $file->original_name ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-semibold">Size:</span>
                        <span class="text-gray-100 font-mono">{{ human_filesize($file->size) }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap w-full justify-center gap-4 mt-2">
                @if (session()->has('delete_token'))
                    <form action="{{ route('destroy.files') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="token" value="{{ session('delete_token') }}">
                        <button type="submit" class="px-5 py-2 rounded-lg bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold shadow-lg transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                @endif

                <a href="{{ route('index') }}" class="px-5 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold shadow-lg transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Upload File
                </a>
                <a 
                    href="{{ $url }}" 
                    download="{{ $file->original_name ?? $file->stored_name }}"
                    class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-base font-bold rounded-lg shadow-lg transition-all duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Download
                </a>
                <a href="{{ route('pastebin.index') }}" class="px-5 py-2 rounded-lg bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-gray-100 font-bold shadow-lg transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"/>
                    </svg>
                    Pastebin
                </a>
            </div>
        </div>
    </div>
</x-htmlhead>