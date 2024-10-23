@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Inventory</x-slot:title>

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="flex justify-between w-full">
                <x-cashier.search-table />
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
                        <th scope="col" class="px-4 py-3">Harga Beli</th>
                        <th scope="col" class="px-4 py-3">Harga Jual</th>
                        <th scope="col" class="px-4 py-3 text-center">Aksi</th>
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
                                {{ $product->category->name }}
                            </td>
                            <td class="px-4 py-3">
                                Rp. {{ number_format($product->price_buy, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" data-modal-target="product-{{ $product->id }}"
                                    data-modal-toggle="product-{{ $product->id }}"
                                    class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Detail</button>

                                <button type="button" data-modal-target="edit-{{ $product->id }}"
                                    data-modal-toggle="edit-{{ $product->id }}"
                                    class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Edit</button>

                                <form action="/admin/product/{{ $product->barcode }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-cashier.table>
        </div>
        {{ $products->appends(['limit' => request('limit'), 's' => request('s')])->links('pagination::cashier') }}
    </div>

    @foreach ($products as $product)
        {{-- Modal Edit Produk --}}
        <x-cashier.modal title="Edit Produk" modal-id="edit-{{ $product->id }}" max-width="max-w-lg">
            <form action="/admin/product/{{ $product->barcode }}" method="post">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <x-label for="name" input-name="name">Nama Produk</x-label>
                    <x-input type="text" value="{{ $product->name }}" disabled />
                </div>
                <div class="mb-3">
                    <x-label for="price-buy" input-name="price_buy">Harga Beli</x-label>
                    <x-input type="text" id="price-buy" name="price_buy" class="input-rupiah"
                        value="Rp. {{ number_format($product->price_buy, 0, ',', '.') }}" required />
                </div>
                <div class="mb-3">
                    <x-label for="price-discount" input-name="price_discount">Harga Diskon</x-label>
                    <x-input type="text" id="price-discount" name="price_discount" class="input-rupiah"
                        value="Rp. {{ number_format($product->price_discount, 0, ',', '.') }}" />
                </div>
                <div class="mb-3">
                    <x-label for="price" input-name="price">Harga Jual</x-label>
                    <x-input type="text" id="price" name="price" class="input-rupiah"
                        value="Rp. {{ number_format($product->price, 0, ',', '.') }}" required />
                </div>
                <x-button type="submit" class="w-full">Kirim</x-button>
            </form>
        </x-cashier.modal>

        {{-- Modal Detail Produk --}}
        <x-cashier.modal title="Detail Produk" modal-id="product-{{ $product->id }}" max-width="max-w-lg">
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 mx-auto text-sm">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Barcode</dt>
                    <dd class="text-base font-semibold">{{ $product->barcode }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500">Nama Produk</dt>
                    <dd class="text-base font-semibold">{{ $product->name }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Harga Beli</dt>
                    <dd class="text-base font-semibold">Rp. {{ number_format($product->price_buy, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Harga Jual</dt>
                    <dd class="text-base font-semibold">Rp. {{ number_format($product->price, 0, ',', '.') }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Harga Diskon</dt>
                    <dd class="text-base font-semibold">Rp. {{ number_format($product->price_discount, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Kategori Produk</dt>
                    <dd class="text-base font-semibold">
                        {{ $product->category->name }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Total Stok</dt>
                    <dd class="text-base font-semibold">
                        {{ $product->stockShops->sum('stock') }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Tanggal dibuat</dt>
                    <dd class="text-base font-semibold">
                        {{ Carbon::parse($product->created_at)->isoFormat('DD MMMM GGGG') }}</dd>
                </div>
            </dl>
        </x-cashier.modal>
    @endforeach
</x-cashier.layout>
