<?php
require_once __DIR__ . '/../controllers/CamisetaController.php';
require_once __DIR__ . '/../controllers/ClienteController.php';
require_once __DIR__ . '/../controllers/TallaController.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Detecta automáticamente la carpeta (como /todoCamisetas-api)
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$uri = str_replace($basePath, '', $uri);


// Rutas CAMISETAS
if ($method === 'GET' && preg_match('/^\/camisetas$/', $uri)) {
    CamisetaController::index();
} elseif ($method === 'GET' && preg_match('/^\/camisetas\/(\d+)$/', $uri, $matches)) {
    CamisetaController::show($matches[1]);
} elseif ($method === 'POST' && preg_match('/^\/camisetas$/', $uri)) {
    CamisetaController::store();
} elseif ($method === 'PUT' && preg_match('/^\/camisetas\/(\d+)$/', $uri, $matches)) {
    CamisetaController::update($matches[1]);
} elseif ($method === 'DELETE' && preg_match('/^\/camisetas\/(\d+)$/', $uri, $matches)) {
    CamisetaController::destroy($matches[1]);
}
// GET /camisetas/{id}/cliente/{cliente_id}
if ($method === 'GET' && preg_match('/^\/camisetas\/(\d+)\/cliente\/(\d+)$/', $uri, $matches)) {
    CamisetaController::precioFinal($matches[1], $matches[2]);
}
// Rutas CLIENTES
if ($method === 'GET' && preg_match('/^\/clientes$/', $uri)) {
    ClienteController::index();
} elseif ($method === 'GET' && preg_match('/^\/clientes\/(\d+)$/', $uri, $matches)) {
    ClienteController::show($matches[1]);
} elseif ($method === 'POST' && preg_match('/^\/clientes$/', $uri)) {
    ClienteController::store();
} elseif ($method === 'PUT' && preg_match('/^\/clientes\/(\d+)$/', $uri, $matches)) {
    ClienteController::update($matches[1]);
} elseif ($method === 'DELETE' && preg_match('/^\/clientes\/(\d+)$/', $uri, $matches)) {
    ClienteController::destroy($matches[1]);
}
// Rutas TALLAS
if ($method === 'GET' && preg_match('/^\/tallas$/', $uri)) {
    TallaController::index();
} elseif ($method === 'POST' && preg_match('/^\/tallas$/', $uri)) {
    TallaController::store();
} elseif ($method === 'DELETE' && preg_match('/^\/tallas\/(\d+)$/', $uri, $matches)) {
    TallaController::destroy($matches[1]);
} elseif ($method === 'POST' && preg_match('/^\/tallas\/asignar$/', $uri)) {
    TallaController::asignar();
} elseif ($method === 'GET' && preg_match('/^\/tallas\/camiseta\/(\d+)$/', $uri, $matches)) {
    TallaController::verPorCamiseta($matches[1]);
}
