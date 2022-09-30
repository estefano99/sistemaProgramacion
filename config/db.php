<?php
    $host = "localhost";
    $dbname = "sistemaprogramacion";
    $usuario = "root";
    $contrasenia = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname",$usuario,$contrasenia);
        // if ($conexion) { echo "Conectado al sistema"; }
    } catch (Exception $e) {
        echo "$e -> getMessage";
    }
?>