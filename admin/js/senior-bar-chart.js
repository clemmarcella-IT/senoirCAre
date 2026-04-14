var ctx = document.getElementById("seniorBarChart");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["60-65", "66-70", "71-75", "76+"],
    datasets: [{
      label: "Seniors",
      backgroundColor: "#91EAAF",
      borderColor: "#1F4B2C",
      data: php_ageData, // Uses PHP variable
    }],
  },
  options: {
    scales: {
      xAxes: [{ gridLines: { display: false } }],
      yAxes: [{ ticks: { min: 0, maxTicksLimit: 5 } }],
    },
    legend: { display: false }
  }
});