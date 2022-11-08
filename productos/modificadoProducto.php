<?php
//arreglar , hacer select en modificar productos para medida y tipo y pasar el id asi lo meto en el update
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $id_medida = $_POST["medida"];
    $precio = intval($_POST["precio"]);
    $id_tipo = intval($_POST["tipoProducto"]);
    $imagen = (isset($_FILES["imagen"]["name"])) ? $_FILES["imagen"]["name"] : "" ;
    
    $consulta = $conexion -> prepare("SELECT nombre,id_medidaFK from productos where nombre = :nombre and id_medidaFK = :id_medidaFK and id_productos != :id and estado = 1");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("id_medidaFK",$id_medida);
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaConsulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
    if ($listaConsulta) {
        $errorEdicion = "Error en la edición. Producto ya existente.";
		header("location:productos.php?upde=$errorEdicion");
    }else{

        $consulta = $conexion -> prepare("UPDATE productos set nombre = :nombre, id_medidaFK = :id_medidaFK,precio = :precio,id_tipoBebidaFK = :id_tipoBebidaFK
        where id_productos = :id");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("id_medidaFK",$id_medida);
        $consulta -> bindParam("precio",$precio);
        $consulta -> bindParam("id_tipoBebidaFK",$id_tipo);
        $consulta -> bindParam("id",$id);
        $consulta -> execute();
        $nombreModificado = $nombre;
        //Modificar la imagen en caso de que no este vacio
        if ($imagen != "") {
    
            //Actualizo la imagen
            $fecha = new DateTime();
            $nombreArchivo = ($imagen != "") ? $fecha -> getTimestamp() . "_" . $imagen : "imagen.jpg"; //Si no es vacio, le guardo la fecha _ nombre imagen sino imagen.jpg
    
            $tmpImagen = $_FILES["imagen"]["tmp_name"];  //Guardo una imagen temporal
            move_uploaded_file($tmpImagen, "../imagenesProductos/".$nombreArchivo);
    
            //BORRO la imagen
            $consultaImagen = $conexion -> prepare("SELECT imagen FROM productos WHERE id_productos = :id"); //pregunto cual es el id con esa imagen
            $consultaImagen -> bindParam(":id",$id);
            $consultaImagen -> execute();
            $datos = $consultaImagen -> fetch(PDO::FETCH_LAZY);  //recupero el ID
    
            if (isset($datos["imagen"]) && ($datos["imagen"] != "imagen.jpg")) {  //si es que existe esa imagen y es diferente al valor imagen.jpg que equivale a ninguna imagen
    
                if (file_exists("../imagenesProductos/".$datos["imagen"])) {  //Busco si es que existe en la carpeta imagenes
                    unlink("../imagenesProductos/".$datos["imagen"]);   //la borro
                }
            }
            //Actualizo la imagen nueva
            $consultaImagen = $conexion -> prepare("UPDATE productos SET imagen = :imagen WHERE id_productos = :id");
            $consultaImagen -> bindParam(":imagen",$nombreArchivo);  //Paso el nuevo nombre del archivo
            $consultaImagen -> bindParam(":id",$id);
            $consultaImagen-> execute();
        }
    
        header("location:productos.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
    }



?>