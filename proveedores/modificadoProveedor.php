<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $cuit = (isset($_POST["cuit"])) ? $_POST["cuit"] : "";

    $consulta = $conexion -> prepare("SELECT nombre,cuit from proveedores where nombre = :nombre and cuit = :cuit and id_proveedores != :id and estado = 1");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("cuit",$cuit);
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaConsulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    if ($listaConsulta) {
        $errorEdicion = "Error en la edición. Proveedor ya existente.";
		header("location:proveedores.php?upde=$errorEdicion");
    }else {
        
        $consulta = $conexion -> prepare("UPDATE proveedores set nombre = :nombre, telefono = :telefono where id_proveedores = :id");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("telefono",$telefono);
        $consulta -> bindParam("id",$id);
        $nombreModificado = $nombre . "Editado correctamente";
        $consulta -> execute();
        header("location:proveedores.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
            
        
    }

?>