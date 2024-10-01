<div class="w-full p-4 border rounded-lg {{ $attributes->get('class') }}" role="alert">
    <div class="flex items-center justify-between">
        <h3 class="font-medium">{{ $title }}</h3>
        <h3 class="font-medium {{ $attributes->get('name-sum') }}">{{ $value ?? '' }}</h3>
    </div>
</div>
