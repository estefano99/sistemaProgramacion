<?php
    session_start();
    include("../config/db.php");
    $estado = 0;

    (isset($_GET["usr"])) ? $id = $_GET["usr"] : "";  //Si se envia algo se guarda en la variable id
    
    $consulta = $conexion -> prepare("UPDATE productos set estado = :estado where id_productos = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> bindParam("estado",$estado);  //Baja logica
    $consulta -> execute();
    header("location:productos.php")
?>