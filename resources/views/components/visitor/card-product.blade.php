<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm ">
    <div class="w-full">
        <section class="splide" id="splide{{ $index }}" data-splide='{"arrows":false, "pagination":false}'>
            <div class="splide__track">
                <ul class="splide__list">
                    @php
                        $images = explode(' -- ', $product->images);
                    @endphp
                    @foreach ($images as $image)
                        <li class="splide__slide">
                            <img src="{{ asset('storage/images/' . $image) }}" alt="logo" class="rounded-md">
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>
    <div class="pt-6">

        <a href="#"
            class="text-lg font-semibold leading-tight text-gray-900 hover:underline ">{{ $product->name }}</a>

        <ul class="mt-2 flex items-center gap-4">
            <li class="flex items-center gap-2">
                <ion-icon name="bookmarks-outline" class="text-gray-500"></ion-icon>
                <p class="text-sm font-medium text-gray-500 ">{{ ucwords($product->category->name) }}
                </p>
            </li>
            <li class="flex items-center gap-2">
                <ion-icon name="file-tray-outline" class="text-gray-500"></ion-icon>
                <p class="text-sm font-medium text-gray-500 ">Stok : {{ $product->stock }}</p>
            </li>
        </ul>

        <div class="mt-4 flex items-center justify-between gap-4">
            <p class="text-2xl font-bold leading-tight text-gray-900 ">
                {{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
