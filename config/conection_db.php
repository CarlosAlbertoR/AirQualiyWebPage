<?php
include("config_db.php");

try {
    $conection = new PDO("pgsql:host=$server;port=$port;dbname=$database", $user, $password);
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
}
