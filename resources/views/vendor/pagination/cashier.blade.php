<nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
    aria-label="Table navigation">

    <div class="flex gap-3 justify-between items-center">
        <form class="max-w-sm mx-auto" method="GET" action="{{ Request::url() }}">
            @if (request('s'))
                <input type="hidden" name="s" value="{{ request('s') }}">
            @endif
            <label for="limit" class="mb-2 text-sm me-2 font-medium text-gray-900 dark:text-white">Rows per
                page</label>
            <select id="limit" name="limit"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                onchange="this.form.submit()">
                <option value="5" {{ Request::query('limit') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ Request::query('limit') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ Request::query('limit') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ Request::query('limit') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ Request::query('limit') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </form>

        <span class="text-sm font-normal text-gray-500 ">
            Showing
            <span class="font-semibold text-gray-900 ">
                @if ($paginator->firstItem())
                    {{ $paginator->firstItem() }} -
                    {{ $paginator->lastItem() }}
                @else
                    {{ $paginator->count() }}
                @endif
            </span>
            of
            <span class="font-semibold text-gray-900 ">{{ $paginator->total() }}</span>
        </span>
    </div>

    <ul class="inline-flex items-stretch -space-x-px">
        @if ($paginator->onFirstPage())
            <li>
                <span
                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300">
                    <ion-icon name="chevron-back" class="w-5 h-5"></ion-icon>
                </span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                    <span class="sr-only">Previous</span>
                    <ion-icon name="chevron-back" class="w-5 h-5"></ion-icon>
                </a>
            </li>
        @endif

        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                    <span class="sr-only">Next</span>
                    <ion-icon name="chevron-forward" class="w-5 h-5"></ion-icon>
                </a>
            </li>
        @else
            <li>
                <span
                    class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300">
                    <ion-icon name="chevron-forward" class="w-5 h-5"></ion-icon>
                </span>
            </li>
        @endif
    </ul>
</nav>
