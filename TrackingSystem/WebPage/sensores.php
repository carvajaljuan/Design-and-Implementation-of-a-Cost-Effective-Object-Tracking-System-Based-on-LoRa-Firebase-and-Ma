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
<?php if (!empty($user)) : ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensores | Smartbikes</title>
    <link rel="stylesheet" href="/sensores/css/estilos.css">
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
                    <a href="/aplicacion.php" class="menu3">APLICACIÓN</a>
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
    <!--DIAGRAMA EN BLOQUES-->
    <section class="diagrama-bloques">
        <section class="descripcion">
            <div class="ventana">
                <div class="titulo2">
                    <h3>DIAGRAMA DEL</h3>
                    <h4>SISTEMA</h4>
                </div>
                <p>El diagrama en bloques representa la arquitectura de LoRaTrack a partir de la cual se diseño la solución propuesta. 
                La arquitectura consta de dos etapas: la primera es la infrastrctura de la red, encargada de la obtencion y envío de las coordendas de los nodos 
                y la segunda es la etapa de analítica del sistema, encargada del almacenamiento de los datos en la nube y brindar las herraminteas de rastreo en la página web.

                </p>
            </div>
        </section>
        <div class="contenedor-diagrama">
            <img src="index/png/Diagramred2.jpg" alt="rdsrg">
        </div>
    </section>
    <div class="info">COMPONENTES</div>
    <div class="separador"></div>
    <!--PRIMERA SECCION-->
    <section class="seccion1">
        <section class="descripcion-bloques">
            <div class="ventana">
                <div class="titulo2">
                    <h1>COMPONENTES DE </h1>
                    <h2>LOS NODOS</h2>
                </div>
                <p id="subtitulo1" class="subtitulo"> &rsaquo; Transcpetor LoRa </p>
                <p id="item1" class="item-sub"> RN2903 </p>
                <p id="item2" class="item-sub"> Especificaciones </p>
                <p id="item3" class="item-sub"> Calibración del sensor</p>
                <p id="subtitulo2" class="subtitulo"> &rsaquo; Modúlo GPS</p>
                <p id="item4" class="item-sub"> Módulo GSP NEO-6M</p>
                <p id="item5" class="item-sub"> Especificaciones</p>
                <p id="subtitulo3" class="subtitulo"> &rsaquo; Microprocesador ATmega328PB</p>
                <p id="subtitulo4" class="subtitulo"> &rsaquo; Batería</p>
            </div>
        </section>
        <div class="contendor-slider">
            <div class="slider">
                <div class="MQ135 slide">
                    <h2 class="tit1">Transcpetor LoRa RN2903</h2>
                    <section>
                        <article>
                            <p>
                                El transceptor tiene como función realizar la modulación y el envío y recepción de los datos usando la tecnología LoRa, para ambos nodos tipos de nodos,
                                LoRa es una tecnología de comunicación orientado al bajo consumo y al rango alcance, disminuyendo así el consumo energético del nodo. 

                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/png/rn2903.png" alt="">
                            <img src="/sensores/png/rn29032.jpg" alt="">
                        </aside>
                    </section>
                </div>
                <div class="MQ135-2 slide">
                    <h2 class="tit1">ESPECIFICACIONES DEL TRANSCEPTOR</h2>
                    <section>
                        <article>
                            <img src="/sensores/png/Trspecs.png" alt="">
                        </article>
                        <aside class="">
                            <img src="/sensores/png/LoRa2.JPG" alt="">
                        </aside>
                    </section>
                </div>
                <div class="MQ135-3 slide">
                    <h2 class="tit1">CALIBRACIÓN DEL SENSOR</h2>
                    <section>
                        <article>
                            <p>
                                Tomando varios puntos Xi, Yi a partir de la curva de la gráfica correspondiente al CO2 y haciendo una aproximación por mínimos cuadrados podemos obtener el factor de escala y el exponente para el gas que queríamos medir.<br>                                a = 5.5973021420, b = -0.365425824.</p>
                            <div class="ecuaciones">
                                <img src="/sensores/Img/ec1.jpg" alt="">
                                <img src="/sensores/Img/ec2.jpg" alt="">
                            </div>
                            <div class="ecuaciones">
                                <img src="/sensores/Img/ec3.jpg" alt="">
                            </div>
                            <p class="texto">
                                Para calibrar el sensor se requiere una cantidad conocida del gas con una concentración especifica, a fin de leer el valor de la salida analógica y calcular la resistencia del sensor (Rs), con la que podemos calcular el valor de Ro calibrado. </p>
                            <p> Para obtener la resistencia media del sensor pasado el tiempo de precalentamiento calcularemos la resistencia del sensor cada segundo durante 5 minutos y el valor medio obtenido nos sirve para calcular la resistencia de salida
                                del sensor sabiendo la cantidad conocida de gas CO2.
                            </p>
                        </article>
                    </section>
                </div>
                <div class="GPS slide">
                    <h2 class="tit1">MÓDULO GPS NEO-6M</h2>
                    <section>
                        <article>
                            <p>
                                Es un modulo GPS ideal para controlarlo con un microcontrolador, y está basado en el chip receptor NEO 6M. Cuenta con una antena cerámica lista para instalarse en el PCB del chip. La PCB viene provista de conectores para la alimentación y la trasmisión
                                de datos (Vcc, Tx, Rx y GND). Cuenta con una interfaz de comunicaciones asíncrona (UART). Los datos se obtienen en el formato del protocolo NMEA.
                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/GPS.jpg" alt="">
                        </aside>
                    </section>
                </div>
                <div class="GPS2 slide">
                    <h2 class="tit1">ESPECIFICACIONES</h2>
                    <section>
                        <img src="/sensores/Img/GPS_esp1.jpg" alt="">
                        <img src="/sensores/Img/GPS_esp2.jpg" alt="">
                    </section>
                </div>
                <div class="ESP8266 slide">
                    <h2 class="tit1">MICROPROCESADOR </h2>
                    <section>
                        <article>
                            <p>
                                ste es la parte central del nodo, encargado de coordinar y la recepción de los datos de coordenadas a través
                                del GPS para posteriormente enviar los datos 
                                a través del transceptor LoRa para el nodo transmisor, y para el nodo receptor cumple una función similar, 
                                configurando y controlando los datos de coordenadas que llegan del transceptor. 
                                <br>
                                <br>
                                El ATmega328PB es un 
                                microprocesador con un consumo de 11mA, desarrollado por Microchip este Microcontrolador en SMD es de alto rendimiento 
                                y de bajo consumo AVR® microcontrolador 8-Bit, este microcontrolador es una versión mejorada del famoso ATmega328P.
                                Cuenta con 2 módulos de comunicación UART, 2 timer de 8 bits, 3 timer de 16 bits, 131 Instrucciones de gran alcance 
                                y cuenta con 32 pines físicos en el encapsulado TQFP. 
                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/png/atmega.jpg" alt="">
                        </aside>
                    </section>
                </div>
                <div class="Raspberry slide">
                    <h2 class="tit1">BATERÍA 18650</h2>
                    <section>
                        <article>
                            <p>
                               Este tipo de baterías recargables Li-ion cuentan con un circuito de 
                               protección contra cortos circuitos, calentamiento y exceso de carga y descarga,
                               además cuenta con una capacidad de 4200 mAh que junto con el bajo consumo 
                               de la tecnología LoRa brindan hasta más de 200 horas de uso de los nodos.

                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/bateria.jpg" alt="">
                        </aside>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <footer id="foot">
        <h5>CONTACTO </h5>
        <div class="linea"></div>
        
        <p> Juan Pablo Carvajal A.<br> carvajal_juan@javeriana.edu.co<br>
        
    </footer>
    <script src="/sensores/js/main.js"></script>
</body>

</html>
<?php else : 
        header('Location: login.php');
    ?>
    
<?php endif; ?>