<?php
    session_start();
    include("../config/db.php");
    $cantidad = (isset($_POST["cantidad_tragos"])) ? $_POST["cantidad_tragos"] : "" ;
    $id = (isset($_POST["id"])) ? $_POST["id"] : "" ;
    $fechaActual = date('Y-m-d');
    $fechaActual = strval($fechaActual);
    $length = count($cantidad);
    $precio_total = 0;

    for ($i=0; $i <$length; $i++) { 
        $consulta = $conexion -> prepare("SELECT precio from tragos where id_tragos = :id_tragos");
        $consulta -> bindParam("id_tragos",$id[$i]);
        $consulta -> execute();
        $listaTrago = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        $precio_total += $listaTrago[0]["precio"] * $cantidad[$i];  //Cantidad por el precio de cada trago
    }
    
    $consulta = $conexion -> prepare("INSERT INTO ventas(fecha,precio_total) VALUES (:fecha,:precio_total)");
    $consulta -> bindParam("fecha",$fechaActual);
    $consulta -> bindParam("precio_total",$precio_total);
    $consulta -> execute();
    $last_id = $conexion->lastInsertId(); //Saco el ultimo id
    $last_id = intval($last_id);

    for ($i=0; $i < $length; $i++) {
        
        $consulta = $conexion -> prepare("SELECT precio from tragos where id_tragos = :id_tragos");
        $consulta -> bindParam("id_tragos",$id[$i]);
        $consulta -> execute();
        $listaTrago = $consulta -> fetchAll(PDO::FETCH_ASSOC);

       $consulta = $conexion -> prepare("INSERT INTO tragos_ventas(id_tragosFK,id_ventasFK,cantidad,precio_venta_tragos) VALUES (:id_tragosFK,:id_ventasFK,:cantidad,:precio_venta_tragos)");
       $consulta -> bindParam("id_tragosFK",$id[$i]);
       $consulta -> bindParam("id_ventasFK",$last_id);
       $consulta -> bindParam("cantidad",$cantidad[$i]);
       $consulta -> bindParam("precio_venta_tragos",$listaTrago[0]["precio"]); //El precio de cada trago lo guarda en el historico
       $consulta -> execute();
    }
    echo json_encode("vendido");
    
?>