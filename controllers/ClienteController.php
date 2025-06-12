<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../utils/response.php';

class ClienteController {
    public static function index() {
        jsonResponse(Cliente::all());
    }

    public static function show($id) {
        $cliente = Cliente::find($id);
        if ($cliente) {
            jsonResponse($cliente);
        } else {
            jsonResponse(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $required = ['nombre_comercial', 'rut', 'direccion', 'categoria', 'contacto_nombre', 'contacto_correo', 'porcentaje_descuento'];

        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                jsonResponse(['error' => "Campo requerido: $field"], 400);
            }
        }

        if (!in_array($data['categoria'], ['Regular', 'Preferencial'])) {
            jsonResponse(['error' => 'Categoría inválida. Solo se permite Regular o Preferencial.'], 400);
        }

        if (Cliente::create($data)) {
            jsonResponse(['message' => 'Cliente creado correctamente'], 201);
        } else {
            jsonResponse(['error' => 'Error al crear cliente'], 500);
        }
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!Cliente::find($id)) {
            jsonResponse(['error' => 'Cliente no encontrado'], 404);
        }

        if (Cliente::update($id, $data)) {
            jsonResponse(['message' => 'Cliente actualizado correctamente']);
        } else {
            jsonResponse(['error' => 'Error al actualizar cliente'], 500);
        }
    }

    public static function destroy($id) {
        if (!Cliente::find($id)) {
            jsonResponse(['error' => 'Cliente no encontrado'], 404);
        }

        if (Cliente::delete($id)) {
            jsonResponse(['message' => 'Cliente eliminado con éxito']);
        } else {
            jsonResponse(['error' => 'Error al eliminar cliente'], 500);
        }
    }
}
