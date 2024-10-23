@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>

    <x-slot:title>Cashier Profile</x-slot:title>

    <div class="bg-white p-6 rounded-xl">
        <div class="max-w-xl mx-auto">
            <h2 class="text-center text-2xl font-medium">Biodata Staff</h2>
            <dl class="text-gray-900 divide-y divide-gray-200 mt-6">
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
                    <dt class="mb-1 text-gray-500">Alamat Email</dt>
                    <dd class="text-lg font-semibold">{{ $user->staff->email }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Nomor Ponsel</dt>
                    <dd class="text-lg font-semibold">{{ $user->staff->no_hp }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Alamat Lengkap</dt>
                    <dd class="text-lg font-semibold">{{ $user->staff->alamat }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Gajih</dt>
                    <dd class="text-lg font-semibold">Rp. {{ number_format($user->staff->salary, 0, ',', '.') }}</dd>
                </div>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">Tanggal Masuk</dt>
                    <dd class="text-lg font-semibold">
                        {{ Carbon::parse($user->staff->created_at)->isoFormat('DD MMMM G') }}</dd>
                </div>
            </dl>
        </div>
    </div>

</x-cashier.layout>
