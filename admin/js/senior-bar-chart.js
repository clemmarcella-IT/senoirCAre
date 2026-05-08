// Monthly Dues Collection Chart
function renderSeniorBarChart() {
    var barCanvas = document.getElementById("seniorBarChart");
    if (!barCanvas) {
        console.error('senior-bar-chart.js: canvas element #seniorBarChart not found.');
        return;
    }
    var ctx = barCanvas.getContext('2d');
    if (!ctx) {
        console.error('senior-bar-chart.js: unable to acquire canvas context.');
        return;
    }
    if (typeof Chart === 'undefined') {
        console.error('senior-bar-chart.js: Chart.js is not loaded.');
        return;
    }

    var monthLabels =["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var duesData = (typeof php_duesData !== 'undefined' && Array.isArray(php_duesData))
        ? php_duesData.map(function(value) { return Number(value) || 0; })
        :[];
        
    // Debug console.log removed to clean up browser console
    
    var highestValue = duesData.length ? Math.max.apply(null, duesData) : 0;
    var highestIndex = duesData.indexOf(highestValue);

    var backgroundColors = duesData.map(function(value, index) {
        return index === highestIndex && highestValue > 0 ? "#ffd700" : "#91EAAF";
    });
    var borderColors = duesData.map(function(value, index) {
        return index === highestIndex && highestValue > 0 ? "#b8860b" : "#1F4B2C";
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets:[{
                label: "Dues Collected (₱)",
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1,
                data: duesData
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes:[{ ticks: { beginAtZero: true, maxTicksLimit: 5 } }],
                xAxes:[{ gridLines: { display: false } }]
            },
            legend: { display: false },
            title: {
                display: true,
                text: highestValue > 0 ? 'Highest contribution: ' + php_highestMonthLabel + ' (₱' + php_highestMonthAmount.toFixed(2) + ')' : 'No paid dues recorded this year'
            }
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', renderSeniorBarChart);
} else {
    renderSeniorBarChart();
}