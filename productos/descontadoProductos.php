<?php
    session_start();
    include("../config/db.php");

    $fecha = (isset($_POST["fecha"]) ? $_POST["fecha"] : "");
    $id_productos = (isset($_POST["id"]) ? $_POST["id"] : "");
    $cantidad = (isset($_POST["cantidad"]) ? $_POST["cantidad"] : "");
    $motivo = (isset($_POST["motivo"]) ? $_POST["motivo"] : "");

    $consulta = $conexion -> prepare("SELECT stock,nombre from productos where id_productos = :id_productos");
    $consulta -> bindParam("id_productos",$id_productos);
    $consulta -> execute();
    $datos = $consulta -> fetch(PDO::FETCH_LAZY);
    $cantidadStock = $datos["stock"];
  
    if ($cantidadStock > $cantidad) {
        //Insert en la tabla reduccion
        $consulta = $conexion -> prepare("INSERT into reduccion (fecha,cantidad,id_productosFK,id_motivosFK) values (:fecha,:cantidad,:id_productosFK,:id_motivosFK)");
        $consulta -> bindParam("fecha",$fecha);
        $consulta -> bindParam("cantidad",$cantidad);
        $consulta -> bindParam("id_productosFK",$id_productos);
        $consulta -> bindParam("id_motivosFK",$motivo);
        $consulta -> execute();
        
        //Descuento el stock en la tabla productos
        $consulta = $conexion -> prepare("UPDATE productos set stock = stock - :cantidad where id_productos = :id_productos");
        $consulta -> bindParam("cantidad",$cantidad);
        $consulta -> bindParam("id_productos",$id_productos);
        $consulta -> execute();
        
        echo json_encode('Descuento de stock registado');
    }else {
        echo json_encode($cantidadStock);
    }


  

?>