let contacto = document.querySelector('.menu4');
let aplicacion = document.querySelector('.menu3');
let nav = document.querySelector('nav');
let widthVentana = window.innerWidth;
var messLat;
var messLong;
var messCalidad;
var heatmap_json;
var prom;
let contactON = 0;
// Initialize Firebase
window.addEventListener("scroll", function ligth() {
    if (window.scrollY > 2017) {
        contacto.style.color = "#fff";
        aplicacion.style.color = "#A29C9C";
        contactON = 1;
    } else {
        contacto.style.color = "#A29C9C";
        aplicacion.style.color = "#fff";
        contactON = 0;
    }
})

contacto.addEventListener("mouseover", function ligth() {
    contacto.style.color = "#fff";
})

contacto.addEventListener("mouseout", function ligth() {
    if (contactON === 0) {
        contacto.style.color = "#A29C9C";
        aplicacion.style.color = "#fff";
    }
})

aplicacion.addEventListener("mouseover", function ligth() {
    if (window.scrollY > 1010) {
        aplicacion.style.color = "#fff";
    }
})

aplicacion.addEventListener("mouseout", function ligth() {
    if (window.scrollY > 1010) {
        aplicacion.style.color = "#A29C9C";
    }
})

window.addEventListener("resize", function resizefun() {
    widthVentana = window.innerWidth;
    nav.style = 'width: ' + widthVentana + 'px';
})



/////////////////////////////////////////////////////////////////////////////////////////////////////