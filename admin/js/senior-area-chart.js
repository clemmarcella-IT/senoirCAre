var ctx = document.getElementById("seniorAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Attendance",
      lineTension: 0.3,
      backgroundColor: "rgba(31, 75, 44, 0.2)",
      borderColor: "rgba(31, 75, 44, 1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(31, 75, 44, 1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      data: php_attendanceData, // Uses PHP variable
    }],
  },
  options: {
    scales: {
      xAxes: [{ gridLines: { display: false }, ticks: { maxTicksLimit: 12 } }],
      yAxes: [{ ticks: { min: 0, maxTicksLimit: 5 }, gridLines: { color: "rgba(0, 0, 0, .125)" } }],
    },
    legend: { display: false }
  }
});