{{-- @dd($notifications[4]->shop->toArray()) --}}

<x-cashier.layout>
    <x-slot:title>Inventory</x-slot:title>

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="flex justify-between w-full">
                <x-cashier.search-table />
                <button id="dropdownNotificationButton" data-dropdown-placement="left-end"
                    data-dropdown-toggle="dropdownNotification" type="button"
                    class="relative inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <ion-icon name="layers" size="small" class="me-2"></ion-icon>
                    <span class="sr-only">Notifications</span>
                    Messages
                    <div
                        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2">
                        {{ count($notifications) }}</div>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto p-4">
            <x-cashier.table>
                <x-slot:heading>
                    <tr>
                        <th scope="col" class="px-4 py-3 w-0">No.</th>
                        <th scope="col" class="px-4 py-3 w-0">Barcode</th>
                        <th scope="col" class="px-4 py-3">Nama Produk</th>
                        <th scope="col" class="px-4 py-3">Kategori</th>
                        <th scope="col" class="px-4 py-3">Harga</th>
                        <th scope="col" class="px-4 py-3">Stok</th>
                    </tr>
                </x-slot:heading>

                <x-slot:body>
                    @foreach ($products as $product)
                        <tr class="border-b ">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                            </td>
                            <td class="px-4 py-3">
                                {{ $product->barcode }}
                            </td>
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap ">
                                {{ $product->name }}
                            </th>
                            <td class="px-4 py-3">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-4 py-3">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $product->stock }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-cashier.table>
        </div>
        {{ $products->appends(['limit' => request('limit'), 's' => request('s')])->links('pagination::cashier') }}
    </div>

    <!-- Dropdown menu -->
    <div id="dropdownNotification"
        class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow"
        aria-labelledby="dropdownNotificationButton">
        <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50">
            Notifications
        </div>
        <div class="divide-y divide-gray-100">
            @for ($i = 0; $i < (count($notifications) < 4 ? count($notifications) : 4); $i++)
                <a href="/cashier/notification/{{ $notifications[$i]->id }}"
                    class="px-4 py-3 {{ count($notifications) === 1 ? '' : 'flex hover:bg-gray-100' }}">
                    <div
                        class="w-full ps-3 {{ $notifications[$i]->status == 'public' ? 'bg-green-200' : 'bg-yellow-100' }} p-2 rounded-md">
                        <div class="text-gray-800 text-sm mb-1.5">
                            {{ Str::limit($notifications[$i]->description, 70, ' ...') }}
                        </div>
                        <div class="text-xs text-blue-600">{{ $notifications[$i]->updated_at->diffForHumans() }}</div>
                    </div>
                </a>
            @endfor
        </div>
        <div class="text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100">
            <button type="button" data-modal-target="notif-modal" data-modal-toggle="notif-modal"
                class="inline-flex items-center w-full justify-center py-2">
                <svg class="w-4 h-4 me-2 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 14">
                    <path
                        d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                </svg>
                View all
            </button>
        </div>
    </div>

    <x-cashier.modal modalId="notif-modal" title="Notifications">
        @foreach ($notifications as $notification)
            <li>
                <x-cashier.detail-notif :$notification />
            </li>
        @endforeach
    </x-cashier.modal>
</x-cashier.layout>
