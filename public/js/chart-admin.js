const label = chartData.map(item => item.month)
const value = chartData.map(item => item.sales)

const ctx = document.getElementById('chart-bar').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: label,
        datasets: [{
            label: 'Nilai Sales ',
            data: value,
            backgroundColor: [
                "#ADD8E6", "#9370DB", "#98FB98", "#FFFF66", "#228B22", "#87CEFA", "#FF6347", "#FFA500", "#FFD700", "#FF8C00", "#8B4513", "#8B0000"
            ],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Grafik Penjualan Bulanan'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});