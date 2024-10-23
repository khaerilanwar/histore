@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Inventory</x-slot:title>
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
                <x-button data-modal-target="tambah-kategori" data-modal-toggle="tambah-kategori" type="button">
                    Tambah
                    Kategori</x-button>
            </div>
        </div>
        <div class="overflow-x-auto p-4">
            <x-cashier.table>
                <x-slot:heading>
                    <tr>
                        <th scope="col" class="px-4 py-3 w-0">No.</th>
                        <th scope="col" class="px-4 py-3">Kategori</th>
                        <th scope="col" class="px-4 py-3">Slogan</th>
                        <th scope="col" class="px-4 py-3 text-center">Jumlah Produk</th>
                        <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </x-slot:heading>

                <x-slot:body>
                    @foreach ($categories as $category)
                        <tr class="border-b ">
                            <td class="px-4 py-3">
                                {{ $loop->iteration + (Request::query('page', 1) - 1) * $limit }}.
                            </td>
                            <td class="px-4 py-3">
                                {{ $category->name }}
                            </td>
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                <span class="hidden lg:block">{{ $category->slogan }}</span>
                                <span class="lg:hidden">{{ Str::limit($category->slogan, 30, '...') }}</span>
                            </th>
                            <td class="px-4 py-3 text-center">
                                {{ $category->products->count() }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" data-modal-target="category-{{ $category->id }}"
                                    data-modal-toggle="category-{{ $category->id }}"
                                    class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Detail</button>

                                <button type="button" data-modal-target="edit-{{ $category->id }}"
                                    data-modal-toggle="edit-{{ $category->id }}"
                                    class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Edit</button>

                                <form action="/admin/category/{{ $category->slug }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-cashier.table>
        </div>
        {{ $categories->appends(['limit' => request('limit'), 's' => request('s')])->links('pagination::cashier') }}
    </div>

    {{-- Modal tambah kategori --}}
    <x-cashier.modal title="Tambah Kategori" modal-id="tambah-kategori" max-width="max-w-lg">
        <form action="/admin/category" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <x-label for="name" input-name="name">Nama Kategori</x-label>
                <x-input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="example: New Category" required />
            </div>
            <div class="mb-3">
                <x-label for="slogan" input-name="slogan">Slogan</x-label>
                <x-input type="text" id="slogan" name="slogan" value="{{ old('slogan') }}"
                    placeholder="example: This Category Very Great" required />
            </div>
            <div class="mb-3">
                <x-label for="image" input-name="image">Gambar</x-label>
                <x-input-file name="image" id="image" />
            </div>
            <x-button type="submit" class="w-full">Kirim</x-button>
        </form>
    </x-cashier.modal>

    @foreach ($categories as $category)
        {{-- Modal Edit Kategori --}}
        <x-cashier.modal title="Edit Kategori" modal-id="edit-{{ $category->id }}" max-width="max-w-lg">
            <form action="/admin/category/{{ $category->slug }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <x-label for="name" input-name="name">Nama Kategori</x-label>
                    <x-input type="text" name="name" value="{{ $category->name }}" disabled />
                </div>
                <div class="mb-3">
                    <x-label for="slogan" input-name="slogan">Slogan</x-label>
                    <x-input type="text" id="slogan" name="slogan" value="{{ $category->slogan }}" required />
                </div>
                <div class="mb-3">
                    <x-label for="image" input-name="image">Gambar</x-label>
                    <x-input-file name="image" id="image" />
                </div>
                <x-button type="submit" class="w-full">Kirim</x-button>
            </form>
        </x-cashier.modal>

        {{-- Modal Detail Kategori --}}
        <x-cashier.modal title="Detail Kategori" modal-id="category-{{ $category->id }}" max-width="max-w-lg">
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 mx-auto text-sm">
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500">Nama Kategori</dt>
                    <dd class="text-base font-semibold">{{ $category->name }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Slogan</dt>
                    <dd class="text-base font-semibold">
                        {{ $category->slogan }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Total Produk</dt>
                    <dd class="text-base font-semibold">
                        {{ $category->products->count() }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500">Tanggal dibuat</dt>
                    <dd class="text-base font-semibold">
                        {{ Carbon::parse($category->created_at)->isoFormat('DD MMMM GGGG') }}</dd>
                </div>

                <figure class="flex justify-center pt-3">
                    <img class="h-auto max-w-44 rounded-md shadow-slate-800 shadow-md"
                        src="{{ asset('storage/images/' . $category->image) }}" alt="image-{{ $category->name }}">
                </figure>
            </dl>
        </x-cashier.modal>
    @endforeach
</x-cashier.layout>
