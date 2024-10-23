@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Shops</x-slot:title>
    @if ($errors->any())
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 alert" role="alert">
            <ion-icon class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" name="alert"></ion-icon>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-1.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="flex justify-between w-full">
                <x-cashier.search-table />
                <x-button data-modal-target="tambah-shop" data-modal-toggle="tambah-shop" type="button">
                    Tambah
                    Toko</x-button>
            </div>
        </div>
        <div class="overflow-x-auto p-4">
            <x-cashier.table>
                <x-slot:heading>
                    <tr>
                        <th scope="col" class="px-4 py-3 w-0">No.</th>
                        <th scope="col" class="px-4 py-3">Kode Toko</th>
                        <th scope="col" class="px-4 py-3">Nama Toko</th>
                        <th scope="col" class="px-4 py-3">Alamat</th>
                        <th scope="col" class="px-4 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-4 py-3"></th>
                    </tr>
                </x-slot:heading>

                <x-slot:body>
                    @foreach ($shops as $shop)
                        <tr class="border-b ">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                            </td>
                            <td class="px-4 py-3">
                                {{ $shop->id }}
                            </td>
                            <th class="px-4 py-3 font-medium text-gray-900">
                                {{ $shop->name }}
                            </th>
                            <th class="px-4 py-3 font-medium text-gray-900">
                                {{ $shop->address }}
                            </th>
                            <td scope="row" class="px-4 py-3">
                                {{ Carbon::parse($shop->created_at)->isoFormat('DD MMMM G') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="/admin/shop/inventory/{{ $shop->id }}"
                                    class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Inventory</a>
                                <a href="/admin/shop/staff/{{ $shop->id }}"
                                    class="bg-gray-100 text-gray-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Staff</a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-cashier.table>
        </div>
        {{ $shops->appends(['limit' => request('limit'), 's' => request('s')])->links('pagination::cashier') }}
    </div>

    {{-- Modal tambah kategori --}}
    <x-cashier.modal title="Tambah Kategori" modal-id="tambah-shop" max-width="max-w-lg">
        <form action="/admin/shop" method="post">
            @csrf
            <div class="mb-3">
                <x-label for="id" input-name="id">Kode Toko</x-label>
                <x-input type="text" id="id" name="id" value="{{ old('id') }}" placeholder="XXXX"
                    required />
            </div>
            <div class="mb-3">
                <x-label for="name" input-name="name">Nama Toko</x-label>
                <x-input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Nama Toko Harus Unik" required />
            </div>
            <div class="mb-3">
                <x-label for="address" input-name="address">Alamat</x-label>
                <x-input type="text" id="address" name="address" value="{{ old('address') }}"
                    placeholder="Alamat Lengkap" required />
            </div>
            <x-button type="submit" class="w-full">Kirim</x-button>
        </form>
    </x-cashier.modal>
</x-cashier.layout>
