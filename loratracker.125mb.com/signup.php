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
        $user = $results2;
        $Role=$results2['Role'];
    }
    if ($Role != 'Administrador'){
        header("Location: index.php");

}
}
else {
    header("Location: index.php");
}
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $correo = $_POST['email'];
        $clave = $_POST['password'];
        $clave2 = $_POST['confirm_password'];
        $Role = $_POST['Role'];
                
        $message = '';
        if (empty($correo) or empty($clave) or empty($clave2)){
            
            $message = '<i style="color: red;">Por favor rellenar todos los campos</i>';
            
        }else{
            
            require 'database.php';
            
            $sql = "SELECT * FROM users WHERE email = '$correo'";
            $stmt = $conn->prepare($sql);
            $stmt -> execute();
            $result = $stmt -> fetch();
            
            if ($result != false){
                $message = '<i style="color: red;">Este usuario ya existe</i>';
            }
            
            if ($clave != $clave2){
                $message = '<i style="color: red;"> Las contraseñas no coinciden</i>';
            }    
            
        }
        
        if ($message == ''){
            $sql = "INSERT INTO users (email, password , Role) VALUES (:email, :password, :Role)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':Role', $Role);

            if ($stmt->execute()) {
              $message = '<i style="color: green;">Nuevo usuario registrado exitosamente</i>';
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | LoRaTrack</title>
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
                    <a href="/login.php" class="menu5">LOGIN <i class="fas fa-user-circle"></i></a>
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
            <h2>REGISTRARSE</h2>
            <span> o <a href="login.php">Iniciar Sesión</a></span>
            <br>
            <?php if(!empty($message)): ?>
             <p><?= $message ?></p>
           <?php endif; ?>

            <form action="signup.php" method="POST">
                <input name="email" type="text" placeholder="Ingrese el email">
                <input name="password" type="password" placeholder="Ingrese al contraseña">
                <input name="confirm_password" type="password" placeholder="Confirme la contraseña">
                <input name="Role" type="text" placeholder="Ingrese el Rol del usuario">
                <input type="submit" value="Registrarse">
            </form>
        </div>
    </section>
    <footer id="foot">
        <h3>CONTACTO </h3>
        <div class="linea"></div>
        
        <p> Juan Pablo Carvajal A.<br> carvajal_juan@javeriana.edu.co<br>
        
    </footer>
    <script src="/login/js/main.js"></script>
</body>

</html>