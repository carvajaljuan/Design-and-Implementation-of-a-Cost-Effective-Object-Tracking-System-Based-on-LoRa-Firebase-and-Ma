var speedCanvas = document.getElementById("speedChart");
var dato = [];
var Datostring = [];
Chart.defaults.global.defaultFontFamily = "Calibri";
Chart.defaults.global.defaultFontSize = 14;
database = firebase.database();
var ref = database.ref('Advertencias');
ref.on('value', gotData);

function gotData(data) {
    var Posicion = data.val(); // Se guardan las posciones en en esta variable
    var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
    console.log(keys); // Se muestra el vector de posicones
    for (var i = 0; i < keys.length; i++) {
        var k = keys[i];
        if (i < keys.length - 1) { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
            dato[i] = Posicion[k].time;

        }

    }
    Datostring[0] = dato[0].toString()
    console.log("03/03/2021", "04/03/2021", "05/03/2021", "06/03/2021", "07/03/2021", "08/03/2021", "09/03/2021");
}
var speedData = {
    labels: ["03/03/2021", "04/03/2021", "05/03/2021", "06/03/2021", "07/03/2021", "08/03/2021", "09/03/2021"],
    datasets: [{
        label: "Alertas por día",
        data: [0, 0, 0, 1, 4, 7, 3],
        lineTension: 0,
        fill: false,
        borderColor: 'orange',
        backgroundColor: 'transparent',
        borderDash: [5, 5],
        pointBorderColor: 'orange',
        pointBackgroundColor: 'rgba(255,150,0,0.5)',
        pointRadius: 5,
        pointHoverRadius: 10,
        pointHitRadius: 30,
        pointBorderWidth: 2,
        pointStyle: 'rectRounded'
    }]
};

var chartOptions = {
    legend: {
        display: true,
        position: 'top',
        labels: {
            boxWidth: 80,
            fontColor: 'black'
        }
    }
};

var lineChart = new Chart(speedCanvas, {
    type: 'line',
    data: speedData,
    options: chartOptions
});