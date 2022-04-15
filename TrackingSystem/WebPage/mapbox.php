<?php
session_start();

require 'database.php';

if (isset($_SESSION['user_id'])) {
    $records2 = $conn->prepare('SELECT id, email, Role FROM users WHERE id = :id');
    $records2->bindParam(':id', $_SESSION['user_id']);
    $records2->execute();
    $results2 = $records2->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results2) > 0) {
        $Role=$results2['Role'];
    }
}
?>

    


var dataLong = 10; //Variables globales de longitud y latitud, se establece un valor predetermiando arbitrario.
var dataLat = -71;
var dataLong2 = 11;
var dataLat2 = -71;
var Radio = 20;
var Radio2 = 20;
var Entrada;
var submitButton;
var mostrar = 'visible';
var swatch;
var km = 10;
var testlong = -72.072367;
var testlat = 4.704582;
var testlong2 = -72.072367;
var testlat2 = 4.705582;
var cont = 0;
var cont2 = 0;
var LatArea = 4.704582;
var LongArea = -74.072367;
var LatAreaCf = 4.704582;
var LongAreaCf = -74.072367;
var LatArea2= 4.704582;
var LongArea2 = -74.062367;
var LatAreaCf2 = 4.704582;
var LongAreaCf2 = -74.062367;
var AlertaFlag = 0;
var AlertaFlag2 = 0;
var AlertaFlag3 = 0;
var AlertaFlag4 = 0;
var Fecha = 0;
var RadioKm=1;
var Role;
var RadioKm2=1;
var RadioFlag;
var contalayer=0;
var layerant="null";
var layerpos="null";
// Your web app's Firebase configuration
var database; // Variable que contiene la base de datos
var firebaseConfig = { //Variable string que contiene la configuracion de Firebase
    apiKey: "AIzaSyDqqE3Hp3NXDIfQUU4rIMcfbPfY6UeMKLg",
    authDomain: "testarduino-b4fcb.firebaseapp.com", // Esto lo proporciona la base de datos
    databaseURL: "https://testarduino-b4fcb.firebaseio.com",
    projectId: "testarduino-b4fcb",
    storageBucket: "testarduino-b4fcb.appspot.com",
    messagingSenderId: "745395389829",
    appId: "1:745395389829:web:003ef0d43d4fdba5c6b0ec",
    measurementId: "G-CZ3KQYKZ5W"
};
var Role = "<?php Print($Role); ?>";
     console.log(Role);
// Initialize Firebase                  // Comandos de la libreria de firebase, inicializan la base de datos
firebase.initializeApp(firebaseConfig);
firebase.analytics();
database = firebase.database(); // Se guarda la base de datos en la variable
var ref = database.ref('Dato_Actual/Posicion'); // Esta variable guarda la direccion a donde se quiere ir en la base de datos
var ref2 = database.ref('Dato_Actual2/Posicion');
var ref3 = database.ref('RO/radio');
var ref4 = database.ref('RO/centro');
var ref5 = database.ref('RO/radio2');
var ref6 = database.ref('RO/centro2');


ref.on('value', gotData, errData);
ref2.on('value', gotData2, errData);
ref3.on('value', gotData3, errData);
ref4.on('value',gotData4,errData);
ref5.on('value',gotData5,errData);
ref6.on('value',gotData6,errData);

var colors = [ //Color del boton
    '#a1dab4',
];
var swatches = document.getElementById('swatches'); //Variables para el boton de color
document.getElementById('swatches').value;
var layer = document.getElementById('layer2').value;
console.log(layer);
// Establece una toma de decision segun el evento
// En este caso el evento es si llega un valor nuevo de la base de datos

function myFunction() { //Funcion para cambiar el valor del radio cuando se oprime aceptar.
    layer = document.getElementById('layer2').value;
    km = document.getElementById("info").value;
    km = Number(km);
    if( layer=="R1"){
    var ref = database.ref('RO/radio');
                var data = {
                    km: km
                }
                ref.push(data);
    }
    if( layer=="R2"){
    var ref = database.ref('RO/radio2');
                var data = {
                    km: km
                }
                ref.push(data);
    }
}
var colors = [ //Color del boton
    '#a1dab4',
];
colors.forEach(function(color) { //Funcion del boton de ocultar
    var swatch = document.createElement('button');
    swatch.style.backgroundColor = color; //Color del boton


    swatch.addEventListener('click', function() { //Espera click en el boton verde
        layer = document.getElementById('layer2').value;
        if(layer=="R1"){ 
        var flagmostrar = map.getLayoutProperty('polygon', 'visibility');
        }
        if(layer=="R2"){ 
        var flagmostrar = map.getLayoutProperty('polygon2', 'visibility');
        }
        // Interruptor para cambiar la visibildiad del objeto
        
        if (flagmostrar === 'visible') {
            if(layer=="R1"){ 
            map.setLayoutProperty('polygon', 'visibility', 'none'); //Se oculta
            this.className = '';
            }
            if(layer=="R2"){
            map.setLayoutProperty('polygon2', 'visibility', 'none'); //Se oculta
            this.className = '';
            }
        } else {
            if(layer=="R1"){
            this.className = 'active';
            map.setLayoutProperty('polygon', 'visibility', 'visible'); //Muestra el objeto
            }
            if(layer=="R2"){
            this.className = 'active';
            map.setLayoutProperty('polygon2', 'visibility', 'visible'); //Muestra el objeto
            }
        }
    });


    swatches.appendChild(swatch);
});


function gotData(data) {
    // Si el evento es un dato valido se va a esta funcion.
    try {
        var Posicion = data.val(); // Se guardan las posciones en en esta variable
        var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
        console.log(keys); // Se muestra el vector de posicones
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            if (i == keys.length - 1) { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
                dataLat = Posicion[k].Latitud;
                dataLong = Posicion[k].Longitud; // Sintaxis para obtener el dato de una variable, los nombres tienen que coincidir con la base de datos
                dataLong = dataLong * -1;
                console.log(dataLong,dataLat);   
                ActualizarRango();
            }
        }
    } catch {
        console.log("Bandera")
    }
}

function gotData2(data) {
    // Si el evento es un dato valido se va a esta funcion.
    try {
        var Posicion = data.val(); // Se guardan las posciones en en esta variable
        var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
        console.log(keys); // Se muestra el vector de posicones
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            if (i == keys.length - 1) { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
                dataLat2 = Posicion[k].Latitud;
                dataLong2 = Posicion[k].Longitud; // Sintaxis para obtener el dato de una variable, los nombres tienen que coincidir con la base de datos
                dataLong2 = dataLong2 * -1 - 0.05;
                //console.log(dataLong2, dataLat2);
                ActualizarRango();
            }
        }
    } catch {
        console.log("Bandera")
    }
}



//Llave de acceso a la cuenta de mapbox
mapboxgl.accessToken = 'pk.eyJ1IjoicHJpbWFsNjU0IiwiYSI6ImNrY25xODc5NzBkMXMycW8xbTkycGJxaWQifQ.kMYu-Hv25WBNJhTN_VRpag';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    //style: 'mapbox://styles/mapbox/light-v10',
    //style: 'mapbox://styles/mapbox/satellite-v9',
    //style: 'mapbox://styles/mapbox/outdoors-v11',
    //pitch: 45,
    center: [-74.064, 4.70438], // punto central de mapa y zoom predeterminado
    zoom: 10
});

var radius = 20;
var radius2 = 20;

function pointOnCircle(data) { //esta funcion se activa si ocurre el evento de nuevo dato y mueve el punto de ubicacion
    return {
        'type': 'Point',
        'coordinates': [dataLong, dataLat]
    }; // Se grafican las coordenadas guardadas en las variables globales
}

function pointOnCircle2(data) { //esta funcion se activa si ocurre el evento de nuevo dato y mueve el punto de ubicacion
    return {
        'type': 'Point',
        'coordinates': [dataLong2, dataLat2]
    }; // Se grafican las coordenadas guardadas en las variables globales
}


function gotData3(data) {

    
    var Posicion = data.val(); // Se guardan las posciones en en esta variable
    var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
    console.log(keys); // Se muestra el vector de posicones
    for (var i = 0; i < keys.length; i++) {
        var k = keys[i];
        if (i == keys.length - 1)   { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
            RadioKm= Posicion[k].km;
            //RadioKm2= Posicion[k].km;
            //console.log(Radiokm,k);

        }

    }
}
function gotData4(data) {
    var Posicion = data.val(); // Se guardan las posciones en en esta variable
    var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
    console.log(keys); // Se muestra el vector de posicones
    for (var i = 0; i < keys.length; i++) {
        var k = keys[i];
        if (i == keys.length - 1)   { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
            LatAreaCf = Posicion[k].Latitudfb,
            LongAreaCf = Posicion[k].Longitudfb
            console.log(LatAreaCf,LongAreaCf);

        }

    }
}
function gotData5(data) {
var Posicion = data.val(); // Se guardan las posciones en en esta variable
var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
console.log(keys); // Se muestra el vector de posicones
for (var i = 0; i < keys.length; i++) {
    var k = keys[i];
    if (i == keys.length - 1)   { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
        RadioKm2= Posicion[k].km;
    }

}
}
function gotData6(data) {
    var Posicion = data.val(); // Se guardan las posciones en en esta variable
    var keys = Object.keys(Posicion); // Se obtiene la direccion de cada dato, es decir, el codigo que le da Firebase a cada dato.
    console.log(keys); // Se muestra el vector de posicones
    for (var i = 0; i < keys.length; i++) {
        var k = keys[i];
        if (i == keys.length - 1)   { // Se recorre el vector con el fin de guardar la ultima posicion obtenida en las variables globales
            LatAreaCf2 = Posicion[k].Latitudfb,
            LongAreaCf2 = Posicion[k].Longitudfb
            console.log(LatAreaCf2,LongAreaCf2);

        }

    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var createGeoJSONCircle = function(center, radiusInKm, points) { //Funcion de calculo del rango de operacion
    testlong = Number(dataLong); //Se puede establecer entrada, si no, tiene unas por defecto
    testlat = Number(dataLat); //Se pasan las coordenadas a numero
    console.log("ptoo");
    if (!points) points = 64; //Se establece vertices por defecto

    var coords = {
        latitude: LatAreaCf, //Se guardan las coordenadas del punto
        longitude: LongAreaCf
    };

    var ret = [];
    var ret2 = [];
    Radiokm= Number(RadioKm);
    var distanceX = Radiokm / (111.320 * Math.cos(coords.latitude * Math.PI / 180));
    var distanceY = Radiokm / 110.574; //Relaciones entre la distancia en Km y las coordenadas
    console.log(km, ret);
    var theta, x, y;

    for (var i = 0; i < points; i++) { //Se grafican los vertices del poligono
        theta = (i / points) * (2 * Math.PI);
        x = distanceX * Math.cos(theta);
        y = distanceY * Math.sin(theta);
        x2 = (distanceX - 0.006) * Math.cos(theta);
        y2 = (distanceY - 0.006) * Math.sin(theta);

        ret.push([coords.longitude + x, coords.latitude + y]); //Se envian las coordenadas de cada punto
        ret2.push([coords.longitude + x2, coords.latitude + y2]); //Se envian las coordenadas de cada punto


    }

    ret.push(ret[0]);
    ret2.push(ret2[0]);
    var polygon = turf.polygon([ret]); //Se crea nuevamente poligono de tipo turf usando el vector obtenido ret
    var point = turf.point([dataLong, dataLat]); //Se crea punto a evaluar tipo turf
    var resultado = turf.inside(point, polygon); //Funcion que verifica si se sale del rango
    console.log(resultado);
    var polygon2 = turf.polygon([ret2]);
    var resultado2 = turf.inside(point, polygon2);
    if (resultado === false) { //Si esta fuera activa la bandera
        cont = 1;
        console.log(resultado);
    } else {
        cont = 0;
    }
    if (resultado2 === false) { //Si esta fuera activa la bandera

        cont2 = 1;
    } else {
        cont2 = 0;
    }




    return { //La funcion retorna un string para que se grafique el poligono
        "type": "geojson",
        "data": {
            "type": "FeatureCollection",
            "features": [{
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [ret]
                }
            }]
        }
    };
};

var createGeoJSONCircle2 = function(center, radiusInKm, points) { //Funcion de calculo del radio
    testlong2 = Number(dataLong2); //Se puede establecer entrada, si no, tiene unas por defecto
    testlat2 = Number(dataLat2); //Se pasan las coordenadas a numero
    console.log("ptoo");
    if (!points) points = 64; //Se establece vertices por defecto

    var coords2 = {
        latitude: LatAreaCf2, //Se guardan las coordenadas del punto
        longitude: LongAreaCf2
    };

    var ret3 = [];
    var ret4 = [];
    Radiokm2= Number(RadioKm2);
    var distanceX2 = Radiokm2 / (111.320 * Math.cos(coords2.latitude * Math.PI / 180));
    var distanceY2 = Radiokm2/ 110.574; //Relaciones entre la distancia en Km y las coordenadas
    var theta2, x3, y3,x4,y4;

    for (var i = 0; i < points; i++) { //Se grafican los vertices del poligono
        theta2 = (i / points) * (2 * Math.PI);
        x3 = distanceX2 * Math.cos(theta2);
        y3 = distanceY2 * Math.sin(theta2);
        x4 = (distanceX2 - 0.006) * Math.cos(theta2);
        y4 = (distanceY2 - 0.006) * Math.sin(theta2);

        ret3.push([coords2.longitude + x3, coords2.latitude + y3]); //Se envian las coordenadas de cada punto
        ret4.push([coords2.longitude + x4, coords2.latitude + y4]); //Se envian las coordenadas de cada punto


    }

    ret3.push(ret3[0]);
    ret4.push(ret4[0]);
    var polygon3 = turf.polygon([ret3]); //Se crea nuevamente poligono de tipo turf usando el vector obtenido ret
    var point2 = turf.point([dataLong2, dataLat2]); //Se crea punto a evaluar tipo turf
    var resultado3 = turf.inside(point2, polygon3); //Funcion que verifica si se sale del rango
    console.log(resultado3);
    var polygon4 = turf.polygon([ret4]);
    var resultado4 = turf.inside(point2, polygon4);
    if (resultado3 === false) { //Si esta fuera activa la bandera
        cont3 = 1;
        console.log(resultado4);
    } else {
        cont3 = 0;
    }
    if (resultado4 === false) { //Si esta fuera activa la bandera

        cont4 = 1;
    } else {
        cont4 = 0;
    }




    return { //La funcion retorna un string para que se grafique el poligono
        "type": "geojson",
        "data": {
            "type": "FeatureCollection",
            "features": [{
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [ret3]
                }
            }]
        }
    };
};


/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function hoyFecha() { //Funcion para obtener fecha y hora
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth() + 1;
    var yyyy = hoy.getFullYear();
    var HH = hoy.getHours();
    var min = hoy.getMinutes();
    var sec = hoy.getSeconds();

    dd = addZero(dd);
    mm = addZero(mm);
    min = addZero(min);
    HH = addZero(HH);
    sec = addZero(sec);
    Fecha = dd + '/' + mm + '/' + yyyy + " " + HH + ":" + min + ":" + sec;
}


function addZero(i) { //Agrega ceros adicionaels para desplegar hora y fecha
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

layer2.addEventListener('click', function() { 
    contalayer=contalayer+1;
    console.log(contalayer);
    if(contalayer== 1){
    layerant = document.getElementById('layer2').value;
    }
    if(contalayer== 2){
    layerpos=document.getElementById('layer2').value;
    contalayer=0;
    }
    if((layerpos != layerant) &&(layerpos!= "null")){
    Rastreador();
    }
});
CentroAreaid.addEventListener('click', function() { //Se activa cuando se oprime el botón de confirmar centro
    layer = document.getElementById('layer2').value;
    console.log(layer);
   if(layer == "R1" ){
    LatAreaCf = LatArea
    LongAreaCf = LongArea
    var ref = database.ref('RO/centro');
                var data = {
                    Longitudfb: LongAreaCf,
                    Latitudfb:  LatAreaCf
                }
                ref.push(data);
   }
   if(layer == "R2" ){
    LatAreaCf2 = LatArea
    LongAreaCf2 = LongArea
    var ref = database.ref('RO/centro2');
                var data = {
                    Longitudfb: LongAreaCf2,
                    Latitudfb:  LatAreaCf2
                }
                ref.push(data);
   }
    

});

var marker2 = new mapboxgl.Marker({ //Propeidades del marcador
        draggable: true
    })
    .setLngLat([-74.072367, 4.704582]) //Posicion inicial
    .addTo(map);

function onDragEnd() { //Funcion que se activa cuando se deja de arrastrar el marcador
    var longLat = marker2.getLngLat();
    LatArea = parseFloat(longLat.lat)
    LongArea = parseFloat(longLat.lng) //Se guardan las coordenadas en variables
}

marker2.on('dragend', onDragEnd); //Activa la funcion onDragEnd cuando se termina de arrastrar.
if (Role == "Administrador") {
    document.getElementById('confirmar').style.visibility = 'visible';
    document.getElementById('info').style.visibility = 'visible';
    document.getElementById('CentroAreaid').style.visibility = 'visible';
    document.getElementById('Textcentro').style.visibility = 'visible';
    document.getElementById('Textradio').style.visibility = 'visible';
    console.log(Role);
} else {
    document.getElementById('confirmar').style.visibility = 'hidden';
    document.getElementById('info').style.visibility = 'hidden';
    document.getElementById('CentroAreaid').style.visibility = 'hidden';
    document.getElementById('Textcentro').style.visibility = 'hidden';
    document.getElementById('Textradio').style.visibility = 'hidden';
    console.log(Role);
}



map.on('load', function() { // Esta funcion se activa cuando se carga la pagina por primera vez
    let radius = 1;
    let radius2 = 1;
    map.addSource("polygon", createGeoJSONCircle());
    map.addSource("polygon2", createGeoJSONCircle2()); //Source del poligono
    confirmar.addEventListener('click', function() {
        map.getSource("polygon").setData(createGeoJSONCircle().data); //Si se detecta un click en el boton de confirmar se cambia el radio del la zona.
        map.getSource("polygon2").setData(createGeoJSONCircle2().data);
    });
    CentroAreaid.addEventListener('click', function() {
        map.getSource("polygon").setData(createGeoJSONCircle().data); //Si se detecta un click en el boton de confirmar se cambia el radio del la zona.
        map.getSource("polygon2").setData(createGeoJSONCircle2().data);
    });
    

  setInterval(ActualizarRango, 1000);

      function ActualizarRango() {
    map.getSource("polygon").setData(createGeoJSONCircle().data);
    map.getSource("polygon2").setData(createGeoJSONCircle2().data);
    }
   
    
   CentroAreaid.addEventListener('onmousemove', function() {
        map.getSource("polygon").setData(createGeoJSONCircle().data); //Si se detecta un click en el boton de confirmar se cambia el radio del la zona.
        map.getSource("polygon2").setData(createGeoJSONCircle2().data);
        });
    
    map.addLayer({
        "id": "polygon",
        "type": "fill",
        "source": "polygon",
        "layout": {
            'visibility': mostrar
        },
        "paint": {
            "fill-color": "blue",
            "fill-opacity": 0.2 //Visuales del poligono
        }
    });
    map.addLayer({
        "id": "polygon2",
        "type": "fill",
        "source": "polygon2",
        "layout": {
            'visibility': mostrar
        },
        "paint": {
            "fill-color": "red",
            "fill-opacity": 0.2 //Visuales del poligono
        }
    });
    map.addSource('point', {
        'type': 'geojson',
        'data': {
            'type': 'Point',
            'coordinates': [dataLong, dataLat] // Se grafican las coordenadas guardadas en las variables globales
        }
    });
    map.addSource('point2', {
        'type': 'geojson',
        'data': {
            'type': 'Point',
            'coordinates': [dataLong2, dataLat2] // Se grafican las coordenadas guardadas en las variables globales
        }
    });

    console.log(Radio);
    map.addSource('rangosf', {
        'type': 'geojson',
        'data': {
            'type': 'Point',
            'coordinates': [dataLong, dataLat] // Se grafican las coordenadas guardadas en las variables globales
        }
    });
    map.addSource('rangosf2', {
        'type': 'geojson',
        'data': {
            'type': 'Point',
            'coordinates': [dataLong2, dataLat2] // Se grafican las coordenadas guardadas en las variables globales
        }
    });

    map.addLayer({ //Layer(Objeto) del area alrededor del punto de rastreo
        'id': 'rangosf',
        'type': 'circle',
        'source': "rangosf",
        'layout': {
            //  Aqui se cambia si el objeto es visible o no
            'visibility': mostrar
        },
        paint: {

            "circle-opacity": 0.3,
            "circle-color": "#830300",
            "circle-stroke-width": 2,
            "circle-stroke-color": "#fff", //Visuales del area roja
            "circle-radius": {
                "property": "mag",
                "base": 1.5,
                'stops': [
                    [5, 1],
                    [15, 1024] //Niveles de zoom del circulo  
                ]
            }
        }
    });
    map.addLayer({ //Layer(Objeto) del area alrededor del punto de rastreo
        'id': 'rangosf2',
        'type': 'circle',
        'source': "rangosf2",
        'layout': {
            //  Aqui se cambia si el objeto es visible o no
            'visibility': mostrar
        },
        paint: {

            "circle-opacity": 0.3,
            "circle-color": "#BDECB6",
            "circle-stroke-width": 2,
            "circle-stroke-color": "#fff", //Visuales del area roja
            "circle-radius": {
                "property": "mag",
                "base": 1.5,
                'stops': [
                    [5, 1],
                    [15, 1024] //Niveles de zoom del circulo  
                ]
            }
        }
    });

    setInterval(() => { //Funcion que realiza la animacion de alerta
        map.setPaintProperty('rangosf', 'circle-radius', radius);
        map.setPaintProperty('rangosf2', 'circle-radius', radius2);
        var Radiof = Number(Radio);
        var Radiof2 = Number(Radio2);
        if (cont == 1) //Si la bandera esta en alto hace animacion
        {
            radius = 3 + radius % 30; //Relacion de cambio y maximo rango de animacion.
            if (AlertaFlag == 1) //Se activa cuando se encuentra fuera del rango
            {
                hoyFecha();
                AlertaFlag = 0;
                var ref = database.ref('Alertas/Rastreador1');
                var data = {
                    time: Fecha
                }
                ref.push(data); //Se escribe el valor de la fecha a la base de datos
            }

        } else {
            radius = Radiof //Radio de la zona  roja predetermianda
            AlertaFlag = 1;
        }
        if (cont3 == 1) //Si la bandera esta en alto hace animacion
        {
            radius2 = 3 + radius2 % 30;
            if (AlertaFlag3 == 1) //Se activa cuando se encuentra fuera del rango
            {
                hoyFecha();
                AlertaFlag3 = 0;
                var ref = database.ref('Alertas/Rastreador2');
                var data = {
                    time: Fecha
                }
                ref.push(data); //Se escribe el valor de la fecha a la base de datos
            }

        } else {
            radius2 = Radiof2
            AlertaFlag3 = 1;
        }
        if ((cont2 == 1) && (cont==0)) //Si la bandera esta en alto hace animacion
        {
            if (AlertaFlag2 == 1) //Se activa cuando se encuentra fuera del rango
            {
                hoyFecha();
                AlertaFlag2 = 0;
                var ref = database.ref('Advertencias/Rastreador1');
                var data = {
                    time: Fecha
                }
                ref.push(data); //Se escribe el valor de la fecha a la base de datos
            }
        } else {
            AlertaFlag2 = 1;
        }
        if ((cont4 == 1) && (cont3==0)) //Si la bandera esta en alto hace animacion
        {
            if (AlertaFlag4 == 1) //Se activa cuando se encuentra fuera del rango
            {
                hoyFecha();
                AlertaFlag4 = 0;
                var ref = database.ref('Advertencias/Rastreador2');
                var data = {
                    time: Fecha
                }
                ref.push(data); //Se escribe el valor de la fecha a la base de datos
            }
        } else {
            AlertaFlag4 = 1;
        }
    }, 50);


    // color circles by ethnicity, using a match expression
    // https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-match
    map.addLayer({
        'id': 'point',
        'source': 'point',
        'type': 'circle',
        'paint': {
            'circle-radius': 6, //Visuales del punto pequeño, el nodo
            'circle-color': '#cb3234'
        }
    });
    map.addLayer({
        'id': 'point2',
        'source': 'point2',
        'type': 'circle',
        'paint': {
            'circle-radius': 6, //Visuales del punto pequeño, el nodo
            'circle-color': '#00BB2D'
        }
    });

    function animateMarker(timestamp) { // Animacion para el marcador cuando hay nuevo dato
        map.getSource('point').setData(pointOnCircle(timestamp / 1000)); // Actualiza el punto del rastreador
        map.getSource('rangosf').setData(pointOnCircle(timestamp / 1000)); //Actualiza el contorno
        map.getSource('point2').setData(pointOnCircle2(timestamp / 1000)); //Actualiza el rango de operacion
        map.getSource('rangosf2').setData(pointOnCircle2(timestamp / 1000)); //Actualiza el contorno
        requestAnimationFrame(animateMarker);
    }

    // Empieza la animacion.
    animateMarker(0);
});

function Rastreador(){  //Funcion para ocultar y mostrar los rangos de operacion 
    layer = document.getElementById('layer2').value;
    if(layer == "R1" ){
        map.setLayoutProperty('polygon', 'visibility', 'visible'); //Muestra el objeto R1 RO
   }
   if(layer == "R2" ){
        map.setLayoutProperty('polygon2', 'visibility', 'visible'); //Muestra el objeto R2 RO
    
}
  
}

function errData(err) { //Funcion se activa si la entrada es un error
    console.log('Error!');
    console.log(err);

}




