@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>

    <x-slot:title>Tambah Staff HiStore!</x-slot:title>

    <div class="bg-white p-6 rounded-xl">
        <div class="max-w-xl mx-auto">
            <h2 class="text-center text-2xl font-medium">Formulir Staff</h2>

            <form action="/admin/staff" method="post" class="mt-6">
                @csrf
                <div class="mb-4">
                    <x-label for="nik" input-name="nik">NIK Penduduk</x-label>
                    <x-input type="text" name="nik" placeholder="3329XXXXX" id="nik"
                        value="{{ old('nik') }}" />
                </div>

                <div class="mb-4">
                    <x-label for="name" input-name="name">Nama Lengkap</x-label>
                    <x-input type="text" name="name" placeholder="Nama lengkap staff" id="name"
                        value="{{ old('name') }}" />
                </div>

                <div class="mb-4">
                    <x-label for="ttl" input-name="ttl">Tempat, Tanggal Lahir</x-label>
                    <x-input type="text" name="ttl" placeholder="Brebes, 07 Maret 2004" id="ttl"
                        value="{{ old('ttl') }}" />
                </div>

                <div class="mb-4">
                    <x-label for="email" input-name="email">Alamat Email</x-label>
                    <x-input type="text" name="email" placeholder="histore@example.com" id="email"
                        value="{{ old('email') }}" />
                </div>

                <div class="mb-4">
                    <x-label for="no_hp" input-name="no_hp">Nomor Handphone</x-label>
                    <x-input type="text" name="no_hp" placeholder="08xxxx" id="no_hp"
                        value="{{ old('no_hp') }}" />
                </div>

                <div class="mb-4">
                    <x-label for="alamat" input-name="alamat">Alamat Lengkap</x-label>
                    <textarea
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        name="alamat" id="alamat" cols="30" rows="3" placeholder="Jl. Gajah Mada No. xxxx">{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-4">
                    <x-label for="salary" input-name="salary">Gajih</x-label>
                    <x-input type="text" name="salary" class="input-rupiah" placeholder="Nominal gajih"
                        id="salary" value="{{ old('salary') }}" />
                </div>

                <div class="mb-4">
                    <x-label for="shop" input-name="shop_id">Toko Penempatan</x-label>
                    <x-input-select id="shop" name="shop_id" :items="$shops" />
                </div>

                <x-button class="w-full" type="submit">Kirim</x-button>

            </form>
        </div>
    </div>

</x-cashier.layout>
