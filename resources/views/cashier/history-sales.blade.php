@php
    use Illuminate\Support\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>History Transaction Sales</x-slot:title>

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full lg:w-1/3">
                <x-cashier.search-table />
            </div>
        </div>
        @if (count($histories) == 0)
            <p class="text-xl text-center pb-6">Belum ada data!</p>
        @else
            <div class="overflow-x-auto p-4">
                <x-cashier.table>
                    <x-slot:heading>
                        <tr>
                            <th scope="col" class="px-4 py-3 w-0">No.</th>
                            <th scope="col" class="px-4 py-3">Nomor Bon</th>
                            <th scope="col" class="px-4 py-3 text-center">Jumlah Produk</th>
                            <th scope="col" class="px-4 py-3">Jumlah Belanja</th>
                            <th scope="col" class="px-4 py-3">Tanggal Waktu</th>
                            <th scope="col" class="px-4 py-3">Member</th>
                        </tr>
                    </x-slot:heading>

                    <x-slot:body>
                        @foreach ($histories as $history)
                            <tr class="border-b ">
                                <td class="px-4 py-3">
                                    {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                                </td>
                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $history->id }}
                                </th>
                                <td class="px-4 py-3 text-center">
                                    {{ $history->transactionProducts->sum('quantity') }}
                                </td>
                                <td class="px-4 py-3">
                                    Rp. {{ number_format($history->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ Carbon::parse($history->transaction_date)->isoFormat('D MMM Y, HH:mm') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $history->member->name ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>
                </x-cashier.table>
            </div>
            {{ $histories->appends(['limit' => request('limit'), 's' => request('s')])->links('pagination::cashier') }}
        @endif
    </div>
</x-cashier.layout>
