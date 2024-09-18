<div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
    <img src="{{ asset('storage/images/' . $category->image) }}" alt="categories" class="rounded-md">
    <h5 class="mb-2 mt-6 text-2xl font-semibold tracking-tight text-gray-900">
        {{ $category->name }}</h5>
    <a href="#" class="inline-flex font-medium items-center text-blue-600 hover:underline">
        See our products
        <ion-icon name="arrow-forward"></ion-icon>
    </a>
</div>
