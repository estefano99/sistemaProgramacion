<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    $nombre = $_POST["nombre"];
    $tipoProducto = $_POST["tipoProducto"];
    $medida = $_POST["medida"];
    $precio = $_POST["precio"];
    $imagen = (isset($_FILES["imagen"]))? $_FILES["imagen"]["name"] : "" ;
    $estado = 1;
    
    //Valido que no exista ese producto con esa medida
    $consulta = $conexion -> prepare("SELECT nombre,id_medidaFK from productos where nombre = :nombre and id_medidaFK = :id_medidaFK");
    $consulta -> bindParam("nombre",$nombre); 
    $consulta -> bindParam("id_medidaFK",$medida); 
    $consulta -> execute();
    $listaConsulta = $consulta -> fetch(PDO::FETCH_LAZY);

    $consulta = $conexion -> prepare("INSERT INTO productos (nombre,id_tipoBebidaFK,id_medidafk,precio,imagen,estado) VALUES (:nombre,:id_tipoBebidaFK,:id_medidafk,:precio,:imagen,:estado)");
    $consulta -> bindParam(":nombre",$nombre);
    $consulta -> bindParam(":id_tipoBebidaFK",$tipoProducto);
    $consulta -> bindParam(":id_medidafk",$medida);
    $consulta -> bindParam(":precio",$precio);
    $consulta -> bindParam(":estado",$estado);
    
    //Por si hay dos imagenes con el mismo nombre, diferenciarlas con la fecha.
    $fecha = new DateTime();
    $nombreArchivo = ($imagen != "") ? $fecha -> getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg"; //Si no es vacio, le guardo la fecha _ nombre imagen sino imagen.jpg

    $tmpImagen = $_FILES["imagen"]["tmp_name"];  //Guardo una imagen temporal 

    if ($tmpImagen != "") {
        move_uploaded_file($tmpImagen, "../imagenesProductos/".$nombreArchivo);
    }

    if ($listaConsulta) {
        $mensajeError = "Error. Producto ya existente";
        Header("Location:productos.php?msge=$mensajeError"); //recargo la pagina
    }else{
        $consulta -> bindParam(":imagen",$nombreArchivo);
        $consulta -> execute();
        $mensajeNombre = $nombre;
        Header("Location:productos.php?msg=$mensajeNombre"); //recargo la pagina

    }

    //EXPLIACION : Agarramos la foto y guardamos la hora en $nombreArchivo, en $tmpimagen creamos una imagen temporal, en el if,
    // si la imagen no viene vacia, muevo la img temporal a la carpeta imagenes, con el nombre de la variable $nombreArchivo
?>