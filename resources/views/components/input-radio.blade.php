<div class="flex items-center ps-4 border border-gray-200 rounded w-full">
    <input {{ $attributes }} id="{{ $inputName . '-' . $attributes->get('value') }}" type="radio"
        name="{{ $inputName }}"
        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
    <label for="{{ $inputName . '-' . $attributes->get('value') }}"
        class="w-full py-4 ms-2 text-sm font-medium text-gray-900">{{ $slot }}</label>
</div>
