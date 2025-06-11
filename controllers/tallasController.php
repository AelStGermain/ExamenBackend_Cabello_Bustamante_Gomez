<?php
// controllers/TallasController.php

require_once 'models/Talla.php';

class TallasController {

    // Listar todas las tallas disponibles
    public function index() {
        $tallas = Talla::findAll();
        echo json_encode($tallas);
    }

    // Obtener información de una talla por ID
    public function show($id) {
        $talla = Talla::findById($id);
        if ($talla) {
            echo json_encode($talla);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Talla no encontrada']);
        }
    }

    // Crear una nueva talla
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validación básica: verificar que exista al menos el nombre de la talla
        if (!isset($data['nombre'])) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre de la talla es obligatorio']);
            return;
        }
        
        $id = Talla::create($data);
        if ($id) {
            http_response_code(201);
            echo json_encode(['id' => $id, 'message' => 'Talla creada correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear la talla']);
        }
    }

    // Actualizar una talla existente
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $success = Talla::update($id, $data);
        if ($success) {
            echo json_encode(['message' => 'Talla actualizada correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Talla no encontrada o no se pudo actualizar']);
        }
    }

    // Eliminar una talla  
    // Considera que si existen relaciones con camisetas, puede que se deba solicitar una eliminación en cascada o impedir la eliminación.
    public function destroy($id) {
        $success = Talla::destroy($id);
        if ($success) {
            echo json_encode(['message' => 'Talla eliminada correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Talla no encontrada o no se pudo eliminar']);
        }
    }
}
?>
