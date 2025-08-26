<footer class="w-full text-white bg-[var(--oxford-blue)]">
    <div class="flex flex-col gap-8 justify-between items-start md:flex-row md:gap-0 md:items-stretch container-footer">
        <div class="mb-6 w-full md:mb-0 md:w-1/2 about">
            <h3 class="flex items-center mb-2 text-xl font-semibold">
                <i class="mr-2 text-blue-400 fa-solid fa-circle-info"></i>
                About {{ config('app.name') }}
            </h3>
            <p class="text-sm leading-relaxed text-justify text-gray-300">
                {{ config('app.name') }}
                is an anonymous image and file uploader platform operating on the darkweb, allowing users to upload
                files without leaving behind identifying metadata.

                Our platform provides strong security features and is completely free of charge, making it a popular
                choice for those who value privacy and security.
            </p>
            <div class="flex flex-wrap gap-4 mt-4 features">
                <div class="flex items-center py-2 px-3 rounded feature-item bg-white/10">
                    <i class="text-green-400 fa-solid fa-shield-halved feature-icon"></i>
                    <span class="ml-2 feature-text">Privacy Focused</span>
                </div>
                <div class="flex items-center py-2 px-3 rounded feature-item bg-white/10">
                    <i class="text-yellow-400 fa-solid fa-link feature-icon"></i>
                    <span class="ml-2 feature-text">Curated Links</span>
                </div>
                <div class="flex items-center py-2 px-3 rounded feature-item bg-white/10">
                    <i class="text-blue-300 fa-solid fa-globe feature-icon"></i>
                    <span class="ml-2 feature-text">Global Access</span>
                </div>
                <div class="flex items-center py-2 px-3 rounded feature-item bg-white/10">
                    <i class="text-pink-400 fa-solid fa-street-view"></i>
                    <span class="ml-2 feature-text">Total Viewer : {{ $viewer }} </span>
                </div>
                <div class="flex items-center py-2 px-3 rounded feature-item bg-white/10">
                    <i class="fa-solid fa-upload text-white-300 feature-icon"></i>
                    <span class="ml-2 feature-text">Total Upload : {{ $total }} </span>
                </div>
            </div>
        </div>
        <div class="pl-0 w-full md:pl-8 md:w-1/2 donate">
            <h3 class="flex items-center mb-2 text-xl font-semibold">
                <i class="mr-2 text-pink-400 fa-solid fa-heart"></i>
                Support Our Service
            </h3>
            <p class="mb-3 text-gray-300">Help us keep {{ config('app.name') }} running and ad-free by donating:</p>
            <div class="space-y-2 crypto-donations">
                <div class="flex items-center py-2 px-3 rounded crypto bg-white/5">
                    <i class="mr-2 text-xl text-yellow-400 fa-brands fa-btc"></i>
                    <span class="mr-2 crypto-name">Bitcoin:</span>
                    <span
                        class="font-mono text-xs text-gray-400 crypto-address">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                </div>
                <div class="flex items-center py-2 px-3 rounded crypto bg-white/5">
                    <i class="mr-2 text-xl text-blue-400 fa-brands fa-ethereum"></i>
                    <span class="mr-2 crypto-name">Ethereum:</span>
                    <span
                        class="font-mono text-xs text-gray-400 crypto-address">0x71C7656EC7ab88b098defB751B7401B5f6d8976F</span>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-400 donate-message">
                <p>Your support helps us maintain our infrastructure and develop new features.</p>
                <p>Thank you for being part of our community!</p>
            </div>
        </div>
    </div>
    <hr class="my-6 border-gray-700" />
    <div class="pb-4 text-center">
        <span class="text-sm text-gray-400">© {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</span>
    </div>
</footer>

