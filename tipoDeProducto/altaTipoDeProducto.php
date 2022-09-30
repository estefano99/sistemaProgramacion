<?php
    session_start();
    include("../config/db.php");
    $nombre = $_POST["nombre"];
    $estado = 1;
    
    $consulta = $conexion -> prepare("INSERT INTO tipodeproducto(nombre,estado) values (:nombre,:estado)");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTipoDeProducto = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    header("location:tipoDeProducto.php");
    
?>