<?php
session_start();
include("../config/db.php"); 
include("../template/cabecera.php");
?>

<!-- ------------------------------------------------------- -->
<div class="p-5 bg-light text-center">
    <div class="container">
                <h1 class="display-3">Bienvenido al sistema de Ronnie Bar</h1>
                <p class="lead">Un bar de amigos</p>
                <hr class="my-2">
                <img src="../imagenes/portada_ronnie.jpeg" alt="imagen" class="img-fluid ronnie_portada">
                <!-- <p>Más información</p> -->
                <p class="lead">
                    <a class="btn btn-primary btn-lg my-2" href="productos.php" role="button">Cargar productos</a>
                </p>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="index.js"></script>
</body>
</html>

