<?php
if (!isset($_SESSION["nombre"])) {
    Header("Location:../index.php");
}else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../index.css">
    <title>Ronnie Bar</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar">
    <div class="container-fluid">
       
            <!-- LOGO -->
            <div class="div-logo-nav"> 
                <a class="navbar-brand a-img-logo" href="#"><img src="../imagenes/logo_ronnie.jpeg" class="img-logo" alt="Logo"></a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="div-items-nav collapse navbar-collapse" id="navbarNav">
                <!-- ITEMS-->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../inicio/inicio.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../productos/productos.php">Productos</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="../proveedores/proveedores.php">Proveedores</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="../tipoDeProducto/tipoDeProducto.php">Tipo de producto</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="../medidas/medidas.php">Medidas</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active"  href="../cerrarSesion.php">Cerrar sesión</a>
                        </li>
                    </ul>
                
            </div>
            
    </nav>
    <?php
    }
    ?>