<x-htmlhead :title="$title">
    <x-alertfunction />

    <div class="flex flex-col justify-around items-center min-h-screen bg-gray-900 sm:flex-row">
        <!-- Form Login -->
        <div class="flex flex-col justify-center py-12 px-6 lg:w-1/2 mobile:w-full">
            <div class="sm:mx-auto sm:w-full">
                <h2 class="mt-10 text-2xl font-bold tracking-tight text-center text-white">
                    Admin Zone
                </h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form action="{{ route('admin.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-100">
                            Username
                        </label>
                        <div class="mt-2">
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required
                                autocomplete="username"
                                class="block py-2 px-3 w-full text-base placeholder-gray-500 text-white rounded-md outline-none sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 bg-white/5" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-sm font-medium text-gray-100">
                                Password
                            </label>
                        </div>
                        <div class="mt-2">
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="block py-2 px-3 w-full text-base placeholder-gray-500 text-white rounded-md outline-none sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 bg-white/5" />
                        </div>
                    </div>
                    <label for="Option1" class="inline-flex gap-3 items-center py-3">
                        <input type="checkbox"
                            class="my-0.5 bg-gray-900 rounded border-gray-300 border-gray-600 ring-offset-gray-900 shadow-sm checked:bg-blue-600 size-5"
                            name="rememberme" id="rememberme" />

                        <span class="font-medium text-gray-200"> Remember me </span>



                    </label>


                    <!-- Submit -->
                    <div>
                        <button type="submit"
                            class="flex justify-center py-2 px-3 w-full text-sm font-semibold text-white bg-indigo-500 rounded-md shadow-md hover:bg-indigo-400 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                            Login
                        </button>
                        <a href="{{ route('index') }}">
                            <div
                                class="p-2 mt-3 w-full text-center bg-indigo-500 rounded-md cursor-pointer hover:bg-indigo-400 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                                Upload
                                Folder</div>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Section -->
        <div class="hidden sm:flex sm:justify-center sm:items-center">
            <img src="/iconlogin.png" alt="{{ config('app.name') }}" class="mx-auto h-90" />
        </div>
    </div>
</x-htmlhead>
