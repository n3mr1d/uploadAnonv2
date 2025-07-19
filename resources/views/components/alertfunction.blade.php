
@if(session('success'))
    <div id="alert-success" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <div class="flex items-center">
            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M16.707 5.293a1 1 0 0 0-1.414 0L9 11.586 6.707 9.293a1 1 0 0 0-1.414 1.414l3 3a1 1 0 0 0 1.414 0l7-7a1 1 0 0 0-1.414-1.414z"/>
            </svg>
            <span class="sr-only">Success</span>
            <h3 class="text-lg font-medium">Success</h3>
        </div>
        <div class="mt-2 mb-4 text-sm">
            {{ session('success') }}
            @if(session('delete_token'))
                <div class="mt-2">
                    <span class="font-semibold">Delete Token:</span>
                    <span class="font-mono select-all">{{ session('delete_token') }}</span>
                </div>
            @endif
        </div>

    </div>
@endif

@if($errors->any())
    <div id="alert-error" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <div class="flex items-center">
            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9 7a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V7Zm1 8a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
            </svg>
            <span class="sr-only">Error</span>
            <h3 class="text-lg font-medium">Error</h3>
        </div>
        <div class="mt-2 mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    </div>
@endif