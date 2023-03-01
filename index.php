<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <link rel="manifest" href="./manifest.json">
    <link rel="shortcut icon" href="./imagenes/icons/favicon.ico">
    <title>Ronnie bar</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center div-index-row">
           
            <div class="col-md-5">
                <div class="img-logo-index">
                    <img src="./imagenes/ronnie-logo.png" alt="Logo" >
                </div>
                <h3 class="text-dark">Sistema administrativo</h3>
            </div>
            <!-- col -->
            <div class="col-md-4">
                <!-- card -->
               <div class="card card-index">
                <!-- body de la card -->
                <div class="card-body  text-center shadow-lg p-3  bg-body rounded text-center">
    
                    <!-- form -->
                    <form action="index.php" name="form" class="form-group" method="post">
                        <input type="text" name="usuario" id="usuario" class="form-control my-3 " placeholder="Nombre de usuario"> 
                        </input>

                       <input type="password" name="contrasenia" class="form-control my-3" placeholder="Contraseña" autocomplete="no">
                        </input>

                        <!-- Elemento oculto con display -->
                        <div class="alert alert-danger mt-2" id="alerta-error" style="display:none"></div> 
                        
                        <div class="row div-btn-index"> <button type="submit" class="btn btn-primary mt-2 ">Iniciar sesión</button></div>
                    </form>
                    
                </div>
               
               </div>
            </div>
              
        </div>
    </div>
    <script src="./validarServiceWorker.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<?php
if ($_POST) {
    session_start();
    include("config/db.php");
    $usuario = $_POST["usuario"];
    $contrasenia = $_POST["contrasenia"];
    $consulta = $conexion ->prepare("SELECT * FROM usuarios WHERE nombre = :nombre and contrasenia = :contrasenia");
    $consulta -> bindParam(":nombre", $usuario);
    $consulta -> bindParam(":contrasenia", $contrasenia);
    $consulta -> execute();
    $existe = $consulta -> fetch(PDO::FETCH_ASSOC);
    
    if ($existe) {
        $_SESSION["nombre"] = $existe["nombre"];
        $_SESSION["tipodeusuarios"] = $existe["tipodeusuarios"];
        header("location:./inicio/inicio.php");
        }else {
            echo "<script type='text/javascript'>
                const mensajeError = document.querySelector('#alerta-error');
                mensajeError.style.display = 'block';
                mensajeError.textContent = 'contraseña mal ingresada'; 
                setTimeout(() => {
                mensajeError.style.display = 'none';
                }, 3000);          
            </script>";
        }
    }
?>
</html>