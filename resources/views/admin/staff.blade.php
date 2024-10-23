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

            <a href="/admin/staff/add"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">Tambah
                Staff</a>
        </div>
        <div class="overflow-x-auto p-4">
            <x-cashier.table>
                <x-slot:heading>
                    <tr>
                        <th scope="col" class="px-4 py-3 w-0">No.</th>
                        <th scope="col" class="px-4 py-3">NIK Staff</th>
                        <th scope="col" class="px-4 py-3">Nama Staff</th>
                        <th scope="col" class="px-4 py-3">Toko Penempatan</th>
                        <th scope="col" class="px-4 py-3">Tanggal Registrasi</th>
                        <th scope="col" class="px-4 py-3"></th>
                    </tr>
                </x-slot:heading>

                <x-slot:body>
                    @foreach ($users as $user)
                        <tr class="border-b ">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                            </td>
                            <td class="px-4 py-3">
                                {{ $user->nik }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $user->staff->name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ "{$user->shop->name} ({$user->shop->id})" }}
                            </td>
                            <td class="px-4 py-3">
                                {{ Carbon::parse($user->created_at)->isoFormat('DD MMMM G') }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="/admin/staff/biodata/{{ $user->nik }}"
                                    class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Biodata
                                </a>
                                <a href="/admin/staff/mutasi/{{ $user->nik }}"
                                    class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Mutasi
                                </a>
                                <button type="button" data-modal-target="resignModal{{ $user->nik }}"
                                    data-modal-toggle="resignModal{{ $user->nik }}"
                                    class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Resign
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-cashier.table>
        </div>
        {{ $users->appends(['limit' => request('limit'), 's' => request('s')])->links('pagination::cashier') }}
    </div>

    @foreach ($users as $user)
        <x-modal-confirm>
            <x-slot:idModal>resignModal{{ $user->nik }}</x-slot:idModal>
            Apakah karyawan tersebut yakin resign ?
        </x-modal-confirm>
    @endforeach
</x-cashier.layout>
