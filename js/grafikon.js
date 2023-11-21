$(document).ready(function () {
    if (typeof(chartData) !== 'undefined') {
        const chart = new Chart(document.getElementById('year_chart'), {
            type: 'bar',
            data: {
                labels: chartData.map(row => row.ev),
                datasets: [
                    {
                        label: 'Nő',
                        data: chartData.map(row => row.no)
                    },
                    {
                        label: 'Férfi',
                        data: chartData.map(row => row.ferfi)
                    }
                ]
            }
        });
    }
});
