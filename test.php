<?php
require_once 'models/DB.php';
require_once 'models/Camiseta.php';

$conexion = DB::getConnection();
if ($conexion) {
    echo "La conexión a la base de datos se realizó correctamente.<br>";
} else {
    echo "Error en la conexión.";
}

$camisetas = Camiseta::findAll();
echo "<pre>";
print_r($camisetas);
echo "</pre>";
?>
