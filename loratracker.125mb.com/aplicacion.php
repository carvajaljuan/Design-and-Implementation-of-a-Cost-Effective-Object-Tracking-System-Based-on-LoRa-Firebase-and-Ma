<?php
session_start();
require 'database.php';
if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $records2 = $conn->prepare('SELECT id, email, Role FROM users WHERE id = :id');
    $records2->bindParam(':id', $_SESSION['user_id']);
    $records2->execute();
    $results2 = $records2->fetch(PDO::FETCH_ASSOC);
    $user = null;
    if (count($results) > 0) {
        $user = $results;
       $Role=$results2['Role'];
    }
    else {
        header("Location:login.php");
        }
        
}?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación | LoRaTrack</title>
    <link rel="stylesheet" href="/aplicacion/css/estilos.css">
    <!--Para conectar con la nube-->
    <script src="https://kit.fontawesome.com/0ec3a0af1a.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.9.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.1/mapbox-gl.css" rel="stylesheet" />
    <script src="/aplicacion/js/load_file.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
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
                    <?php if (($Role == "Administrador")) : ?>
                    <a href="/signup.php" class="menu1">REGISTRO <i class="fas fa-user-plus"></i></a>
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
    <?php if (!empty($user)) : ?>
        <section class="seccion1">
        <!--<h1>MAPA - UNIVERSIDAD JAVERIANA</h1>-->
       

        <div class="contenedor-bienvenidos">
            <div>Bienvenido <i><?= $user['email']; ?></i>.</div>
            <br>Ha iniciado sesión correctamente.
            <br><a href="logout.php"> Cerrar Sesión</a>
        </div>
        <div class="titulo">
            <div class="parte1">Mapa</div>
        </div>
        <div class="linea-titulo"></div>
        <div class="contenedor-mapas">
            <div class="aside">
                <div class="nombre-mapa t1"><span>MAPA DE UBICACIÓN ACTUAL</span></div>
                <div class="map-overlay top">
        <div class="map-overlay-inner">
                <fieldset>            
    <label>Seleccione rastreador</label> 
    <select id="layer2" name="layer">  
    <option value="R1">Rastreador1</option>  
    <option value="R2">Rastreador2</option>
    </select>
    </fieldset>
    <div id="swatches" ></div>  
    </div>
    </div>    
    <div class = "actuador" type="label" id="Textradio"> Escribir radio</div>
    
    <input class="contenedor" id ="info" type="text"></p>
    </form>
    <div class="botones">
                    <div type='button' class="boton1" id="confirmar" onClick="myFunction();"'>
                        <p>Aceptar Radio</p>
                    </div>
                    </div>

    <div class = "actuador" type="label"  id="Textcentro">Confirmar nuevo centro</div>

                <div class="botones2">
                    
                    <div type='button' class="boton2"  id="CentroAreaid" >
                        <p>Aceptar Centro</p>
                    </div>
                </div>
            </div>
            <div id="map" class="mapa"></div>
        </div>
        
        <div class="titulo">
            <div class="parte1">Estadísticas</div>
            <div class="parte2"></div>
        </div>
        <div class="linea-titulo"></div>
        <div class="contenedor-analitica">
            <div class="thingspeak plot1">
            <canvas id="speedChart" width="500" height="280"></canvas>
            </div>
            <div class="thingspeak plot2">
                <canvas id="densityChart" width="500" height="280"></canvas>
            </div>
        </div>
      
        
    </section>
    <?php else :?>
        <section class="seccion2">
        <div class="acceder-app">
            <h1>BIENVENIDO</h1>
            <p>Para acceder a la aplicación debe:</p>
            <a href="login.php">Iniciar Sesión</a>
        </div>
    </section>
    <?php endif; ?>
    
    <footer id="foot">
        <h4></h4>
        <div class="linea"></div>
        
        

    </footer>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/7.16.0/firebase.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
   https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.16.0/firebase-analytics.js"></script>  
    <script src='https://unpkg.com/@turf/turf/turf.min.js'></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js" integrity="sha512-QEiC894KVkN9Tsoi6+mKf8HaCLJvyA6QIRzY5KrfINXYuP9NxdIkRQhGq3BZi0J4I7V5SidGM3XUQ5wFiMDuWg==" crossorigin="anonymous"></script>


    <script src="/aplicacion/js/haversine.js"></script>
    <script src="/aplicacion/js/main.js"></script>
    <script src="/mapbox.php"></script>
    <script src="/aplicacion/js/grafica1.js"></script>
    <script src="/aplicacion/js/Grafica2.js"></script>
    
</body>

</html>
