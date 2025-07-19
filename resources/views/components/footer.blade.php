
<footer class="w-full bg-[var(--oxford-blue)] text-white">
    <div class="container-footer flex flex-col md:flex-row gap-8 md:gap-0 justify-between items-start md:items-stretch">
        <div class="about w-full md:w-1/2 mb-6 md:mb-0">
            <h3 class="text-xl font-semibold flex items-center mb-2">
                <i class="fa-solid fa-circle-info text-blue-400 mr-2"></i>
                About {{ config("app.name") }} 
            </h3>
            <p class="text-justify text-gray-300 text-sm leading-relaxed">
                {{ config("app.name") }} 
                is an anonymous image and file uploader platform operating on the darkweb, allowing users to upload files without leaving behind identifying metadata.

            Our platform provides strong security features and is completely free of charge, making it a popular choice for those who value privacy and security.
            </p>
            <div class="features flex flex-wrap gap-4 mt-4">
                <div class="feature-item flex items-center bg-white/10 px-3 py-2 rounded">
                    <i class="fa-solid fa-shield-halved text-green-400 feature-icon"></i>
                    <span class="feature-text ml-2">Privacy Focused</span>
                </div>
                <div class="feature-item flex items-center bg-white/10 px-3 py-2 rounded">
                    <i class="fa-solid fa-link text-yellow-400 feature-icon"></i>
                    <span class="feature-text ml-2">Curated Links</span>
                </div>
                <div class="feature-item flex items-center bg-white/10 px-3 py-2 rounded">
                    <i class="fa-solid fa-globe text-blue-300 feature-icon"></i>
                    <span class="feature-text ml-2">Global Access</span>
                </div>
             
                <div class="feature-item flex items-center bg-white/10 px-3 py-2 rounded">
                    <i class="fa-solid fa-upload text-white-300 feature-icon"></i>
                    <span class="feature-text ml-2">Total Upload  : {{$total}} </span>
                </div>
            </div>
        </div>
        <div class="donate w-full md:w-1/2 pl-0 md:pl-8">
            <h3 class="text-xl font-semibold flex items-center mb-2">
                <i class="fa-solid fa-heart text-pink-400 mr-2"></i>
                Support Our Service
            </h3>
            <p class="mb-3 text-gray-300">Help us keep {{ config("app.name") }} running and ad-free by donating:</p>
            <div class="crypto-donations space-y-2">
                <div class="crypto flex items-center bg-white/5 px-3 py-2 rounded">
                    <i class="fa-brands fa-btc text-yellow-400 text-xl mr-2"></i>
                    <span class="crypto-name mr-2">Bitcoin:</span>
                    <span class="crypto-address text-xs text-gray-400 font-mono">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                </div>
                <div class="crypto flex items-center bg-white/5 px-3 py-2 rounded">
                    <i class="fa-brands fa-ethereum text-blue-400 text-xl mr-2"></i>
                    <span class="crypto-name mr-2">Ethereum:</span>
                    <span class="crypto-address text-xs text-gray-400 font-mono">0x71C7656EC7ab88b098defB751B7401B5f6d8976F</span>
                </div>
            </div>
            <div class="donate-message mt-4 text-gray-400 text-sm">
                <p>Your support helps us maintain our infrastructure and develop new features.</p>
                <p>Thank you for being part of our community!</p>
            </div>
        </div>
    </div>
    <hr class="border-gray-700 my-6" />
    <div class="text-center pb-4">
        <span class="text-sm text-gray-400">© {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</span>
    </div>
</footer>