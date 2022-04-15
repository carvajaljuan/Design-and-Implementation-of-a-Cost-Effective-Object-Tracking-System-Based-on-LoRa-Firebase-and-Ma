mapboxgl.accessToken = 'pk.eyJ1Ijoic29yZHV6IiwiYSI6ImNrN2xlMHIxajA2ZmUzbXFvYnh6c2pxbm0ifQ.jWZGKhOzVKsz9cD6bUAzUQ';
var long = -74.063966;
var lat = 4.628869;
var longLat;
var messLat;
var messLong;
var messCalidad;

usuario = 'nodo1';
contrasena = '12345678';


// called when the client connects
function onConnect() {
    // Once a connection has been made, make a subscription and send a message.
    console.log("onConnect");
    client.subscribe("#");
}

// called when the client loses its connection
function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:", responseObject.errorMessage);
        setTimeout(function() { client.connect() }, 5000);
    }
}

// called when a message arrives
function onMessageArrived(message) {
    if (message.destinationName == '/' + usuario + '/' + 'aire') { //acá coloco el topic
        messCalidad = message.payloadString;
        document.getElementById("calidad").textContent = "Calidad del aire:  " + message.payloadString + " ppm";
    }
    if (message.destinationName == '/' + usuario + '/' + 'latitud') { //acá coloco el topic
        messLat = message.payloadString;
    }
    if (message.destinationName == '/' + usuario + '/' + 'longitud') { //acá coloco el topic
        messLong = message.payloadString;
    }
}

function onFailure(invocationContext, errorCode, errorMessage) {
    var errDiv = document.getElementById("error");
    errDiv.textContent = "Could not connect to WebSocket server, most likely you're behind a firewall that doesn't allow outgoing connections to port 39627";
    errDiv.style.display = "block";
}

var clientId = "ws" + Math.random();
// Create a client instance
var client = new Paho.MQTT.Client("tailor.cloudmqtt.com", 33597, clientId);

// set callback handlers
client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;

// connect the client
client.connect({
    useSSL: true,
    userName: usuario,
    password: contrasena,
    onSuccess: onConnect,
    onFailure: onFailure
});

var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/sorduz/ck8ri8qb301lw1jmkg5h6ms3l/draft',
    center: [-74.063966, 4.628869],
    zoom: 16.8,
    pitch: 45,
    bearing: 104.00
});
map.addControl(new mapboxgl.NavigationControl());
map.addControl(new mapboxgl.FullscreenControl({ container: document.querySelector('#map') }));


var marker = new mapboxgl.Marker()
    .setLngLat([long, lat])
    .addTo(map);

var pos = {
    'type': 'Feature',
    'geometry': {
        'type': 'Point',
        'coordinates': [long, lat]
    },
    'properties': {
        'title': 'Ubicación actual',
        'icon': 'monument'
    }
}

//

function actulizarPos() {
    pos.geometry.coordinates = [long, lat];
}

map.on('load', function() {
    window.setInterval(function() {
        long = parseFloat(messLong);
        lat = parseFloat(messLat);
        map.setCenter([long, lat]);
        actulizarPos();
        marker.setLngLat([long, lat]);
        map.getSource('drone').setData(pos);
    }, 2000);

    map.addSource('drone', { type: 'geojson', data: pos });
    map.addLayer({
        'id': 'drone',
        'type': 'symbol',
        'source': 'drone',
        'layout': {
            'text-field': 'Ubicación Actual',
            'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
            'text-offset': [0, 0.6],
            'text-anchor': 'top',
            'text-size': 14,
            'text-max-width': 5
        },
        'paint': {
            'text-color': '#285567'
        }
    });
});