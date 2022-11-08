<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $motivo = $_POST["motivo"];
    $tipo = $_POST["tipo"];

    $consulta = $conexion -> prepare("SELECT motivo from motivo where motivo = :motivo and id_motivo != :id and estado = 1");
    $consulta -> bindParam("motivo",$motivo);
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaConsulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    if ($listaConsulta) {
        $errorEdicion = "Error en la edición. Motivo ya existente.";
		header("location:motivos.php?upde=$errorEdicion");
    }else {
        $consulta = $conexion -> prepare("UPDATE motivo set motivo = :motivo , tipo = :tipo where id_motivo = :id");
        $consulta -> bindParam("motivo",$motivo);
        $consulta -> bindParam("tipo",$tipo);
        $consulta -> bindParam("id",$id);
        $nombreModificado = $motivo;
        $consulta -> execute();
        header("location:motivos.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
            
    }
    
   
    
?>