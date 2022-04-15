<?php
session_start();
require 'database.php';

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | LoRaTrack</title>
    <link rel="stylesheet" href="index/css/estilos.css">
    <script src="https://kit.fontawesome.com/0ec3a0af1a.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap" rel="stylesheet">
</head>

<body>
    <!--HEADER Y BARRA DE NAVEGACION-->
    <header>
        <nav>
            <section class="contenedor nav">
                <div class="logo2">
                    <a href="/index.php" >
                    <img src="/index/png/Asset 7LORa12.png" alt=""WIDTH=190 HEIGHT=60>
                      
                   
   
                    </div>
                        </span>
                    </a>
                </div>
                <div class="enlaces-header">
                    <a href="/index.php" class="menu1">INICIO</a>
                    <a href="/sensores.php" class="menu2">UTILIDADES</a>
                    <a href="/aplicacion.php" class="menu3">APLICACIÓN <i class="fas fa-map-marked-alt"></i></a>
                    <?php if (!empty($user)) : ?>
                    <a href="/logout.php" class="menu5">LOGOUT <i class="fas fa-sign-out-alt"></i></a>
                    <?php else :?>
                    <a href="/login.php" class="menu4">LOGIN <i class="fas fa-user-circle"></i></a>
                    <?php endif; ?>
                    <a href="#foot" class="menu4">CONTACTO</a>
                </div>
                <div class="menu">
                    <i class="fas fa-bars"></i>
                </div>
            </section>
        </nav>
    </header>

    <!--PRIMERA SECCION-->
    <div class="contenedor-seccion1">
        <section class="introduccion">
            <div class="contenedor-parrafo">
                <section class="slide-parrafo slides">
                    <div class="slide1">
                        <h1 class="glicthed">¿Qué es LoRaTrack? </h1>
                        <p>LoRaTrack es un sistema de rastreo que permite conocer de forma constante la ubicación de objetos que quieras rastrear, 
                        los nodos de LoRaTrack están orientado al bajo consumo y el largo alcance usando la tecnología inalámbrica LoRa, 
                        lo que aumenta la autonomía energética de la batería llegando a más de 200 horas de uso continuo.
 
                         </p>
                    </div>
                    <div class="slide1">
                        <h1 class="glicthed">¿COMO FUNCIONA?</h1>
                        <p>LoRa tracker cuenta con un sistema completo orientado al bajo consumo, el cual por medio de la tecnologia
                        LoRa comunica el nodo central con los nodos de rastreo con el fin de obtener la posición de estos constanemente. 
                        Este novedoso dispositivo puede ser acoplado a computadores, bicicletas o cualqueir otro objeto de valor que se desee rastrear.
                        Si deseas conocer más por favor inicia sesión y dirigete al apartado de utildiades.
                        </p>
                    </div>
                </section>
            </div>
            <div class="contenedor-imagen">
                <section class="slide-imagen slides">
                    <div class="slide2">
                        <img src="index/Img/IoT-2.png" alt="">
                        <p>Arquitectura general de una aplicación IoT</p>
                    </div>
                    <div class="slide2">
                        <img src="index/png/bike-nodoc.png" alt="">
                        <p>Dispositivo LoRa </p>
                    </div>
                </section>
            </div>
        </section>
        <div class="slidebutton">
            <div class="bar"></div>
        </div>
        <div class="smooth-button"></div>
    </div>
    <div class="separador"></div>
    <section class="seccion2">
        <div class="contenendor-titulo">
            <div class="titulo">Nuestros servicios</div>
            <div class="linea-titulo"></div>
        </div>
        <div class="contenedor-servicios">
            <div class="servicio s1">
                <div class="descripcion">
                    Ubicación en tiempo real
                </div>
                <img src="/index/Img/ubicacion.JPG" alt="">
            </div>
            <div class="servicio s2">
                <div class="descripcion">
                    Personalización del rastreo
                </div>
                <img src="/index/Img/mapapaso3.JPG" alt="">
            </div>
        </div>
        <div class="contenedor-servicios">
            <div class="servicio s3">
                <div class="descripcion">
                    Analítica
                </div>
                <img src="/index/Img/graficas.JPG" alt="">
            </div>
            <div class="servicio s4">
                <div class="descripcion">
                Alertas y seguridad
                </div>
                <img src="/index/Img/bell.gif" alt="">
            </div>
        </div>
        <div class="acceder-app">
            <span>Para acceder a nuestros servicios o conocer mas sobre LoRa <a href="login.php">inicie sesión</a> o contactenos .</span>
        </div>
    </section>
    <footer id="foot">
        <h4>CONTACTO </h4>
        <div class="linea"></div>
        
        <p> Juan Pablo Carvajal A.<br> carvajal_juan@javeriana.edu.co<br>
        

    </footer>
    <script src="index/js/main.js"></script>
</body>

</html>