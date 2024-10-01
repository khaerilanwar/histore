<div
    class="w-full p-5 border border-gray-200 rounded-lg shadow {{ $notification->status == 'public' ? 'bg-green-200' : 'bg-yellow-100' }}">
    <a href="/cashier/notification/{{ $notification->id }}">
        <h5 class="mb-2 text-base font-semibold tracking-tight text-gray-900">
            {{ $notification->title }}</h5>
        <p class="mb-3 font-normal text-gray-700 text-sm">{{ $notification->description }}</p>
    </a>
    <span class="font-medium text-blue-600">
        {{ $notification->created_at->diffForHumans() }}
    </span>
</div>
