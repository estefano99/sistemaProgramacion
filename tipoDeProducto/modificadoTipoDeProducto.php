<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    $consulta = $conexion -> prepare("SELECT nombre from tipodeproducto where nombre = :nombre and id_tipodeproducto != :id and estado = 1");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaConsulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    if ($listaConsulta) {
        $errorEdicion = "Error en la edición. Tipo de producto ya existente.";
		header("location:tipoDeProducto.php?upde=$errorEdicion");
    }else {
        $consulta = $conexion -> prepare("UPDATE tipodeproducto set nombre = :nombre where id_tipodeproducto = :id");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("id",$id);
        $nombreModificado = $nombre;
        $consulta -> execute();
        header("location:tipoDeProducto.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
    }

        
        
?>