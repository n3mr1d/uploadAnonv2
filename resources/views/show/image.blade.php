<x-htmlhead :title="$title">
    <x-alertfunction></x-alertfunction>

    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class=" rounded-xl w-full flex flex-col items-center">
            <h1 class="text-2xl font-bold text-white mb-2">Image Preview</h1>
            <div class="mt-10 flex flex-col sm:flex-row sm:justify-between items-center gap-4 mb-4 rounded-xl  px-6 py-4">
               <div class="w-full gap-20 flex">
         
                <div class="flex  items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @if($image->expires_at)
                        <span class="font-semibold text-gray-100">Expires:</span>
                        <span class="text-lg font-mono text-cyan-200">{{ \Carbon\Carbon::parse($image->expires_at)->diffForHumans() }}</span>
                    @else
                        <span class="font-semibold text-gray-100">Never Expires</span>
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-semibold text-gray-100">Size:</span>
                    <span class="text-lg font-mono text-blue-200">
                        @php
                            function human_filesize($bytes, $decimals = 2) {
                                $size = ['B','KB','MB','GB','TB','PB','EB','ZB','YB'];
                                $factor = floor((strlen($bytes) - 1) / 3);
                                return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
                            }
                        @endphp
                        {{ human_filesize($image->size ?? 0) }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"></path>
                    </svg>
                    <span class="font-semibold text-gray-100">Extension:</span>
                    <span class="text-lg font-mono text-pink-200">{{ $image->extension ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8a9 9 0 100-18 9 9 0 000 18z"></path>
                    </svg>
                    <span class="font-semibold text-gray-100">MIME Type:</span>
                    <span class="text-lg font-mono text-purple-200">{{ $image->mime_type ?? '-' }}</span>
                </div>
       
            </div>
        </div>
        <div class="flex w-full justify-center gap-4 mt-2 mb-5">
            @if (session()->has('delete_token'))
            <form action="{{ route('destroy.files') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="token" value="{{ session('delete_token') }}">
                <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                    Delete Files
                </button>
            </form>
        @endif
            <a href="{{ route('index') }}" class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">Upload File</a>
            <a href="{{ route('pastebin.index') }}" class="px-4 py-2 rounded bg-gray-800 hover:bg-gray-700 text-gray-100 font-semibold transition">Pastebin</a>
        </div>

            <div class="w-full flex justify-center mb-4">
             
            <img class="h-auto w-auto rounded-lg" src="https://placehold.co/900" alt="image description">

            </div>
      
            <div class="w-full flex flex-col items-center mt-6">
                <span class="text-gray-400 text-sm mb-2 break-all">
                    {{ $image->original_name ?? $image->stored_name }}
                </span>
                <a 
                    href="{{ $url }}" 
                    download="{{ $image->original_name ?? $image->stored_name }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition-colors duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Download
                </a>
                <div class="w-full max-w-xl my-6">
                    <details class="bg-gray-700 rounded-lg p-2 border-2 border-gray-500">
                        <summary class="cursor-pointer text-lg font-semibold text-white mb-2 flex items-center gap-2 select-none">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"></path>
                            </svg>
                            Copy Embed Code (click)
                        </summary>
                        <div class="relative mt-3">
                            <textarea 
                                readonly 
                                class="w-full bg-gray-800 text-white font-mono rounded-lg p-3 pr-12 border-2 border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 transition resize-none" 
                                rows="2"
                                id="html-embed-code"
                            >{{$url}}</textarea>
                        </div>
                    </details>
                    <details class="bg-gray-700 mt-5 rounded-lg p-2 border-2 border-gray-500">
                        <summary class="cursor-pointer text-lg font-semibold text-white mb-2 flex items-center gap-2 select-none">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"></path>
                            </svg>
                            unique Embed Code (click)
                        </summary>
                        <div class="relative mt-3">
                            <textarea 
                                readonly 
                                class="w-full bg-gray-800 text-white font-mono rounded-lg p-3 pr-12 border-2 border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 transition resize-none" 
                                rows="2"
                                id="html-embed-code"
                            >{{route('show.files',[$image->uuid])}}</textarea>
                        </div>
                    </details>
                </div>
            </div>
      
        </div>
    </div>
</x-htmlhead>