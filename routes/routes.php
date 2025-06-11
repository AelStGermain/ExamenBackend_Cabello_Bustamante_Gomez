<?php
// routes/routes.php

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Se remueve la query string
$requestUri = parse_url($requestUri, PHP_URL_PATH);

// Si el proyecto está en un subdirectorio, defínelo aquí (por ejemplo, '/eva3_xyz_php')
$basePath = '/eva3_xyz_php';
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// Definición de rutas (se usan expresiones regulares para identificar el endpoint y extraer parámetros)
$routes = [
    // Rutas para camisetas
    ['method' => 'GET', 'pattern' => '#^/camisetas/?$#', 'controller' => 'CamisetasController', 'action' => 'index'],
    ['method' => 'GET', 'pattern' => '#^/camisetas/(\d+)/?$#', 'controller' => 'CamisetasController', 'action' => 'show'],
    ['method' => 'POST', 'pattern' => '#^/camisetas/?$#', 'controller' => 'CamisetasController', 'action' => 'store'],
    ['method' => 'PUT', 'pattern' => '#^/camisetas/(\d+)/?$#', 'controller' => 'CamisetasController', 'action' => 'update'],
    ['method' => 'DELETE', 'pattern' => '#^/camisetas/(\d+)/?$#', 'controller' => 'CamisetasController', 'action' => 'destroy'],
    // Endpoint para obtener precio final según cliente (ejemplo: /camisetas/123/price?cliente_id=1)
    ['method' => 'GET', 'pattern' => '#^/camisetas/(\d+)/price/?$#', 'controller' => 'CamisetasController', 'action' => 'precioFinal'],

    // Rutas para clientes
    ['method' => 'GET', 'pattern' => '#^/clientes/?$#', 'controller' => 'ClientesController', 'action' => 'index'],
    ['method' => 'GET', 'pattern' => '#^/clientes/(\d+)/?$#', 'controller' => 'ClientesController', 'action' => 'show'],
    ['method' => 'POST', 'pattern' => '#^/clientes/?$#', 'controller' => 'ClientesController', 'action' => 'store'],
    ['method' => 'PUT', 'pattern' => '#^/clientes/(\d+)/?$#', 'controller' => 'ClientesController', 'action' => 'update'],
    ['method' => 'DELETE', 'pattern' => '#^/clientes/(\d+)/?$#', 'controller' => 'ClientesController', 'action' => 'destroy'],

    // Rutas para tallas
    ['method' => 'GET', 'pattern' => '#^/tallas/?$#', 'controller' => 'TallasController', 'action' => 'index'],
    ['method' => 'GET', 'pattern' => '#^/tallas/(\d+)/?$#', 'controller' => 'TallasController', 'action' => 'show'],
    ['method' => 'POST', 'pattern' => '#^/tallas/?$#', 'controller' => 'TallasController', 'action' => 'store'],
    ['method' => 'PUT', 'pattern' => '#^/tallas/(\d+)/?$#', 'controller' => 'TallasController', 'action' => 'update'],
    ['method' => 'DELETE', 'pattern' => '#^/tallas/(\d+)/?$#', 'controller' => 'TallasController', 'action' => 'destroy']
];

$handled = false;
foreach ($routes as $route) {
    if ($route['method'] == $requestMethod && preg_match($route['pattern'], $requestUri, $matches)) {
        // Cargar el controlador (se asume que los archivos de controladores están en ../controllers/)
        require_once 'controllers/' . $route['controller'] . '.php';
        $controller = new $route['controller']();
        // Se eliminan el primer elemento del array de matches (la coincidencia completa)
        array_shift($matches);
        // Ejecutar la acción correspondiente y pasar los parámetros extraídos
        call_user_func_array([$controller, $route['action']], $matches);
        $handled = true;
        break;
    }
}

if (!$handled) {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
?>
