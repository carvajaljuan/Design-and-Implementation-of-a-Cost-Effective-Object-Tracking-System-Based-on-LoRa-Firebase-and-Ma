var densityCanvas = document.getElementById("densityChart");

Chart.defaults.global.defaultFontFamily = "Calibri";
Chart.defaults.global.defaultFontSize = 14;

var densityData = {
    label: 'Nodos Conectados',
    data: [1, 0, 1, 0, 0, 2, 1, 2],
    backgroundColor: [
        'rgba(0, 99, 132, 0.6)',
        'rgba(30, 99, 132, 0.6)',
        'rgba(60, 99, 132, 0.6)',
        'rgba(90, 99, 132, 0.6)',
        'rgba(120, 99, 132, 0.6)',
        'rgba(150, 99, 132, 0.6)',
        'rgba(180, 99, 132, 0.6)',
        'rgba(210, 99, 132, 0.6)',
        'rgba(240, 99, 132, 0.6)'
    ],
    borderColor: [
        'rgba(0, 99, 132, 1)',
        'rgba(30, 99, 132, 1)',
        'rgba(60, 99, 132, 1)',
        'rgba(90, 99, 132, 1)',
        'rgba(120, 99, 132, 1)',
        'rgba(150, 99, 132, 1)',
        'rgba(180, 99, 132, 1)',
        'rgba(210, 99, 132, 1)',
        'rgba(240, 99, 132, 1)'
    ],
    borderWidth: 2,
    hoverBorderWidth: 0
};
var chartOptions = {
    scales: {
        xAxes: [{
            barPercentage: 0.7
        }]
    }
    
};
var barChart = new Chart(densityCanvas, {
    type: 'bar',
    data: {
        labels: ["3/03/2021", "4/03/2021", "5/03/2021", "6/03/2021", "7/03/2021", "8/03/2021", "9/03/2021"],
        datasets: [densityData]
    },
    options: chartOptions
});