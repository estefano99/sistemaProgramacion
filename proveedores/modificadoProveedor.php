<?php
    session_start();
    include("../config/db.php");
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];

    $consulta = $conexion -> prepare("UPDATE proveedores set nombre = :nombre, telefono = :telefono where id_proveedores = :id");
    $consulta -> bindParam("nombre",$nombre);
    $consulta -> bindParam("telefono",$telefono);
    $consulta -> bindParam("id",$id);
   
    $nombreModificado = $nombre;
    if ($consulta -> execute()) {   //Se ejecuta la consulta
        header("location:proveedores.php?upd=$nombreModificado"); //paso la variable para mostrar un mensaje de modificado correctamente
        
    }else{
        echo "
        <div class='container d-flex justify-content-center'>
            <div class=' m-5 border border-info d-flex flex-column '>
                <p>Hubo un error, vuelva a ingresar los datos.</p> <br>
                <a href='proveedores.php' class='m-auto'> <button class='btn btn-secondary'>Volver</button> </a>
            </div>
        </div>";
    }
?>