<x-cashier.layout>
    <x-slot:title>Sales</x-slot:title>

    <div class="grid grid-cols-12 gap-6">
        <section class="col-span-8">
            <h1 class="text-center font-medium mb-4">Nomor Bon : {{ $bon }}</h1>
            <div class="w-full mb-4">
                <form class="flex items-center" method="POST" action="/cashier/sales/scan-product">
                    @csrf
                    <label for="barcode" class="sr-only">Scan here</label>
                    <input type="hidden" name="bon" value="{{ $bon }}">
                    <input value="{{ request('s') }}" type="text" name="barcode" id="barcode"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-5 p-2"
                        placeholder="Scan product here!" required="" autocomplete="off" autofocus>
                </form>
            </div>

            <div class="relative overflow-x-auto">
                <x-cashier.table>
                    <x-slot:heading>
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-tl-lg w-0">
                                No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Produk
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Harga
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Jumlah
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3 rounded-tr-lg">
                                Sub Total
                            </th>
                        </tr>
                    </x-slot:heading>

                    <x-slot:body>
                        @foreach ($transaction as $saleProduct)
                            <tr class="bg-white">
                                <td class="px-6 py-2">
                                    {{ $loop->iteration }}.
                                </td>
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 lg:hidden">
                                    {{ Str::limit($saleProduct->product->name, 20, '...') }}
                                </th>
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 hidden lg:table-cell">
                                    {{ $saleProduct->product->name }}
                                </th>
                                <td class="px-6 py-2" id="harga-produk-{{ $saleProduct->product->id }}">
                                    Rp {{ number_format($saleProduct->product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-2">
                                    <form class="max-w-xs mx-auto">
                                        <div class="relative flex items-center justify-center">
                                            <button onclick="decrementStock(this)" type="button" id="decrement-button"
                                                data-input-counter-decrement="input-stock-{{ $saleProduct->product->id }}"
                                                class="flex-shrink-0 bg-gray-100 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                                <ion-icon class="w-2.5 h-2.5 text-gray-900" name="remove"></ion-icon>
                                            </button>
                                            <input name="quantity" type="text"
                                                id="input-stock-{{ $saleProduct->product->id }}" data-input-counter
                                                class="flex-shrink-0 text-gray-900 border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                data-input-counter-min="0"
                                                data-input-counter-max="{{ $saleProduct->product->stock }}"
                                                value="{{ $saleProduct->quantity }}" required />
                                            <button onclick="incrementStock(this)" type="button" id="increment-button"
                                                data-input-counter-increment="input-stock-{{ $saleProduct->product->id }}"
                                                class="flex-shrink-0 bg-gray-100 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                                <ion-icon class="w-2.5 h-2.5 text-gray-900" name="add"></ion-icon>
                                            </button>
                                        </div>
                                    </form>

                                </td>
                                <td class="px-6 py-2 subtotal-produk"
                                    id="subtotal-produk-{{ $saleProduct->product->id }}">
                                    Rp {{ number_format($saleProduct->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="px-3">
                                    <form action="/cashier/sales/remove-product" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id-transaksi-produk"
                                            value="{{ $saleProduct->id }}">
                                        <button type="submit">
                                            <ion-icon class="text-red-600 text-2xl" name="close"></ion-icon>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>

                    <x-slot:footer>
                        <tr class="font-semibold text-gray-900">
                            <td></td>
                            <th scope="row" class="px-6 py-3 text-base" colspan="2">Total</th>
                            <td class="px-6 py-3 text-center" id="jumlah-produk">{{ $transaction->sum('quantity') }}
                            </td>
                            <td class="px-6 py-3 total-belanja">
                                {{ 'Rp ' . number_format($transaction->sum('subtotal'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </x-slot:footer>

                </x-cashier.table>
            </div>
        </section>

        <section class="col-span-4">
            <p class="mb-4 font-medium">Member : </p>
            <form class="flex items-center max-w-lg mx-auto mb-4">
                <label for="voice-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" id="voice-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-5 p-2"
                        placeholder="Input member" required />
                </div>
                <button type="submit"
                    class="inline-flex items-center py-2 px-3 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Search
                </button>
            </form>


            <ol class="space-y-2">
                <li>
                    <div class="w-full p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400"
                        role="alert">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium">Total Belanja</h3>
                            <h3 class="font-medium total-belanja">
                                {{ 'Rp ' . number_format($transaction->sum('subtotal'), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="w-full p-4 text-blue-700 bg-blue-100 border border-blue-300 rounded-lg dark:bg-gray-800 dark:border-blue-800 dark:text-blue-400"
                        role="alert">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium">Uang Konsumen</h3>
                            <h3 class="font-medium" id="paid-money">Rp 0</h3>
                        </div>
                    </div>
                </li>
            </ol>


            <h3 class="text-2xl text-center font-semibold my-4">Perkiraan Uang Konsumen</h3>

            <div class="flex items-center mx-auto">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">

                        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            id="rupiah">
                            <path fill="#231f20"
                                d="M183.41 314.1L146.18 245H140.6V314.1H88.48V126.64h82.16q22.61 0 38.29 7.84T232.6 156a59.88 59.88 0 0 1 8 30.71q0 19.16-10.51 33.64T199.36 241l42.28 73.12zM140.6 209.33h25.79q10.63 0 16-5.05t5.31-14.62q0-9-5.45-14.23t-15.82-5.19H140.6zM333.64 169.18q11.17-6.12 26.33-6.11a58.61 58.61 0 0 1 32.31 9.3q14.49 9.31 22.86 26.59t8.38 40.42q0 23.13-8.38 40.55t-22.86 26.73A58.61 58.61 0 0 1 360 316q-15.15 0-26.19-6.11a46.52 46.52 0 0 1-17.42-16.49v92H264.24V164.93h52.12v20.74A44.29 44.29 0 0 1 333.64 169.18zm29.12 47.47a26.82 26.82 0 0 0-38.56.13q-7.84 8.25-7.84 22.6 0 14.63 7.84 22.87a26.53 26.53 0 0 0 38.56-.13q7.85-8.39 7.85-22.74Q370.61 224.76 362.76 216.65z">
                            </path>
                        </svg>
                    </div>
                    <input type="text" id="input-uang"
                        class="bg-gray-50 border border-gray-300 text-gray-900 font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                        placeholder="Input Uang Konsumen" autocomplete="off" />
                </div>
                <button type="button"
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                    id="process-money">
                    Proses
                </button>
                <button type="button"
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300"
                    id="clear-money">
                    Clear
                </button>
            </div>

            <div class="grid grid-cols-4 gap-3 my-6">
                @php
                    $money_consument = [5000, 10000, 15000, 20000, 25000, 50000, 75000, 100000];
                @endphp
                @foreach ($money_consument as $item)
                    <x-cashier.button-price>
                        {{ number_format($item, 0, ',', '.') }}
                    </x-cashier.button-price>
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                <button type="submit"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xl px-5 py-3 text-center me-2 mb-2 w-full">Bayar
                    Sekarang</button>
            </div>
        </section>
    </div>

</x-cashier.layout>
