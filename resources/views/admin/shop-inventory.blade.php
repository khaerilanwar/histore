@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Shop Inventory</x-slot:title>

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="flex justify-between">
                <x-cashier.search-table />
            </div>
            <div class="bg-blue-600 py-2.5 px-5 text-white rounded-xl">
                {{ $shop->id . ' - ' . $shop->name }}
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
                        <th scope="col" class="px-4 py-3">Stok Toko</th>
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
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                <span class="hidden lg:block">{{ Str::limit($product->name, 35, '...') }}</span>
                                <span class="lg:hidden">{{ Str::limit($product->name, 20, '...') }}</span>
                            </th>
                            <td class="px-4 py-3">
                                {{ $product->kategori }}
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

</x-cashier.layout>
