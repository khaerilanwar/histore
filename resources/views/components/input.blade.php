@php
    $errorClass =
        'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5';
    $commonClass =
        'bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5';
@endphp
<input {{ $attributes }} class="{{ $errors->has($attributes->get('name')) ? $errorClass : $commonClass }}">

@error($attributes->get('name'))
    <p class="mt-2 text-sm text-red-600"><span class="font-medium">
            {{ $message }}
    </p>
@enderror
