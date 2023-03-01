<?php
    session_start();
    include("../config/db.php");

    $id = (isset($_POST["id"]) ? $_POST["id"] : "");
    $favoritos = (isset($_POST["favoritos"]) ? $_POST["favoritos"] : "");
    $estado = 1;
    if ($id) {
        $consulta = $conexion -> prepare("SELECT * from tragos where id_tipodetragosFK = :id and estado = :estado order by nombre;");
        $consulta -> bindParam("id",$id);
        $consulta -> bindParam("estado",$estado);
        $consulta -> execute();
        $listaTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($listaTragos);
    }

    if ($favoritos) {
        $si = "si";
        $consulta = $conexion -> prepare("SELECT id_tragos,nombre,precio from tragos where favoritos = :si and estado = :estado order by nombre;");
        $consulta -> bindParam("si",$si);
        $consulta -> bindParam("estado",$estado);
        $consulta -> execute();
        $listaFavoritos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($listaFavoritos);
    }
?>