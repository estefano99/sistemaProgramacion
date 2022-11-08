<?php
    session_start();
    include("../config/db.php");
    $medida = $_POST["medida"];
    $estado = 1;

    //Valido que no exista esa medida
    $consulta = $conexion -> prepare("SELECT medida from medida where medida = :medida ");
    $consulta -> bindParam("medida",$medida); 
    $consulta -> execute();
    $listaConsulta = $consulta -> fetch(PDO::FETCH_LAZY);

    if ($listaConsulta) {

        $mensajeError = "Error. Medida ya existente.";
		header("location:medidas.php?msge=$mensajeError");
        
    }else{

        $consulta = $conexion -> prepare("INSERT INTO medida(medida,estado) values (:medida,:estado)");
        $consulta -> bindParam("medida",$medida);
        $consulta -> bindParam("estado",$estado);
        $consulta -> execute();
        header("location:medidas.php");
    }
    
?>