<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Ronnie bar</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- primer col -->
            <div class="col-md-4">
            
            </div>
            <!-- segunda col -->
            <div class="col-md-4">
                <!-- card -->
               <div class="card">
                <div class="card-header">
                    Iniciar sesión
                </div>
                <!-- body de la card -->
                <div class="card-body">
    
    
                    <!-- form -->
                    <form action="index.php" name="form" class="form-group" method="post">
                        Usuario:<input type="text" name="usuario" id="usuario" class="form-control"> 
                        </input>

                        Contraseña:<input type="password" name="contrasenia" class="form-control">
                        </input>
                       <button type="submit" class="btn btn-primary mt-2" onclick="">Ingresar</button>

                       <!-- Elemento oculto con display -->
                       <div class="alert alert-danger mt-2" id="alerta-error" style="display:none"></div> 
                    </form>
                    
                </div>
               
               </div>
            </div>
            
            
        </div>
       </div>
       <script src="index.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<?php
if ($_POST) {
    session_start();
    include("config/db.php");
    $usuario = $_POST["usuario"];
    $contrasenia = $_POST["contrasenia"];
    $consulta = $conexion ->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
    $consulta -> bindParam(":nombre", $usuario);
    $consulta -> execute();
    $existe = $consulta -> fetch(PDO::FETCH_ASSOC);
    if ($existe) {
        
        $consulta = $conexion -> prepare("SELECT * FROM usuarios WHERE contrasenia = :contrasenia");
        $consulta -> bindParam(":contrasenia", $contrasenia);
        $consulta -> execute();
        $existe = $consulta -> fetch(PDO::FETCH_LAZY);
        
        if ($existe) {
                $_SESSION["nombre"] = $existe["nombre"];
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
        }else {
            echo "<script type='text/javascript'>
            const mensajeError = document.querySelector('#alerta-error');
            mensajeError.style.display = 'block';
            mensajeError.textContent = 'Nombre de usuario mal ingresado';   
            setTimeout(() => {
                mensajeError.style.display = 'none';
            }, 3000);
            </script>";
        }
    
    }
?>
</html>