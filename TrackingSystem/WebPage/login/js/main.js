let contacto = document.querySelector('.menu4');
let login = document.querySelector('.menu5');
let nav = document.querySelector('nav');
let widthVentana = window.innerWidth;
var messLat;
var messLong;
var messCalidad;
var heatmap_json;
var prom;
let contactON = 0;
var firebaseConfig = {
    apiKey: "AIzaSyAbKxlvdi2DICwE7aTspnXZtX3lrJ3W5lA",
    authDomain: "smartbikes-24822.firebaseapp.com",
    databaseURL: "https://smartbikes-24822.firebaseio.com",
    projectId: "smartbikes-24822",
    storageBucket: "smartbikes-24822.appspot.com",
    messagingSenderId: "497748861893",
    appId: "1:497748861893:web:f760e201f6cc32f8e8e1ac",
    measurementId: "G-KC8F1FJTSG"
};

window.addEventListener("scroll", function ligth() {
    if (window.scrollY > 149) {
        contacto.style.color = "#fff";
        login.style.color = "#A29C9C";
        contactON = 1;
    } else {
        contacto.style.color = "#A29C9C";
        login.style.color = "#fff";
        contactON = 0;
    }
})

contacto.addEventListener("mouseover", function ligth() {
    contacto.style.color = "#fff";
})

contacto.addEventListener("mouseout", function ligth() {
    if (contactON === 0) {
        contacto.style.color = "#A29C9C";
        login.style.color = "#fff";
    }
})

login.addEventListener("mouseover", function ligth() {
    if (window.scrollY > 149) {
        login.style.color = "#fff";
    }
})

login.addEventListener("mouseout", function ligth() {
    if (window.scrollY > 149) {
        login.style.color = "#A29C9C";
    }
})

window.addEventListener("resize", function resizefun() {
    widthVentana = window.innerWidth;
    nav.style = 'width: ' + widthVentana + 'px';
})