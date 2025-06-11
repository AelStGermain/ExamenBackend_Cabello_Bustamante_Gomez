<?php
// controllers/ClientesController.php

require_once 'models/Cliente.php';
require_once 'models/Camiseta.php'; // Se usa para validar que no existan camisetas asociadas antes de eliminar

class ClientesController {

    // Listar todos los clientes
    public function index() {
        $clientes = Cliente::findAll();
        echo json_encode($clientes);
    }

    // Obtener un cliente por ID
    public function show($id) {
        $cliente = Cliente::findById($id);
        if ($cliente) {
            echo json_encode($cliente);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado']);
        }
    }

    // Crear un nuevo cliente
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validación básica: verificar datos obligatorios
        if (!isset($data['nombre_comercial']) || !isset($data['rut_id']) ||
            !isset($data['direccion']) || !isset($data['categoria']) || !isset($data['contacto']) ||
            !isset($data['porcentaje_oferta'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos obligatorios']);
            return;
        }
        
        $id = Cliente::create($data);
        if ($id) {
            http_response_code(201);
            echo json_encode(['id' => $id, 'message' => 'Cliente creado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el cliente']);
        }
    }

    // Actualizar un cliente existente
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $success = Cliente::update($id, $data);
        if ($success) {
            echo json_encode(['message' => 'Cliente actualizado correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado o no se pudo actualizar']);
        }
    }

    // Eliminar un cliente, con validación de existencia de camisetas asociadas
    public function destroy($id) {
        // Se consulta si existen camisetas asociadas a este cliente
        $camisetas = Camiseta::findByClienteId($id);
        if (!empty($camisetas)) {
            http_response_code(400);
            echo json_encode(['error' => 'No se puede eliminar cliente con camisetas asociadas']);
            return;
        }
        
        $success = Cliente::destroy($id);
        if ($success) {
            echo json_encode(['message' => 'Cliente eliminado correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado o no se pudo eliminar']);
        }
    }
}
?>
