<?php
    session_start();
    include("../config/db.php");

    $estado = 1;
    $consulta = $conexion -> prepare("SELECT id_productos,productos.nombre as 'nombre',stock,precio,imagen,medida.medida as 'medida',tipodeproducto. nombre as 'tipo'
    from productos,medida,tipodeproducto
    where id_medidaFK = id_medida and id_tipoBebidaFK = id_tipodeproducto and productos.estado = :estado
    order by productos.nombre asc");

    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($listaProductos);
?>