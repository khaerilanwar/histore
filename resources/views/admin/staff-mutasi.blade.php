@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>

    <x-slot:title>Mutasi Staff</x-slot:title>

    <div class="bg-white p-6 rounded-xl grid lg:grid-cols-2 gap-6">
        <div class="">
            <h2 class="text-center text-2xl font-medium">Biodata Staff</h2>
            <dl class="text-gray-900 divide-y divide-gray-200 mt-6 max-w-lg mx-auto">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">NIK Staff</dt>
                    <dd class="text-lg font-semibold">{{ $user->nik }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">NIK Penduduk</dt>
                    <dd class="text-lg font-semibold">{{ $user->staff->nik }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Nama Lengkap</dt>
                    <dd class="text-lg font-semibold">{{ $user->staff->name }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Tempat, Tanggal Lahir</dt>
                    <dd class="text-lg font-semibold">{{ $user->staff->ttl }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Toko Sekarang</dt>
                    <dd class="text-lg font-semibold">{{ $user->shop->name }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Tanggal Masuk</dt>
                    <dd class="text-lg font-semibold">
                        {{ Carbon::parse($user->staff->created_at)->isoFormat('DD MMMM G') }}</dd>
                </div>
            </dl>
        </div>
        <div class="">
            <h2 class="text-center text-2xl font-medium">Formulir Mutasi</h2>

            <form action="/admin/staff/mutasi/{{ $user->nik }}" method="post" class="max-w-lg mx-auto mt-6">
                @csrf
                @method('patch')
                <div class="mb-4">
                    <x-label for="shop" input-name="shop_id">Toko Tujuan Mutasi</x-label>
                    <x-input-select id="shop" name="shop_id" :items="$shops" />
                </div>

                <x-button class="w-full mt-2" type="submit">Kirim</x-button>
            </form>
        </div>
    </div>

</x-cashier.layout>
