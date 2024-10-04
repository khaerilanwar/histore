<x-cashier.layout>
    <x-slot:title>Dashboard Admin</x-slot:title>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-9 bg-white p-4 rounded-lg">
            <canvas id="chart-bar"></canvas>
        </div>
        <div class="col-span-3">
            <x-cashier.card-resume>
                <x-slot:title>Monthly Profit</x-slot:title>
                <x-slot:value>Rp. 100.000.000</x-slot:value>
            </x-cashier.card-resume>
            <x-cashier.card-resume>
                <x-slot:title>Monthly Sales</x-slot:title>
                <x-slot:value>Rp. 100.000.000</x-slot:value>
            </x-cashier.card-resume>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/chart-admin.js') }}"></script>
</x-cashier.layout>
