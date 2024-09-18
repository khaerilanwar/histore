<x-visitor.layout :$categories>
    <x-visitor.title>
        <x-slot:title>Welcome to HiStore!</x-slot:title>
    </x-visitor.title>

    {{-- Carousel Card Categories --}}
    <section class="bg-white px-4 py-8 antialiased max-w-screen-xl mx-auto md:p-12 lg:px-16">
        <h1 class="text-3xl mb-3 font-semibold">Categories of Hi Store!</h1>
        <section class="splide category-splide" aria-label="Categories of Hi Store!">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($categories as $category)
                        <li class="splide__slide">
                            <x-visitor.category-card :$category />
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </section>
    {{-- End Carousel Card Categories --}}

</x-visitor.layout>
