<?php
    session_start();
    include("../config/db.php");

    $estado = 0;
    $consulta = $conexion -> prepare("SELECT id_tragos,tragos.nombre as 'nombre',descripcion,precio,imagen,favoritos,tipodetragos.nombre as 'tipo' from tragos,tipodetragos where tragos.estado = :estado and tragos.id_tipodetragosFK = tipodetragos.id_tipodetragos");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($listaTragos);
?>