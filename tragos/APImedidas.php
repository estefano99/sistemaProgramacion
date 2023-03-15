<?php
    session_start();
    include("../config/db.php");
    
    echo $_POST["id_tragos"];
    $tragos = $_POST["id_tragos"];
    $consulta = $conexion -> prepare("SELECT productos.nombre as 'producto',cantidad_medida from productos,prod_tragos where  prod_tragos.id_tragosFK = :id_tragos and productos.id_productos = prod_tragos.id_productosFK");
    $consulta -> bindParam("id_tragos",$tragos["id_tragos"]);
    $consulta -> execute();
    $listaMedidasProductos = $consulta ->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($listaMedidasProductos);
?>