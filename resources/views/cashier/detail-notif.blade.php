@php
    use Illuminate\Support\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Detail Notifikasi</x-slot:title>
    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <h3 class="text-center text-xl font-medium my-4">Produk Masuk Toko {{ $notif->shop->name }}</h3>
        <div class="overflow-x-auto p-4">
            <x-cashier.table>
                <x-slot:heading>
                    <tr>
                        <th scope="col" class="px-4 py-3 w-0">No.</th>
                        <th scope="col" class="px-4 py-3">Barcode</th>
                        <th scope="col" class="px-4 py-3">Nama Produk</th>
                        <th scope="col" class="px-4 py-3">Kategori</th>
                        <th scope="col" class="px-4 py-3 text-center">Stok Masuk</th>
                    </tr>
                </x-slot:heading>

                <x-slot:body>
                    @foreach ($notif->inproducts as $product)
                        <tr class="border-b ">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + (Request::query('page', 1) - 1) }}.
                            </td>
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap w-0">
                                {{ $product->product->barcode }}
                            </th>
                            <td class="px-4 py-3">
                                {{ $product->product->name }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $product->product->category->name }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ $product->stock_in }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>

                <x-slot:footer>
                    <tr>
                        <td class="text-gray-900 font-medium text-base" colspan="3">Tanggal :
                            {{ Carbon::parse($notif->created_at)->isoFormat('D MMMM Y') }}</td>
                        <td colspan="2" class="text-end">
                            <form action="/cashier/notification/{{ $notif->id }}" method="post">
                                @csrf
                                <x-button class="mt-4" type="submit">Konfirmasi Barang Masuk</x-button>
                            </form>
                        </td>
                    </tr>
                </x-slot:footer>
            </x-cashier.table>
        </div>
    </div>
</x-cashier.layout>
