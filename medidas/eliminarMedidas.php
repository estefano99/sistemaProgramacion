<?php
    session_start();
    include("../config/db.php");
    $estado = 0;

    if (isset($_GET["url"])) $id = $_GET["url"];  //Si se envia algo se guarda en la variable id

    $consulta = $conexion -> prepare("UPDATE medida set estado = :estado where id_medida = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> bindParam("estado",$estado);  //Baja logica
    $consulta -> execute();
    header("location:medidas.php")
?>