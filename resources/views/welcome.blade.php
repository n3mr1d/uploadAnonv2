<x-htmlhead :title="$title">
<div class=" flex flex-col items-center justify-center py-8 min-h-screen">
    <div class="w-full max-w-xl rounded-lg p-8">
        <x-alertfunction></x-alertfunction>

        <h1 class="text-2xl font-bold text-white mb-6 text-center">Files Uploader</h1>
        <form action="{{route('upload.file')}}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input 
                    class="block w-full text-sm p-3 text-white font-semibold border border-gray-700 rounded-lg cursor-pointer bg-gray-600 focus:outline-none " 
                    aria-describedby="file_input_help" 
                    id="file_input" 
                    name="files[]" 
                    type="file" 
                    multiple
                    required
                >
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">
                    SVG, PNG, ZIP, GIF, etc. (MAX. 100MB / file, multiple files allowed)
                </p>
            </div>
            <div>
                <label for="passwordfiles" class="block mb-2 text-sm font-medium text-gray-200">Password <span class="font-semibold text-gray-400">(*Optional)</span> </label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-300 bg-gray-700 border rounded-e-0 border-gray-700 border-e-0 rounded-s-md">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2c-.28 0-.56.06-.82.18l-5.5 2.45A1.5 1.5 0 0 0 2 6.01V9c0 5.25 6.13 8.53 7.23 9.09.24.13.53.13.77 0C11.87 17.53 18 14.25 18 9V6.01a1.5 1.5 0 0 0-1.68-1.38l-5.5-2.45A1.5 1.5 0 0 0 10 2zm0 1.2 5.5 2.45V9c0 4.13-4.47 6.93-5.5 7.5C8.97 15.93 4.5 13.13 4.5 9V5.65L10 3.2z"/>
                        </svg>
                    </span>
                    <input type="password" id="passwordfiles" name="password" class="rounded-none rounded-e-lg bg-gray-700 border text-gray-200 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-700 p-2.5 placeholder-gray-400" placeholder="Set Password For this Files">
                </div>
            </div>
            <div>
                <label for="expiry" class="block mb-2 text-sm font-medium text-gray-200">Expired</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-300 bg-gray-700 border rounded-e-0 border-gray-700 border-e-0 rounded-s-md">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </span>
                    <select id="expiry" name="expiry" class="bg-gray-700 border rounded-e-lg border-gray-700 text-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-400">
                        <option value="1d">1 Day</option>
                        <option value="7d">7 Days</option>
                        <option value="3m">3 Months</option>
                        <option value="1y">1 Year</option>
                        <option value="never">Never Expired</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white font-semibold py-2 rounded-lg hover:bg-blue-800 transition">Upload</button>
            <a href="{{route('pastebin.index')}}">
                <div class="w-full bg-green-600 text-center text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition mt-2">PasteBin</div>
            </a>
        </form>
    </div>
</div>
</x-htmlhead>