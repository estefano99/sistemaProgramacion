<?php
    session_start();
    include("../config/db.php");
    
    (isset($_POST["id"])) ? $id = $_POST["id"] : "";  //Si se envia algo se guarda en la variable id
    $estado = 1;
    
    $consulta = $conexion -> prepare("UPDATE tragos set estado = :estado where id_tragos = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> bindParam("estado",$estado);  //Baja logica
    $consulta -> execute();
    header("location:tragos.php")
?>