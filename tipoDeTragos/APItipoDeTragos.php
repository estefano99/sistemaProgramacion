<?php
session_start();
include("../config/db.php");
    $estado = 1;
    $consulta = $conexion -> prepare("SELECT * from tipodetragos where estado = :estado");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTipo = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($listaTipo);
?>