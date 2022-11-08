<?php
    include("../config/db.php");
    $id = (isset($_POST["id"])) ? $_POST["id"] : "";
    $estado = 1;
    if ($id) {
        $consulta = $conexion -> prepare("UPDATE productos set estado = :estado where id_productos = :id");
        $consulta -> bindParam("estado",$estado);
        $consulta -> bindParam("id",$id);
        $consulta -> execute();
        header("location:productos.php");
    }
?>