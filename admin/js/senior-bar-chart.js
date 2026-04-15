var ctx = document.getElementById("seniorBarChart");
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["60-65 yrs", "66-70 yrs", "71-75 yrs", "76+ yrs"],
    datasets: [{
      label: "Seniors",
      backgroundColor: "#91EAAF",
      borderColor: "#1F4B2C",
      borderWidth: 1,
      data: php_ageData,
    }],
  },
  options: {
    maintainAspectRatio: false,
    scales: { yAxes: [{ ticks: { beginAtZero: true, maxTicksLimit: 3 } }], xAxes: [{ gridLines: { display: false } }] },
    legend: { display: false }
  }
});