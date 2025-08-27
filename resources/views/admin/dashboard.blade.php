<x-htmlhead :title="$title">

    <x-alertfunction></x-alertfunction>
    <div class="overflow-x-auto p-2">
        @if (!empty($dataFiles))
            <table class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700">
                <thead class="ltr:text-left rtl:text-right">
                    <tr class="*:font-medium *:text-gray-900 dark:*:text-white">
                        <th class="py-2 px-3 whitespace-nowrap">Original Title</th>
                        <th class="py-2 px-3 whitespace-nowrap">Created </th>
                        <th class="py-2 px-3 whitespace-nowrap">Expired</th>
                        <th class="py-2 px-3 text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($dataFiles as $item)
                        <tr class="*:text-gray-900 *:first:font-medium dark:*:text-white">
                            <td class="py-2 px-3 whitespace-nowrap">{{ $item['original'] }}</td>
                            <td class="py-2 px-3 whitespace-nowrap">{{ $item['created_at']->diffForHumans() }}</td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                @if (isset($item['expired_at']))
                                    {{ $item['expired_at']->diffForHumans() }}
                                @else
                                    No Expired
                                @endif
                            </td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                <div class="flex gap-4 justify-center items-center w-full">
                                    <form action="{{ route('destroy.files') }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $item['delete_token'] }}">
                                        <button type="submit"
                                            class="py-2 px-4 font-semibold text-white bg-red-600 rounded transition hover:bg-red-700">
                                            Delete Files </button>
                                    </form>
                                    <a href="{{ route('show.files', $item['uuid']) }}">
                                        <button class="p-3 bg-green-500 rounded cursor-pointer"
                                            type="submit">View</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-2 px-3 whitespace-nowrap">File Not found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <span> File Not Found</span>
        @endif
    </div>
</x-htmlhead>
