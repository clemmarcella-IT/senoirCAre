var ctx = document.getElementById("seniorPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Active", "Inactive"],
    datasets: [{
      data: php_statusData, 
      backgroundColor: ['#1F4B2C', '#dc3545'], // Forest Green and Red
      borderColor: "#ffffff",
      borderWidth: 2
    }],
  },
  options: {
    legend: { position: 'bottom' }
  }
});