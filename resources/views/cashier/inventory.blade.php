<x-cashier.layout>
    <x-slot:title>Inventory</x-slot:title>

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full lg:w-1/3">
                <x-cashier.search-table />
            </div>
        </div>
        <div class="overflow-x-auto p-4">
            <x-cashier.table>
                <x-slot:heading>
                    <tr>
                        <th scope="col" class="px-4 py-3 w-0">No.</th>
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
</x-cashier.layout>
