<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");
    $id = $_POST["id"];
    $cantidad = $_POST["cantidad"];
    $precioUnidad = $_POST["precioUnidad"];
    $fecha = $_POST["fecha"];
    $proveedor = $_POST["proveedor"];

    //Se guarda en tabla compras , campo precio total
   $precioTotal = $precioUnidad * $cantidad;
        
    //Actualizo el precio en caso de que lo haya cambiado el usuario.
   $consulta = $conexion -> prepare("UPDATE productos set precio = :precio where id_productos = :id");
   $consulta -> bindParam("precio",$precioUnidad);
   $consulta -> bindParam("id",$id);
   $consulta -> execute();
   
   //Ingreso en la tabla intermedia de proveedores - productos los datos
   $consulta = $conexion -> prepare("INSERT into prov_prod (id_prov_prod , id_proveedoresFK,id_productosFK) values (NULL, :proveedor, :id_producto)");
   $consulta -> bindParam("proveedor",$proveedor);
   $consulta -> bindParam("id_producto",$id);
   $consulta -> execute();
   
   //Actualizar el stock
   $consulta = $conexion -> prepare("UPDATE productos set stock = stock + :stock where id_productos = :id_productos"); 
   $consulta -> bindParam("stock",$cantidad);
   $consulta -> bindParam("id_productos",$id);
   $consulta -> execute();
   
   //Compras
   $consulta = $conexion -> prepare("INSERT into compras (id_compras,fecha,precio_total) values (NULL , :fecha , :precio_total)");
   $consulta -> bindParam("fecha",$fecha);
   $consulta -> bindParam("precio_total",$precioTotal);
   $consulta -> execute();
   $last_id = $conexion->lastInsertId(); //Saco el ultimo id
   
   //Tabla intermedia Productos-Compras
    $consulta = $conexion -> prepare("INSERT into prod_comp(id_prod_comp , id_productosFK , id_comprasFK, cantidad) VALUES (NULL , :id_productosFK , :id_comprasFK, :cantidad)");
    $consulta -> bindParam("id_productosFK",$id);
    $consulta -> bindParam("id_comprasFK",$last_id);
    $consulta -> bindParam("cantidad",$cantidad);
    $consulta -> execute();

    $compraMensaje = "Se ingresaron los producto con éxito";
    header("Location:productos.php?cmp=$compraMensaje");
?>