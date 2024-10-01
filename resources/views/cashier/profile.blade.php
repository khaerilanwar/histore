<x-cashier.layout>

    <x-slot:title>Cashier Profile</x-slot:title>

    <div class="bg-white p-5 grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <h2 class="text-center text-2xl font-medium">Data Diri</h2>
            <dl class="text-gray-900 divide-y divide-gray-200 mt-6">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500">NIK - Nama Lengkap</dt>
                    <dd class="text-lg font-semibold">{{ Auth::user()->nik . ' - ' . Auth::user()->name }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500">Alamat Email</dt>
                    <dd class="text-lg font-semibold">{{ Auth::user()->email }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500">Nomor Handphone</dt>
                    <dd class="text-lg font-semibold">{{ Auth::user()->no_hp }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Jabatan - Toko</dt>
                    <dd class="text-lg font-semibold">
                        {{ (Auth::user()->role === 2 ? 'Kasir' : 'Admin') . ' - ' . Auth::user()->shop->name }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h2 class="text-center text-2xl font-medium">Ganti Kata Sandi</h2>

            <form action="/cashier/profile/change-password" method="post" class="px-6 mt-6 pmb-4">
                @csrf
                <div class="mb-3">
                    <x-label for="oldpassword" input-name="oldpassword">
                        Kata Sandi Lama
                    </x-label>
                    <x-input type="password" name="oldpassword" id="oldpassword" placeholder="••••••••"
                        input-name="oldpassword" />
                </div>
                <div class="mb-3">
                    <x-label for="newpassword" input-name="newpassword">
                        Kata Sandi Baru
                    </x-label>
                    <x-input type="password" name="newpassword" id="newpassword" placeholder="••••••••"
                        input-name="newpassword" />
                </div>
                <div class="mb-3">
                    <x-label for="newpassword_confirmation" input-name="newpassword_confirmation">
                        Konfirmasi Kata Sandi Baru
                    </x-label>
                    <x-input type="password" name="newpassword_confirmation" id="newpassword_confirmation"
                        placeholder="••••••••" />
                </div>

                <x-button type="submit" class="w-full">
                    Konfirmasi
                </x-button>

            </form>
        </div>
    </div>

</x-cashier.layout>
