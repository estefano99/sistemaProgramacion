<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $medida = $_POST["medida"];

    $consulta = $conexion -> prepare("UPDATE medida set medida = :medida where id_medida = :id");
    $consulta -> bindParam("medida",$medida);
    $consulta -> bindParam("id",$id);
   
    $nombreModificado = $medida;
    if ($consulta -> execute()) {   //Se ejecuta la consulta
        header("location:medidas.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
        include("../template/cabecera.php");
    }else{
        echo "
        <div class='container d-flex justify-content-center'>
            <div class=' m-5 border border-info d-flex flex-column '>
                <p>Hubo un error, vuelva a ingresar los datos.</p> <br>
                <a href='medidas.php' class='m-auto'> <button class='btn btn-secondary'>Volver</button> </a>
            </div>
        </div>";
    }
?>