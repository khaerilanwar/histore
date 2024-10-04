<x-cashier.layout>

    <x-slot:title>Sales</x-slot:title>

    <div class="grid lg:grid-cols-12 gap-6">
        <section class="lg:col-span-8">
            <h1 class="text-center font-medium mb-4">Nomor Bon : {{ $bon }}</h1>
            <div class="w-full mb-4">
                <form class="flex items-center" method="POST" action="/cashier/sales/scan-product">
                    @csrf
                    <label for="barcode" class="sr-only">Scan here</label>
                    <input type="hidden" name="nomor_bon" value="{{ $bon }}">
                    @if ($transaction)
                        <input type="hidden" name="id-last-product"
                            value="{{ $transaction->transactionProducts[count($transaction->transactionProducts) - 1]->product->id }}">
                        <input type="hidden" name="quantity-last-product"
                            value="{{ $transaction->transactionProducts[count($transaction->transactionProducts) - 1]->quantity }}">
                    @endif
                    <input value="{{ request('s') }}" type="text" name="barcode" id="barcode"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-5 p-2"
                        placeholder="Scan product here!" required="" autocomplete="off" autofocus>
                </form>
            </div>

            <div class="relative overflow-x-auto">
                <x-cashier.table>
                    <x-slot:heading>
                        <tr>
                            <th scope="col" class="px-3 py-3 rounded-tl-lg w-0">
                                No.
                            </th>
                            <th scope="col" class="px-3 py-3 text-center">
                                Nama Produk
                            </th>
                            <th scope="col" class="px-3 py-3">
                                Harga
                            </th>
                            <th scope="col" class="px-3 py-3 text-center">
                                Jumlah
                            </th>
                            <th scope="col" colspan="2" class="px-3 py-3 rounded-tr-lg">
                                Sub Total
                            </th>
                        </tr>
                    </x-slot:heading>

                    @if ($transaction)
                        <x-slot:body>
                            @foreach ($transaction->transactionProducts as $saleProduct)
                                <tr class="bg-white">
                                    <td class="px-3 py-2">
                                        {{ $loop->iteration }}.
                                    </td>
                                    <th scope="row" class="px-3 py-2 font-medium text-gray-900 lg:hidden">
                                        {{ Str::limit($saleProduct->product->name, 20, '...') }}
                                    </th>
                                    <th scope="row" class="px-3 py-2 font-medium text-gray-900 hidden lg:table-cell">
                                        {{ $saleProduct->product->name }}
                                    </th>
                                    <td class="px-3 py-2" id="harga-produk-{{ $saleProduct->product->id }}">
                                        Rp {{ number_format($saleProduct->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <form class="max-w-xs mx-auto">
                                            <div class="relative flex items-center justify-center">
                                                <button onclick="decrementStock(this)" type="button"
                                                    id="decrement-button-{{ $saleProduct->product->id }}"
                                                    data-input-counter-decrement="input-stock-{{ $saleProduct->product->id }}"
                                                    class="flex-shrink-0 bg-gray-100 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                                    <ion-icon class="w-2.5 h-2.5 text-gray-900"
                                                        name="remove"></ion-icon>
                                                </button>
                                                <input name="quantity" type="text"
                                                    id="input-stock-{{ $saleProduct->product->id }}" data-input-counter
                                                    class="flex-shrink-0 text-gray-900 border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                    data-input-counter-min="0"
                                                    data-input-counter-max="{{ $saleProduct->product->stockshops->where('shop_id', Auth::user()->shop_id)->first()->stock }}"
                                                    value="{{ $saleProduct->quantity }}" />
                                                <button onclick="incrementStock(this)" type="button"
                                                    id="increment-button-{{ $saleProduct->product->id }}"
                                                    data-input-counter-increment="input-stock-{{ $saleProduct->product->id }}"
                                                    class="flex-shrink-0 bg-gray-100 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                                    <ion-icon class="w-2.5 h-2.5 text-gray-900"
                                                        name="add"></ion-icon>
                                                </button>
                                            </div>
                                        </form>

                                    </td>
                                    <td class="px-3 py-2 subtotal-produk"
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
                            <tr class="font-semibold text-gray-900 text-base">
                                <td></td>
                                <th scope="row" class="px-3 py-3" colspan="2">Total</th>
                                <td class="px-3 py-3 text-center" id="jumlah-produk">
                                    {{ $transaction->transactionProducts->sum('quantity') }}
                                </td>
                                <td class="px-3 py-3 total-belanja" colspan="2">
                                    {{ 'Rp ' . number_format($transaction->transactionProducts->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </x-slot:footer>
                    @endif

                </x-cashier.table>
            </div>
        </section>

        <section class="lg:col-span-4">
            <div class="flex justify-between">
                <p class="mb-4 font-medium">Member : {{ Request::session()->get('member_name') }}</p>
                @session('member_name')
                    <form action="/cashier/sales/remove-member" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit"><ion-icon class="text-red-600 text-2xl" name="close"></ion-icon></button>
                    </form>
                @endsession
            </div>
            <form class="flex items-center max-w-lg mx-auto mb-4" method="POST" action="/cashier/sales/cek-member">
                @csrf
                <label for="voice-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" id="voice-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-5 p-2"
                        placeholder="Input member" name="no_hp" required autocomplete="off" />
                </div>
                <button type="submit"
                    class="inline-flex items-center py-2 px-3 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Search
                </button>
            </form>

            <ol class="space-y-2">
                <li>
                    <x-cashier.sum-trans name-sum="paid-money" class="text-green-700 border-green-300 bg-green-50">
                        <x-slot:title>Uang Konsumen</x-slot:title>
                        <x-slot:value>Rp 0</x-slot:value>
                    </x-cashier.sum-trans>
                </li>
                <li>
                    <x-cashier.sum-trans name-sum="change-money" class="text-blue-700 bg-blue-100 border-blue-300">
                        <x-slot:title>Uang Kembalian</x-slot:title>
                        <x-slot:value>Rp 0</x-slot:value>
                    </x-cashier.sum-trans>
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

            <div class="flex justify-center mt-6">
                <form action="/cashier/sales/finish-transaction" method="post" class="w-full"
                    id="form-transaction">
                    @csrf
                    @if ($transaction)
                        <input type="hidden" name="id-last-product"
                            value="{{ $transaction->transactionProducts[count($transaction->transactionProducts) - 1]->product->id }}">
                        <input type="hidden" name="quantity-last-product"
                            value="{{ $transaction->transactionProducts[count($transaction->transactionProducts) - 1]->quantity }}">
                    @endif
                    <input type="hidden" name="nomor_bon" value="{{ $bon }}">
                    <input type="hidden" name="totalPriceFinish">
                    @session('member_id')
                        <input type="hidden" name="member_id" value="{{ $value }}">
                    @endsession
                    <button data-modal-target="confirm-modal" data-modal-toggle="confirm-modal" type="button"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xl px-5 py-3 text-center me-2 mb-2 w-full">Bayar
                        Sekarang</button>
                </form>
            </div>
        </section>
    </div>


    <!-- Main modal -->
    <div id="confirm-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Konfirmasi Transaksi
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="confirm-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    @session('member_name')
                        <p class="font-medium mb-4">Member : {{ $value }}</p>
                    @endsession
                    <ul class="space-y-4 mb-4">
                        <li>
                            <x-cashier.sum-trans name-sum="total-belanja"
                                class="text-gray-900 bg-gray-100 border-gray-300">
                                <x-slot:title>Total Belanja</x-slot:title>
                                <x-slot:value>{{ $transaction ? 'Rp ' . number_format($transaction->transactionProducts->sum('subtotal'), 0, ',', '.') : 'Rp 0' }}</x-slot:value>
                            </x-cashier.sum-trans>
                        </li>
                        <li>
                            <x-cashier.sum-trans name-sum="paid-money"
                                class="text-green-700 border-green-300 bg-green-50">
                                <x-slot:title>Uang Konsumen</x-slot:title>
                                <x-slot:value>Rp 0</x-slot:value>
                            </x-cashier.sum-trans>
                        </li>
                        <li>
                            <x-cashier.sum-trans name-sum="change-money"
                                class="text-blue-700 bg-blue-100 border-blue-300">
                                <x-slot:title>Uang Kembalian</x-slot:title>
                                <x-slot:value>Rp 0</x-slot:value>
                            </x-cashier.sum-trans>
                        </li>
                    </ul>
                    <button id="submit-trans"
                        class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.querySelector('#submit-trans').addEventListener('click', (e) => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            // Mengecek apakah user sudah menginputkan uang konsumen
            const valueMoney = document.getElementById('input-uang').value;
            const displayMoney = parseInt(document.querySelector('.paid-money').textContent.replace(/\D/g, ''))
            const totalShop = parseInt(document.querySelector('.total-belanja').textContent.replace(/\D/g, ''))

            if (!valueMoney || displayMoney == 0) {
                Toast.fire({
                    icon: "error",
                    title: "Konsumen belum bayar"
                });
            } else if (displayMoney - totalShop < 0) {
                Toast.fire({
                    icon: "error",
                    title: "Uang Konsumen Kurang"
                });
            } else {
                document.querySelector('#form-transaction').submit()
            }

        })
    </script>
</x-cashier.layout>
