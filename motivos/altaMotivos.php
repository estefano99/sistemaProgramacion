<?php
     session_start();
     include("../config/db.php");
     $motivo = (isset($_POST["motivo"])) ? $_POST["motivo"] : "" ; 
     $estado = 1;

    //Valido que no exista ese motivos
    $consulta = $conexion -> prepare("SELECT motivo from motivo where motivo = :motivo");
    $consulta -> bindParam("motivo",$motivo); 
    $consulta -> execute();
    $listaConsulta = $consulta -> fetch(PDO::FETCH_LAZY);

    if ($listaConsulta) {
        $mensajeError = "Error. Motivo ya existente.";
		header("location:motivos.php?msge=$mensajeError");
    }else{
        $consulta = $conexion -> prepare("INSERT into motivo(motivo,estado) values (:motivo,:estado)");
        $consulta -> bindParam(":motivo",$motivo);
        $consulta -> bindParam(":estado",$estado);
        $consulta -> execute();
        header("location:motivos.php");
    }
   
          

?>