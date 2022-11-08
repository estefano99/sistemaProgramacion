<?php
    include("../config/db.php");
    $id = (isset($_POST["id"]) ? $_POST["id"] : "");

    if ($id) {
        $estado = 1;
        $consulta = $conexion -> prepare("UPDATE tipodeproducto set estado = :estado where id_tipodeproducto = :id");
        $consulta -> bindParam("estado",$estado);
        $consulta -> bindParam("id",$id);
        $consulta -> execute();
        header("location:tipoDeProducto.php");
    }

?>