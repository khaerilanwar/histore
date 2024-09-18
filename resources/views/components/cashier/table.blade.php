<table class="w-full text-sm text-left text-gray-500 ">
    {{ $caption ?? '' }}
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
        {{ $heading ?? '' }}
    </thead>
    <tbody>
        {{ $body ?? '' }}
    </tbody>
    @if ($footer ?? false)
        <tfoot>
            {{ $footer }}
        </tfoot>
    @endif
</table>
