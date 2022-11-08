<?php 
    session_start();
    include("../config/db.php");

    $nombre = (isset ($_POST["nombre"])) ? $_POST["nombre"] : "";
    $descripcion = (isset ($_POST["descripcion"])) ? $_POST["descripcion"] : "";
    $precio = (isset ($_POST["precio"])) ? $_POST["precio"] : "";
    $favorito = (isset ($_POST["favorito"])) ? $_POST["favorito"] : "";
    $imagen = (isset ($_FILES["imagen"])) ? $_FILES["imagen"]["name"] : "";
    $producto = (isset($_POST["producto"])) ? $_POST["producto"] : "";
    $medida = (isset($_POST["medida"])) ? $_POST["medida"] : $_POST["medida"];
    $length = count($producto);
    $estado = 1;
   
    $consulta = $conexion -> prepare("SELECT nombre from tragos where nombre = :nombre");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> execute();
    $listaTragos = $consulta -> fetch(PDO::FETCH_LAZY);

    if ($listaTragos) {
        $mensajeAlta = "Trago ya existente";
        header("location:tragos.php?alt=$mensajeAlta");
    }else {
        $consulta = $conexion -> prepare("INSERT into tragos(nombre,descripcion,precio,favoritos,imagen,estado) values (:nombre,:descripcion,:precio,:favoritos,:imagen,:estado)");
        $consulta -> bindParam("nombre",$nombre);
        $consulta -> bindParam("descripcion",$descripcion);
        $consulta -> bindParam("precio",$precio);
        $consulta -> bindParam("favoritos",$favorito);
        $consulta -> bindParam("estado",$estado);

        $fecha = new DateTime();
        $nombreArchivo = ($imagen != "") ? $fecha -> getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg"; 
    
        $tmpImagen = $_FILES["imagen"]["tmp_name"];  //Guardo una imagen temporal 
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../imagenesTragos/".$nombreArchivo);
        }
        $consulta -> bindParam("imagen",$nombreArchivo);
        $consulta -> execute();
        $last_id = $conexion->lastInsertId(); //Saco el ultimo id
        $last_id = intval($last_id); 

        for ($i=0; $i < $length; $i++) {
            $producto[$i] = intval($producto[$i]); 
            $consulta = $conexion -> prepare("INSERT INTO prod_tragos(id_tragosFK,id_productosFK,cantidad_medida) VALUES (:id_tragosFK,:id_productosFK,:cantidad_medida)");
            $consulta -> bindParam("id_tragosFK",$last_id);
            $consulta -> bindParam("id_productosFK",$producto[$i]);
            $consulta -> bindParam("cantidad_medida",$medida[$i]);
            $consulta -> execute();
            $mensaje = "Trago creado correctamente";
            header("location:tragos.php?altc=$mensaje");
        }
    }

    
?>