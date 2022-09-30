<?php
    session_start();
    include("../config/db.php");
    $estado = 0;

    if (isset($_GET["usr"])) $id = $_GET["usr"];  //Si se envia algo se guarda en la variable i

    $consulta = $conexion -> prepare("UPDATE proveedores set estado = :estado where id_proveedores = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> bindParam("estado",$estado);  //Baja logica
    $consulta -> execute();
    header("location:proveedores.php")
?>