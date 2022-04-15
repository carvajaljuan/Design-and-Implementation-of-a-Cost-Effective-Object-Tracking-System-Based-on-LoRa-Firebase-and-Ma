let slider1 = document.querySelector('.slide-parrafo');
let slider2 = document.querySelector('.slide-imagen');
let sliderInd1 = document.querySelectorAll('.slide1');
let sliderInd2 = document.querySelectorAll('.slide2');
let button = document.querySelector('.slidebutton');
let bar = document.querySelector('.bar');
let contacto = document.querySelector('.menu4');
let inicio = document.querySelector('.menu1');
let buttonsmooth = document.querySelector('.smooth-button');
let seccion1 = document.querySelector('.contenedor-seccion1');
let nav = document.querySelector('nav');
let tamVetana = window.innerHeight;
let widthVentana = window.innerWidth;
let contador = 1;
let tamaño1 = sliderInd1[0].clientWidth;
let tamaño2 = sliderInd2[0].clientWidth;
let tambar = bar.clientWidth;
let tamSmooth = seccion1.clientHeight;
let contactON = 0;

button.addEventListener("click", function movimentoB() {
    slidesTransition();
})

window.addEventListener("resize", function resizefun() {
    tamaño1 = sliderInd1[0].clientWidth;
    tamaño2 = sliderInd2[0].clientWidth;
    tamVetana = window.innerHeight;
    widthVentana = window.innerWidth;
    tambar = bar.clientWidth;
    if (contador === 0) {
        slider1.style.transform = 'translateX(-' + (1 * tamaño1) + 'px)';
        slider2.style.transform = 'translateX(-' + (1 * tamaño2) + 'px)';
        bar.style.transform = 'translateX(+' + (1 * tambar) + 'px)';
    } else {
        slider1.style.transform = 'translateX(0px)';
        slider2.style.transform = 'translateX(0px)';
        bar.style.transform = 'translateX(0px)';
    }
    nav.style = 'width: ' + widthVentana + 'px';
})

function slidesTransition() {
    slider1.style.transform = 'translateX(-' + (contador * tamaño1) + 'px)';
    slider2.style.transform = 'translateX(-' + (contador * tamaño2) + 'px)';
    bar.style.transform = 'translateX(+' + (contador * tambar) + 'px)';
    slider1.style.transition = 'transform 1s';
    slider2.style.transition = 'transform 1s';
    bar.style.transition = 'transform 1s';
    if (contador === 0) {
        contador = 1;
    } else {
        contador = 0;
    }
}

window.addEventListener("scroll", function ligth() {
    if (window.scrollY > 1010) {
        contacto.style.color = "#fff";
        inicio.style.color = "#A29C9C";
        contactON = 1;
    } else {
        contacto.style.color = "#A29C9C";
        inicio.style.color = "#fff";
        contactON = 0;
    }
})

contacto.addEventListener("mouseover", function ligth() {
    contacto.style.color = "#fff";
})

contacto.addEventListener("mouseout", function ligth() {
    if (contactON === 0) {
        contacto.style.color = "#A29C9C";
        inicio.style.color = "#fff";
    }
})

inicio.addEventListener("mouseover", function ligth() {
    if (window.scrollY > 1010) {
        inicio.style.color = "#fff";
    }
})

inicio.addEventListener("mouseout", function ligth() {
    if (window.scrollY > 1010) {
        inicio.style.color = "#A29C9C";
    }
})

buttonsmooth.addEventListener("click", function smooth() {
    tamSmooth = seccion1.clientHeight;
    window.scrollTo(0, (tamSmooth * 0.93));
    window.style.transition = 'transform 1s';
})