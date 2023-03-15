<?php
    session_start();
    include("../config/db.php");

    $estado2 = 0;
    $consulta = $conexion -> prepare("SELECT id_productos,productos.nombre as 'nombre',stock,precio,imagen,medida.medida as 'medida',tipodeproducto.nombre as 'tipo'
    from productos,medida,tipodeproducto
    where id_medidaFK = id_medida and id_tipoBebidaFK = id_tipodeproducto and productos.estado = :estado2
    order by productos.nombre asc");

    $consulta -> bindParam("estado2",$estado2);
    $consulta -> execute();
    $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($listaProductos);
?>