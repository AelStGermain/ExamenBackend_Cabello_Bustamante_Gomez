<?php
// controllers/CamisetasController.php
require_once 'models/Camiseta.php';
require_once 'models/Cliente.php';

class CamisetasController {
    public function index() {
        $camisetas = Camiseta::findAll();
        echo json_encode($camisetas);
    }

    public function show($id) {
        $camiseta = Camiseta::findById($id);
        if ($camiseta) {
            echo json_encode($camiseta);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Camiseta no encontrada']);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        // Aquí se pueden agregar validaciones de datos
        $id = Camiseta::create($data);
        if ($id) {
            http_response_code(201);
            echo json_encode(['id' => $id, 'message' => 'Camiseta creada correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear la camiseta']);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $success = Camiseta::update($id, $data);
        if ($success) {
            echo json_encode(['message' => 'Camiseta actualizada correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Camiseta no encontrada']);
        }
    }

    public function destroy($id) {
        $success = Camiseta::destroy($id);
        if ($success) {
            echo json_encode(['message' => 'Camiseta eliminada correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Camiseta no encontrada o no se pudo eliminar']);
        }
    }

    public function precioFinal($id) {
        // Se espera recibir por query string el parámetro ?cliente_id=XXX
        if (!isset($_GET['cliente_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Parámetro cliente_id es requerido']);
            return;
        }
        $cliente_id = $_GET['cliente_id'];
        $result = Camiseta::getPrecioFinal($id, $cliente_id);
        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Camiseta no encontrada']);
        }
    }
}
?>
