<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $correo = $_POST['email'];
    $clave = $_POST['password'];
  
    $message = '';

    if (empty($correo) or empty($clave)) {

        $message = '<i style="color: red;">Por favor rellenar todos los campos</i>';
    } else {
        session_start();

        require 'database.php';

        if ($message == '') {
            $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
            $records2 = $conn->prepare('SELECT id, email, Role FROM users WHERE email = :email');
            $records2->bindParam(':email', $_POST['email']);
            $records->bindParam(':email', $_POST['email']);
            $records2->execute();
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
            $results2 = $records2->fetch(PDO::FETCH_ASSOC);
          

            if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
               $Role=$results2['Role'];
              //echo json_encode($Role);
                $_SESSION['user_id'] = $results['id'];
                header("Location: aplicacion.php");
            } else {
                $message = '<i style="color: red;">Lo sentimos, sus credenciales no coinciden</i>';
               // $_SESSION['user_id'] = $results['id'];
                //header("Location: avance4.html");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión | LoRaTrack</title>
    <link rel="stylesheet" href="/login/css/estilos.css">
    <script src='/aplicacion/js/mqttws31.js' type='text/javascript'></script>
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
    <section class="seccion2">
        <div class="acceder-app">
            <h2>INICIAR SESIÓN</h2>
            <!--Falta href="signup.php" del a de abajo-->
            
            <br>
            <?php if (!empty($message)) : ?>
            <p>
              
                <?= $message ?>
            </p>
            <?php endif; ?>
            
               
        

            <form action="login.php" method="POST">
                <input name="email" type="text" placeholder="Ingrese su email">
                <input name="password" type="password" placeholder="Ingrese su contraseña">
                <input type="submit" value="Ingresar">
            </form>
        </div>
    </section>
    <footer id="foot">
        <h3>CONTACTO </h3>
        <div class="linea"></div>
        
        <p> Juan Pablo Carvajalaa A. <?= $Role ?><br> carvajal_juan@javeriana.edu.co<br>
        

    </footer>
    <script src="/login/js/main.js"></script>
</body>

</html>