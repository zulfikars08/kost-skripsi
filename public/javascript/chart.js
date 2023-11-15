// chart.js

// Assuming you have data for each day of the month
var days = chartData.days;
var pemasukanData = chartData.pemasukanData;
var pengeluaranData = chartData.pengeluaranData;

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.days,
        datasets: [
            {
                label: 'Pemasukan',
                data: chartData.pemasukanData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Pengeluaran',
                data: chartData.pengeluaranData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                type: 'category',
                labels: chartData.days,
            },
            y: {
                beginAtZero: true,
            },
        },
    },
});

