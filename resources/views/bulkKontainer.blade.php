<x-htmlhead :title="$title">
    @php
    function human_filesize($bytes, $decimals = 2) {
        $size = ['B','KB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
@endphp
<div class="relative overflow-x-auto m-5 shadow-md sm:rounded-lg">
    <x-alertfunction></x-alertfunction>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Original name
                </th>
                <th scope="col" class="px-6 py-3">
                    Url
                </th>
                <th scope="col" class="px-6 py-3">
                    Size
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($files as $key => $items)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$items->original}}
                </th>
                <td class="px-6 py-4">
                    <a target="_blank" class="text-blue-400 font-semibold text-decoration-underline hover:underline to-blue-400" href="{{route('show.files',[$items['uuid']])}}">View More</a>
                </td>
    
                <td class="px-6 py-4">
                    {{human_filesize($items->size,1)}}
                </td>
                <td class="px-6 py-4">
                    <form action="{{ route('desbulk') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="token" value="{{ $items->delete_token }}">
                        <button type="submit" class="px-4 cursor-crosshair py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                            Delete Files
                        </button>
                    </form>
                </td>
            </tr>
            @empty
                
            @endforelse
        </tbody>
    </table>
</div>

</x-htmlhead>