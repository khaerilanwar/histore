<x-cashier.layout>
    <x-slot:title>Dashboard Admin</x-slot:title>

    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-9 bg-white p-4 rounded-lg">
            <canvas id="chart-bar"></canvas>
        </div>
        <div class="lg:col-span-3">
            <x-cashier.card-resume>
                <x-slot:title>Monthly Profit</x-slot:title>
                <x-slot:value>Rp. {{ number_format($dataThisMonth->profit, 0, ',', '.') }}</x-slot:value>
                <ion-icon name="wallet" class="w-8 h-8 md:hidden lg:block"></ion-icon>
            </x-cashier.card-resume>
            <br>
            <x-cashier.card-resume>
                <x-slot:title>Monthly Sales</x-slot:title>
                <x-slot:value>Rp. {{ number_format($dataThisMonth->penjualan, 0, ',', '.') }}</x-slot:value>
                <ion-icon name="bag-handle" class="w-8 h-8 md:hidden lg:block"></ion-icon>
            </x-cashier.card-resume>
        </div>
    </div>

    <script>
        const chartData = @json($chartData);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/chart-admin.js') }}"></script>
</x-cashier.layout>
