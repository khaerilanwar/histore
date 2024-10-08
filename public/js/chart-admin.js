const ctx = document.getElementById('chart-bar').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
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