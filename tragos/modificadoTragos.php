<?php
     session_start();
     include("../config/db.php");

     $id = (isset ($_POST["id"])) ? $_POST["id"] : "";
     $nombre = (isset ($_POST["nombre"])) ? $_POST["nombre"] : "";
     $tipodetrago = (isset($_POST["tipodetrago"])) ? $_POST["tipodetrago"] : "";
     $descripcion = (isset ($_POST["descripcion"])) ? $_POST["descripcion"] : "";
     $precio = (isset ($_POST["precio"])) ? $_POST["precio"] : "";
     $favorito = (isset ($_POST["favorito"])) ? $_POST["favorito"] : "";
     $imagen = (isset ($_FILES["imagen"]["name"])) ? $_FILES["imagen"]["name"] : "";
     $producto = (isset($_POST["producto"])) ? $_POST["producto"] : "";
     $medida = (isset($_POST["medida"])) ? $_POST["medida"] : "";
     
     if ($producto) {
         $length = count($producto);
     }
     $estado = 1;
    
     $consulta = $conexion -> prepare("SELECT * from tragos where nombre = :nombre and id_tragos != :id");
     $consulta -> bindParam("nombre",$nombre);
     $consulta -> bindParam("id",$id);
     $consulta -> execute();
     $listaTragos = $consulta -> fetch(PDO::FETCH_LAZY);
 
     if ($listaTragos) {
         $mensajeAlta = "Trago ya existente";
         header("location:tragos.php?alt=$mensajeAlta");
     }else {
         $consulta = $conexion -> prepare("UPDATE tragos set nombre = :nombre ,id_tipodetragosFK = :tipodetrago ,descripcion = :descripcion , precio = :precio , favoritos = :favoritos , estado = :estado where id_tragos = :id");
         $consulta -> bindParam("nombre",$nombre);
         $consulta -> bindParam("tipodetrago",$tipodetrago);
         $consulta -> bindParam("descripcion",$descripcion);
         $consulta -> bindParam("precio",$precio);
         $consulta -> bindParam("favoritos",$favorito);
         $consulta -> bindParam("estado",$estado);
         $consulta -> bindParam("id",$id);
         $consulta -> execute();

         if ($imagen != "") {
         $fecha = new DateTime();
         $nombreArchivo = ($imagen != "") ? $fecha -> getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg"; 
     
         $tmpImagen = $_FILES["imagen"]["tmp_name"];  //Guardo una imagen temporal 
         if ($tmpImagen != "") {
             move_uploaded_file($tmpImagen, "../imagenesTragos/".$nombreArchivo);
         }
          //BORRO la imagen
          $consultaImagen = $conexion -> prepare("SELECT imagen FROM tragos WHERE id_tragos = :id"); //pregunto cual es el id con esa imagen
          $consultaImagen -> bindParam(":id",$id);
          $consultaImagen -> execute();
          $datos = $consultaImagen -> fetch(PDO::FETCH_LAZY);  //recupero la imagen
          if (isset($datos["imagen"]) && ($datos["imagen"] != "imagen.jpg")) {  //si es que existe esa imagen y es diferente al valor imagen.jpg que equivale a ninguna imagen
  
              if (file_exists("../imagenesTragos/".$datos["imagen"])) {  //Busco si es que existe en la carpeta imagenes
                  unlink("../imagenesTragos/".$datos["imagen"]);   //la borro
              }
          }
         $consultaImagen = $conexion -> prepare("UPDATE tragos SET imagen = :imagen WHERE id_tragos = :id");
         $consultaImagen -> bindParam("imagen",$nombreArchivo);
         $consultaImagen -> bindParam(":id",$id);
         $consultaImagen -> execute();
         }

         //Trae el id del producto para saber que producto actualizar, porque solo el ID del TRAGO me actualiza todo con ese id.
          $consulta = $conexion -> prepare("SELECT * from prod_tragos where id_tragosFK = :id");
          $consulta -> bindParam("id",$id);
          $consulta -> execute();
          $listaTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
         
         for ($i=0; $i < $length; $i++) {
             $producto[$i] = intval($producto[$i]); 
            
             $consulta = $conexion -> prepare("UPDATE prod_tragos SET id_productosFK = :id_productosFK , cantidad_medida = :cantidad_medida WHERE id_tragosFK = :id_tragosFK and id_productosFK = :consultaID");
             $consulta -> bindParam("id_tragosFK",$id);
             $consulta -> bindParam("id_productosFK",$producto[$i]);
             $consulta -> bindParam("cantidad_medida",$medida[$i]);
             $consulta -> bindParam("consultaID",$listaTragos[$i]["id_productosFK"]);
             $consulta -> execute();
             $mensaje = "Trago modificado correctamente";
            }
        header("location:tragos.php?altc=$mensaje");
     }
?>