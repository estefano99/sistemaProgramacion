<?php
    session_start();
    include("../config/db.php");
    $medida = $_POST["medida"];
    $estado = 1;
    
    $consulta = $conexion -> prepare("INSERT INTO medida(medida,estado) values (:medida,:estado)");
    $consulta -> bindParam("medida",$medida);
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    header("location:medidas.php");
    
?>