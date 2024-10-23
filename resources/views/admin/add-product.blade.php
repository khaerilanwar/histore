@php
    use Carbon\Carbon;
@endphp

<x-cashier.layout>
    <x-slot:title>Produk Baru</x-slot:title>

    <div class="bg-white rounded-lg p-6">
        <div class="grid grid-cols-2 gap-8">
            <form action="/admin/product/new" method="POST" id="form-add-product" enctype="multipart/form-data">
                @csrf
                <h2 class="text-center font-semibold text-xl mb-6">Form Tambah Produk</h2>
                <div
                    class="mb-4 {{ Request::session()->get('barcodeNewProduct') || old('barcode') ? 'block' : 'hidden' }}">
                    <x-label for="barcode" input-name="barcode">Barcode</x-label>
                    <x-input type="text" name="barcode" id="barcode"
                        value="{{ Request::session()->get('barcodeNewProduct') ?? old('barcode') }}" readonly />
                </div>
                <div class="mb-4">
                    <x-label for="name" input-name="name">Nama Produk</x-label>
                    <x-input type="text" name="name" placeholder="Nama produk" id="name" autocomplete="off"
                        value="{{ old('name') }}" />
                </div>
                <div class="mb-4">
                    <x-label for="price-buy" input-name="price_buy">Harga Beli</x-label>
                    <x-input type="text" name="price_buy" placeholder="Harga beli satuan" class="input-rupiah"
                        id="price-buy" value="{{ old('price_buy') }}" />
                </div>
                <div class="mb-4">
                    <x-label for="price-sell" input-name="price">Harga Jual</x-label>
                    <x-input type="text" name="price" placeholder="Harga jual satuan" value="{{ old('price') }}"
                        class="input-rupiah" id="price-sell" />
                </div>
                <div class="mb-4">
                    <x-label for="category" input-name="category">Kategori Produk</x-label>
                    <x-input-select id="category" name="category_id" :items="$categories" />
                </div>
                <div class="mb-4">
                    <x-label for="images" input-name="images">Gambar-gambar Produk</x-label>
                    <x-input-file name="images[]" multiple id="images" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Max size 1 MB,
                        Multiple images</p>
                    @error('images.*')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">
                                {{ $message }}
                        </p>
                    @enderror
                </div>

                <x-button class="w-full mt-4" type="submit">Tambah Produk</x-button>
            </form>
            <div>
                <h2 class="text-center font-semibold text-xl mb-6">Cek Produk</h2>
                <form class="flex items-center max-w-md mx-auto" method="POST" action="/admin/product/check">
                    @csrf
                    <label for="barcode" class="sr-only">Scan here</label>
                    <input type="text" name="barcode" id="barcode"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-5 p-2"
                        placeholder="{{ session()->get('product') ? session()->get('product')->barcode : 'Scan new product here!' }}"
                        autocomplete="off" autofocus>
                </form>

                @session('product')
                    <h3 class="text-center font-medium text-xl mt-4">Detail Produk</h3>
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 mx-auto mt-5 text-sm">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500">Barcode</dt>
                            <dd class="text-base font-semibold">{{ $value->barcode }}</dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500">Nama Produk</dt>
                            <dd class="text-base font-semibold">{{ $value->name }}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500">Harga Beli</dt>
                            <dd class="text-base font-semibold">Rp. {{ number_format($value->price_buy, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500">Harga Jual</dt>
                            <dd class="text-base font-semibold">Rp. {{ number_format($value->price, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500">Kategori Produk</dt>
                            <dd class="text-base font-semibold">
                                {{ $value->category->name }}</dd>
                        </div>
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-gray-500">Tanggal dibuat</dt>
                            <dd class="text-base font-semibold">
                                {{ Carbon::parse($value->created_at)->isoFormat('DD MMMM GGGG') }}</dd>
                        </div>
                    </dl>
                @endsession
            </div>
        </div>
    </div>

    <script>
        try {
            const elementInputs = document.querySelectorAll('#form-add-product input')
            const barcodeInput = document.querySelector('input[name="barcode"]')
            if (!barcodeInput.value) {
                const inputSelect = document.querySelector('#form-add-product select')
                inputSelect.setAttribute('disabled', 'true')
                for (let input of elementInputs) {
                    input.setAttribute('disabled', 'true')
                }
            }
        } catch (error) {

        }
    </script>
</x-cashier.layout>
