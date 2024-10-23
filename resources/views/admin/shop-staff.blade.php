@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Staff Hi Store</x-slot:title>

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
                        <th scope="col" class="px-4 py-3">NIK Staff</th>
                        <th scope="col" class="px-4 py-3">Nama Staff</th>
                        <th scope="col" class="px-4 py-3">Tanggal Registrasi</th>
                        <th scope="col" class="px-4 py-3"></th>
                    </tr>
                </x-slot:heading>

                <x-slot:body>
                    @foreach ($shop->users as $staff)
                        <tr class="border-b ">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                            </td>
                            <td class="px-4 py-3">
                                {{ $staff->nik }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $staff->staff->name }}
                            </td>
                            <td class="px-4 py-3">
                                {{ Carbon::parse($staff->created_at)->isoFormat('DD MMMM G') }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-cashier.table>
        </div>
    </div>
</x-cashier.layout>
