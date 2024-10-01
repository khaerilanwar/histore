<label {{ $attributes }}
    class="block mb-2 text-sm font-medium {{ $errors->has($inputName) ? 'text-red-700' : 'text-gray-900' }}">{{ $slot }}</label>
