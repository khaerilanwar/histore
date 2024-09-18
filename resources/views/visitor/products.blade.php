<x-visitor.layout :$categories>
    <x-visitor.title>
        <x-slot:title>
            {{ Request::is('products') ? 'All Products of' : $products[0]->category->name }} HiStore!
        </x-slot:title>
        {{-- <x-slot:description></x-slot:description> --}}
    </x-visitor.title>

    <section class=" py-8 antialiased ">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            {{ $products->links('pagination::visitor') }}
            <div class="my-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $index => $product)
                    <x-visitor.card-product :$index :$product />
                @endforeach
            </div>
            {{ $products->links('pagination::visitor') }}
        </div>
    </section>

</x-visitor.layout>
