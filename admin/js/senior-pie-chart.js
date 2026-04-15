var ctx = document.getElementById("seniorPieChart");
new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Active", "Inactive"],
    datasets: [{
      data: php_statusData,
      backgroundColor: ['#1F4B2C', '#dc3545'],
    }],
  },
  options: {
    maintainAspectRatio: false,
    legend: { position: 'bottom' }
  }
});