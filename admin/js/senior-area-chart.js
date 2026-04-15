var ctx = document.getElementById("seniorAreaChart");
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Attendance",
      lineTension: 0.3,
      backgroundColor: "rgba(31, 75, 44, 0.1)",
      borderColor: "#1F4B2C",
      pointBackgroundColor: "#C3E956",
      fill: true,
      data: php_attendanceData,
    }],
  },
  options: {
    maintainAspectRatio: false,
    scales: { yAxes: [{ ticks: { beginAtZero: true, maxTicksLimit: 5 } }], xAxes: [{ gridLines: { display: false } }] },
    legend: { display: false }
  }
});