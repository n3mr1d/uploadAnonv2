<x-htmlhead :title="$title">
    <div class="w-full mb-3 mt-5">
        <x-alertfunction></x-alertfunction>

        <form action="{{ route('pastebin.show',[$paste->uuid])}}" method="post" class="w-full max-w-2xl mx-auto p-3">
            @csrf
            <input type="hidden" name="uuid" value="{{ $paste->uuid }}">
            <div class="information">
                <div class="space-y-3 bg-gray-700 p-5 rounded-2xl">
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-white font-semibold">Name Files :</span>
                        </dt>
                        <dd>
                            <ul>
                                <li class="me-1 inline-flex items-center text-sm">
                                    <span class="text-white font-semibold">{{ $paste->stored_names . '.' . $paste->extension }}</span>
                                </li>
                            </ul>
                        </dd>
                    </dl>

                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-white font-semibold">Protected:</span>
                        </dt>
                        <dd>
                            <ul>
                                <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                    <span class="text-white font-semibold">{{ is_null($paste->password) ? 'No' : 'Yes' }}</span>
                                </li>
                            </ul>
                        </dd>
                    </dl>

                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-white font-semibold">Created at:</span>
                        </dt>
                        <dd>
                            <ul>
                                <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                    <span class="text-white font-semibold">{{ $paste->created_at }}</span>
                                </li>
                                <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                    <span class="text-white font-semibold"> | </span>
                                </li>
                                <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                    <span class="text-white font-semibold">{{ $paste->created_at->diffForHumans() }}</span>
                                </li>
                            </ul>
                        </dd>
                    </dl>

                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-40">
                            <span class="block text-sm text-white font-semibold">Expired at:</span>
                        </dt>
                        <dd>
                            <ul>
                                @if($paste->expires_at)
                                    <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                        <span class="text-white font-semibold">{{ $paste->expires_at }}</span>
                                    </li>
                                    <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                        <span class="text-white font-semibold"> | </span>
                                    </li>
                                    <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($paste->expires_at)->diffForHumans() }}</span>
                                    </li>
                                @else
                                    <li class="me-1 inline-flex items-center text-sm text-gray-800 dark:text-neutral-200">
                                        <span class="text-white font-semibold">Never Expired</span>
                                    </li>
                                @endif
                            </ul>
                        </dd>
                    </dl>
                </div>
                <!-- End List -->
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Files</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required
                />
                @if(isset($error) && $error)
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                @endif
            </div>
            <div class="w-full items-start mb-5">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-htmlhead>