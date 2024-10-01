<x-cashier.layout>
    <x-slot:title>Overview</x-slot:title>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-10 mb-4">

        <x-cashier.card-resume>
            <x-slot:title>Total Sales</x-slot:title>
            <x-slot:value>{{ 'Rp. ' . number_format($sales, 0, ',', '.') }}</x-slot:value>
        </x-cashier.card-resume>

        <x-cashier.card-resume>
            <x-slot:title>Total Transactions</x-slot:title>
            <x-slot:value>{{ number_format($transactions, 0, ',', '.') }}</x-slot:value>
        </x-cashier.card-resume>

        <x-cashier.card-resume>
            <x-slot:title>Total Retur</x-slot:title>
            <x-slot:value>{{ number_format($retur, 0, ',', '.') }}</x-slot:value>
        </x-cashier.card-resume>

        <x-cashier.card-resume>
            <x-slot:title>Sold Products</x-slot:title>
            <x-slot:value>{{ number_format($sold, 0, ',', '.') }}</x-slot:value>
        </x-cashier.card-resume>

    </div>

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        @if ($soldProducts->count() !== 0)
            <div class="overflow-x-auto">
                <x-cashier.table>
                    <x-slot:caption>
                        <x-cashier.caption-table>
                            <x-slot:title>Sold products</x-slot:title>

                            <x-slot:description>
                                Browse a list of Flowbite products designed to help
                                you work and play, stay organized, get answers, keep in touch, grow your business, and
                                more.
                            </x-slot:description>

                        </x-cashier.caption-table>
                    </x-slot:caption>

                    <x-slot:heading>
                        <tr>
                            <th scope="col" class="px-4 py-3 w-0">No.</th>
                            <th scope="col" class="px-4 py-3 w-0 text-center">Barcode</th>
                            <th scope="col" class="px-4 py-3">Nama Produk</th>
                            <th scope="col" class="px-4 py-3">Kategori</th>
                            <th scope="col" class="px-4 py-3">Terjual</th>
                            <th scope="col" class="px-4 py-3">Stok</th>
                        </tr>
                    </x-slot:heading>

                    <x-slot:body>
                        @foreach ($soldProducts as $soldProduct)
                            <tr class="border-b ">
                                <td class="px-4 py-3">
                                    {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                                </td>
                                <td class="px-4 py-3">
                                    {{ $soldProduct->barcode }}
                                </td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap hidden lg:table-cell">
                                    {{ $soldProduct->nama_produk }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap lg:hidden">
                                    {{ Str::limit($soldProduct->nama_produk, 20, ' ...') }}
                                </th>
                                <td class="px-4 py-3">
                                    {{ $soldProduct->nama_kategori }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $soldProduct->terjual }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $soldProduct->stok_produk }}
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>

                </x-cashier.table>
            </div>
            {{ $soldProducts->appends(['limit' => request('limit')])->links('pagination::cashier') }}
        @else
            <h1 class="text-center text-xl font-medium my-6">Belum ada produk terjual!</h1>
        @endif
    </div>
</x-cashier.layout>
