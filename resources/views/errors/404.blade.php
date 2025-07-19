<x-htmlhead title="Page Not Found">
    <section class="bg-gray-900 w-full h-90 min-h-screen mobile:min-h-[80vh] mb-10 flex items-center justify-center">
        <div class="container px-6 py-1 mx-auto flex flex-col-reverse lg:flex-row items-center gap-12">
            <div class="w-full lg:w-1/2">
                <p class="text-sm font-bold text-blue-500 dark:text-blue-400 uppercase tracking-widest">404 Error</p>
                <h1 class="mt-3 text-4xl font-extrabold text-gray-100 dark:text-white md:text-5xl">
                    Oops! Page Not Found
                </h1>
                @if (!empty($exception) && $exception->getMessage())
                    <div class="mt-2 text-red-400 text-lg font-semibold">
                        {{ $exception->getMessage() }}
                    </div>
                @endif
                <p class="mt-4 text-lg text-gray-400 max-w-md">
                    Sorry, the page you’re looking for doesn’t exist or has been moved.<br>
                    But don’t worry, you can get back on track!

                </p>
                <div class="flex items-center mt-8 gap-x-4">
                    <a href="{{route('index')}}" class="flex items-center px-5 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:rotate-180">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>
                        <span>Go Back</span>
                    </a>
                    <a href="{{ route('pastebin.index') }}" class="px-5 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-500 dark:bg-blue-600">
                        Take Me Home
                    </a>
                </div>
            </div>
            <div class="relative w-full mb-12 lg:w-1/2 lg:mb-0 flex justify-center">
                <svg width="320" height="220" viewBox="0 0 320 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="160" cy="200" rx="120" ry="15" fill="#1e293b" opacity="0.3"/>
                    <path d="M80 120 Q100 60 160 80 Q220 100 240 60" stroke="#3b82f6" stroke-width="6" fill="none"/>
                    <circle cx="160" cy="100" r="60" fill="#1e293b" stroke="#3b82f6" stroke-width="6"/>
                    <circle cx="140" cy="90" r="8" fill="#fff"/>
                    <circle cx="180" cy="90" r="8" fill="#fff"/>
                    <ellipse cx="160" cy="120" rx="18" ry="8" fill="#fff" opacity="0.7"/>
                    <text x="160" y="200" text-anchor="middle" fill="#3b82f6" font-size="32" font-weight="bold" font-family="monospace">404</text>
                </svg>
            </div>
        </div>
    </section>
</x-htmlhead>