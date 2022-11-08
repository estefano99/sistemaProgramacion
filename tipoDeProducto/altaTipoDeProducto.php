<?php
    session_start();
    include("../config/db.php");
    $nombre = $_POST["nombre"];
    $estado = 1;
    
    //Valido que no exista ese tipo
    $consulta = $conexion -> prepare("SELECT nombre from tipodeproducto where nombre = :nombre");
    $consulta -> bindParam("nombre",$nombre); 
    $consulta -> execute();
    $listaConsulta = $consulta -> fetch(PDO::FETCH_LAZY);

    if ($listaConsulta) {
        $mensajeError = "Error. Tipo de producto ya existente.";
		header("location:tipoDeProducto.php?msge=$mensajeError");
    }else{
        $consulta = $conexion -> prepare("INSERT INTO tipodeproducto(nombre,estado) values (:nombre,:estado)");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("estado",$estado);
        $consulta -> execute();
        $listaTipoDeProducto = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        header("location:tipoDeProducto.php");

    }
    
?>