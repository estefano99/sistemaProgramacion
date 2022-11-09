<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    $consulta = $conexion -> prepare("SELECT nombre from tipodetragos where nombre = :nombre and id_tipodetragos != :id and estado = 1");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaConsulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    if ($listaConsulta) {
        $errorEdicion = "Error en la edición. Tipo de trago ya existente.";
		header("location:tipoDeTragos.php?upde=$errorEdicion");
    }else {
        $consulta = $conexion -> prepare("UPDATE tipodetragos set nombre = :nombre where id_tipodetragos = :id");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("id",$id);
        $nombreModificado = $nombre;
        $consulta -> execute();
        header("location:tipoDeTragos.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
    }    
?>