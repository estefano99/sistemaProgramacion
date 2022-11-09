<?php
    include("../config/db.php");
    $id = (isset($_POST["id"]) ? $_POST["id"] : "");

    if ($id) {
        $estado = 1;
        $consulta = $conexion -> prepare("UPDATE tipodetragos set estado = :estado where id_tipodetragos = :id");
        $consulta -> bindParam("estado",$estado);
        $consulta -> bindParam("id",$id);
        $consulta -> execute();
        header("location:tipoDeTragos.php");
    }

?>