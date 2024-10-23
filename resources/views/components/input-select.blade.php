@php
    $errorClass =
        'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5';
    $commonClass =
        'bg-gray-50 border border-gray-300 text-gray-900 rounded-lg text-sm focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5';
@endphp

<select {{ $attributes->merge(['class' => $errors->has($attributes->get('name')) ? $errorClass : $commonClass]) }}>
    @foreach ($items as $item)
        <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>
