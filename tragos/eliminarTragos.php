<?php
    session_start();
    include("../config/db.php");

    $id = (isset($_GET["usr"])) ? $_GET["usr"] : "";
    $estado = 0;
    
    $consulta = $conexion -> prepare("UPDATE tragos set estado = :estado where id_tragos = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> bindParam("estado",$estado);  //Baja logica
    $consulta -> execute();
    header("location:tragos.php")
?>