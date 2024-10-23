@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Member</x-slot:title>

    <div class="bg-white rounded-lg p-5 grid lg:grid-cols-2 gap-4">
        <section>
            <h1 class="text-xl font-semibold text-center mb-6">Daftar Member Baru</h1>
            <form action="/cashier/member" method="post">
                @csrf
                <div class="mb-4">
                    <x-label for="name" input-name="name">
                        Nama Lengkap
                    </x-label>
                    <x-input type="text" name="name" id="name" value="{{ request()->old('name') }}"
                        placeholder="Nama member..." />
                </div>
                <div class="mb-4">
                    <x-label for="no_hp" input-name="no_hp">
                        Nomor Handphone
                    </x-label>
                    <x-input type="text" name="no_hp" id="no_hp" value="{{ request()->old('no_hp') }}"
                        placeholder="08xxxx" />
                </div>
                <div class="mb-4 flex gap-6">
                    <x-input-radio input-name="gender" value="male" checked>
                        Laki - laki
                    </x-input-radio>
                    <x-input-radio input-name="gender" value="female">
                        Perempuan
                    </x-input-radio>
                </div>

                <x-button class="w-full mt-4" type="submit">
                    Tambah Member
                </x-button>
            </form>
        </section>

        <section>
            <h1 class="text-xl font-semibold text-center mb-6">Pencarian Member</h1>
            <x-search-input />

            @isset($member)
                <dl class="max-w-md text-gray-900 divide-y divide-gray-200 mx-auto mt-5 text-sm">
                    <div class="flex flex-col pb-3">
                        <dt class="mb-1 text-gray-500">Nama Member</dt>
                        <dd class="text-base font-semibold">{{ $member->name }}</dd>
                    </div>
                    <div class="flex flex-col py-3">
                        <dt class="mb-1 text-gray-500">Nomor Handphone</dt>
                        <dd class="text-base font-semibold">{{ $member->no_hp }}</dd>
                    </div>
                    <div class="flex flex-col pt-3">
                        <dt class="mb-1 text-gray-500">Point Member</dt>
                        <dd class="text-base font-semibold">{{ $member->point }}</dd>
                    </div>
                    <div class="flex flex-col pt-3">
                        <dt class="mb-1 text-gray-500">Tanggal Dibuat</dt>
                        <dd class="text-base font-semibold">
                            {{ Carbon::parse($member->created_at)->isoFormat('DD MMMM G') }}</dd>
                    </div>
                </dl>
            @endisset

        </section>
    </div>

</x-cashier.layout>
