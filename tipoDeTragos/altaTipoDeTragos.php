<?php
    session_start();
    include("../config/db.php");
    $nombre = $_POST["nombre"];
    $estado = 1;
    
    //Valido que no exista ese tipo
    $consulta = $conexion -> prepare("SELECT nombre from tipodetragos where nombre = :nombre");
    $consulta -> bindParam("nombre",$nombre); 
    $consulta -> execute();
    $listaConsulta = $consulta -> fetch(PDO::FETCH_LAZY);

    if ($listaConsulta) {
        $mensajeError = "Error. Tipo de trago ya existente.";
		header("location:tipoDeTragos.php?msge=$mensajeError");
    }else{
        $consulta = $conexion -> prepare("INSERT INTO tipodetragos(nombre,estado) values (:nombre,:estado)");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("estado",$estado);
        $consulta -> execute();
        $listaTipoDeTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        header("location:tipoDeTragos.php");
    }
    
?>