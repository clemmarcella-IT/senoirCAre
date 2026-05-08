// Monthly Dues Collection Chart
var barCanvas = document.getElementById("seniorBarChart");
if (barCanvas && typeof Chart !== 'undefined') {
    var barChart = new Chart(barCanvas, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Dues Collected (₱)",
                backgroundColor: "#91EAAF",
                borderColor: "#1F4B2C",
                borderWidth: 1,
                data: php_duesData
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{ ticks: { beginAtZero: true, maxTicksLimit: 5 } }],
                xAxes: [{ gridLines: { display: false } }]
            },
            legend: { display: false }
        }
    });
}