<?php
    session_start();
    include("../config/db.php");
    if (!isset($_SESSION["nombre"])) {
        Header("Location:../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="../node_modules/moment/moment.js"></script>
    <script src="https://kit.fontawesome.com/4af9d744f8.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="../imagenes/icons/favicon.ico">
    <link rel="stylesheet" href="../index.css">
    <title>Ronnie Bar</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar">
    <div class="container-fluid">
       
            <!-- LOGO -->
            <div class="div-logo-nav"> 
                <a class="navbar-brand a-img-logo" href="../inicio/inicio.php"><img src="../imagenes/ronnie-logo.png" class="img-logo" alt="Logo"></a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="div-items-nav collapse navbar-collapse" id="navbarNav">
                <!-- ITEMS-->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active a-nav" aria-current="page" href="../inicio/inicio.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active a-nav" aria-current="page" href="../productos/productos.php">Productos</a>
                        </li>                       
                        <li class="nav-item">
                        <a class="nav-link active a-nav" href="../tragos/tragos.php">Tragos</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active a-nav" href="../ventas/ventas.php">Ventas</a>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item dropdown nav-dropdown">
                        <a class="nav-link dropdown-toggle a-nav " data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Abrir</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="nav-link active" href="../proveedores/proveedores.php">Proveedores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../estadisticas/estadisticas.php">Estadisticas P</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../estadisticas/estadisticasTragos.php">Estadisticas T</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../medidas/medidas.php">Medidas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../motivos/motivos.php">Motivos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../tipoDeProducto/tipoDeProducto.php">Tipo de producto</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../tipoDeTragos/tipoDeTragos.php">Tipo de tragos</a>
                            </li>
                        </ul>
                            </li>
                        <li class="nav-item">
                        <a class="nav-link active a-nav"  href="../cerrarSesion.php">Cerrar sesión</a>
                        </li>
                        
                        
                    </ul>
                
            </div>
            
    </nav>
<section class="container-fluid section-ventas">
    <article class="row article">
        <!-- Div izquierdo que contiene la lista de tragos seleccionados -->
        <div class="col-md-4  div-col-ventas">
            <div class="row row_ventas">
                <div class="col-12 m-0 p-0">
                    <form action="registrarVentas.php" method="POST" class="form_lista_tragos" id="form_lista_tragos">
                    <table class="table table-responsive  text-white">
                        <tbody class="tbody-modificar">
                            
                            </tbody>
                        </table>
                    </div>
                    <div class="div-total d-flex justify-content-center align-items-center text-white bg bg-secondary bg-gradient mb-2">
                        <p class="letras-medidas">Total: $</p>
                        <p class="letras-medidas" id="acumuladorDinero">0</p>
                    </div>
                    <!-- Esta dentro del row -->
                    <div class="d-flex justify-content-evenly align-items-center mb-2">
                        <button type="submit" class="btn btn-primary" id="btnConfirmarVenta"> Confirmar venta</button>
                    </div>
                </form>
            </div>
        </div>

<!-- Div a la derecha que contiene el grupo de tragos -->
        <div class="col-md-8 div-col-ventas2" id="div_row">
            <div class="row div_row_tragos">
                <div class="col-sm favoritos ">
                    <form action=""  method="POST" id="formFavoritos">
                        <input type="hidden" name="favoritos" value="favoritos">
                        <button type="submit" class="p-grupo-tragos btn-ventas" id="btnfavoritos">Favoritos <span><i class="fa-regular fa-star"></i></span></button>
                    </form>
                </div>  
                <div class="col-md-8 div-grupo-tragos" id="div-grupo-tragos">
                    <div class="row bg bg-secondary bg-gradient" id="rowTragos">
                    
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
<script src="../index.js"></script>
<?php include("../template/footer.php") ?>