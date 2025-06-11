<?php
// index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Llamada al archivo de rutas para despachar la petición
require_once 'routes/routes.php';
?>
