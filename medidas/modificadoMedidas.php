<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $medida = $_POST["medida"];

    $consulta = $conexion -> prepare("SELECT medida from medida where medida = :medida and id_medida != :id and estado = 1");
    $consulta -> bindParam("medida",$medida);
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaConsulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    if ($listaConsulta) {
        $errorEdicion = "Error en la edición. Medida ya existente.";
		header("location:medidas.php?upde=$errorEdicion");
    }else{
        
        $consulta = $conexion -> prepare("UPDATE medida set medida = :medida where id_medida = :id");
        $consulta -> bindParam("medida",$medida);
        $consulta -> bindParam("id",$id);
        $nombreModificado = $medida;
        header("location:medidas.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
    }
?>