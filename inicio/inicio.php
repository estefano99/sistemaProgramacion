<?php
session_start();
include("../config/db.php"); 
?>
<?php include("../template/cabecera.php") ?> 

    <div class="container-fluid p-0">

        <div class="row m-0 img-pc">
            <div class="col-12 p-0 ">
            <img src="../imagenes/inicio_ronnie2.jpg" class="img-fluid img-inicio" alt="Mi imagen">
            </div>
        </div>

        <div class="row img-celular">
            <img src="../imagenes/inicio_celular.jpg" class="img-fluid img-inicio" alt="Mi imagen">
            <div class="col-12 p-0 ">
            </div>
        </div>

    </div>
    <script src="./inicio.js"></script>
<?php include("../template/footer.php") ?> 


