let contacto = document.querySelector('.menu4');
let sensores = document.querySelector('.menu2');
let subtitulo1 = document.querySelector('#subtitulo1');
let subtitulo2 = document.querySelector('#subtitulo2');
let subtitulo3 = document.querySelector('#subtitulo3');
let subtitulo4 = document.querySelector('#subtitulo4');
let item1 = document.querySelector('#item1');
let item2 = document.querySelector('#item2');
let item3 = document.querySelector('#item3');
let item4 = document.querySelector('#item4');
let item5 = document.querySelector('#item5');
let slider = document.querySelector('.slider');
let slide = document.querySelector('.slide');
let html = document.querySelector('html');
let nav = document.querySelector('nav');
let info = document.querySelector('.info');
let tamaño = slide.clientHeight;
let widthVentana = window.innerWidth;
let mov = 0;
let sub1 = 1;
let sub2 = 0;
let tamSmooth = 0;

info.addEventListener("click", function smooth() {
    tamSmooth = window.innerHeight;
    window.scrollTo(0, (tamSmooth * 1.05));
})

window.addEventListener("scroll", function ligth() {
    if (window.scrollY > 1022) {
        contacto.style.color = "#fff";
        sensores.style.color = "#A29C9C";
        contactON = 1;
    } else {
        contacto.style.color = "#A29C9C";
        sensores.style.color = "#fff";
        contactON = 0;
    }
})

contacto.addEventListener("mouseover", function ligth() {
    contacto.style.color = "#fff";
})

contacto.addEventListener("mouseout", function ligth() {
    if (contactON === 0) {
        contacto.style.color = "#A29C9C";
        sensores.style.color = "#fff";
    }
})

sensores.addEventListener("mouseover", function ligth() {
    if (window.scrollY > 1010) {
        sensores.style.color = "#fff";
    }
})

sensores.addEventListener("mouseout", function ligth() {
    if (window.scrollY > 1010) {
        sensores.style.color = "#A29C9C";
    }
})

window.addEventListener("resize", function resizefun() {
    tamaño = slide.clientHeight;
    widthVentana = window.innerWidth;
    nav.style = 'width: ' + widthVentana + 'px';
    slider.style.transform = 'translateY(-' + (tamaño * mov) + 'px)';
})

item1.addEventListener("click", function movimentoB() {
    mov = 0;
    slidesTransition();
})

item2.addEventListener("click", function movimentoB() {
        mov = 1;
        slidesTransition();
    })
    /*
    item3.addEventListener("click", function movimentoB() {
        mov = 2;
        slidesTransition();
    })*/

item4.addEventListener("click", function movimentoB() {
    mov = 2;
    slidesTransition();
})

item5.addEventListener("click", function movimentoB() {
    mov = 3;
    slidesTransition();
})

subtitulo3.addEventListener("click", function movimentoB() {
    mov = 4;
    slidesTransition();
})

subtitulo4.addEventListener("click", function movimentoB() {
    mov = 5;
    slidesTransition();
})

subtitulo1.addEventListener("click", function view() {
    if (sub1 === 1) {
        item1.style.display = 'none';
        item2.style.display = 'none';
        item3.style.display = 'none';
        sub1 = 0;
    } else {
        item1.style.display = 'initial';
        item2.style.display = 'initial';
        //item3.style.display = 'initial';
        sub1 = 1;
    }
})

subtitulo2.addEventListener("click", function view() {
    if (sub2 === 1) {
        item4.style.display = 'none';
        item5.style.display = 'none';
        sub2 = 0;
    } else {
        item4.style.display = 'initial';
        item5.style.display = 'initial';
        sub2 = 1;
    }
})

function slidesTransition() {
    slider.style.transform = 'translateY(-' + (tamaño * mov) + 'px)';
    slider.style.transition = 'transform 1s';
}