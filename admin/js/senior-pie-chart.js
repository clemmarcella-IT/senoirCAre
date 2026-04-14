var ctx = document.getElementById("seniorPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Active", "Inactive"],
    datasets: [{
      data: php_statusData, // Uses PHP variable
      backgroundColor: ['#1F4B2C', '#dc3545'],
    }],
  },
});