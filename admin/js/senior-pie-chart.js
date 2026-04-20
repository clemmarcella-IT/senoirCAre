// Citizen Status Pie Chart
var pieCanvas = document.getElementById("seniorPieChart");
if (pieCanvas && typeof Chart !== 'undefined') {
    var pieChart = new Chart(pieCanvas, {
        type: 'pie',
        data: {
            labels: ["Active", "Inactive"],
            datasets: [{
                data: php_statusData,
                backgroundColor: ['#1F4B2C', '#dc3545']
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: { position: 'bottom' }
        }
    });
}