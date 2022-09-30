<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    $consulta = $conexion -> prepare("UPDATE tipodeproducto set nombre = :nombre where id_tipodeproducto = :id");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("id",$id);
   
    $nombreModificado = $nombre;
    if ($consulta -> execute()) {   //Se ejecuta la consulta
        header("location:tipoDeProducto.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
        
        include("../template/cabecera.php");
    }else{
        echo "
        <div class='container d-flex justify-content-center'>
            <div class=' m-5 border border-info d-flex flex-column '>
                <p>Hubo un error, vuelva a ingresar los datos.</p> <br>
                <a href='tipoDeProducto.php' class='m-auto'> <button class='btn btn-secondary'>Volver</button> </a>
            </div>
        </div>";
    }
?>