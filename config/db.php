<?php
    require __DIR__ . '/../vendor/autoload.php'; // carga Composer
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__,"/../.env"); // carga el archivo .env
    $dotenv->load(); // carga las variables de entorno

    $host = $_ENV["HOST"];
    $dbname = $_ENV["DBNAME"];
    $usuario = $_ENV["USUARIO"];;
    $contrasenia = $_ENV["CONTRASENIA"];

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname",$usuario,$contrasenia);
    } catch (Exception $e) {
        echo "$e -> getMessage";
    }
?>