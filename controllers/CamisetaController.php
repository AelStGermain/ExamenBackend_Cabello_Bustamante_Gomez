<?php
require_once __DIR__ . '/../models/Camiseta.php';
require_once __DIR__ . '/../utils/response.php';

class CamisetaController {
    public static function index() {
        jsonResponse(Camiseta::all());
    }

    public static function show($id) {
        $camiseta = Camiseta::find($id);
        if ($camiseta) {
            jsonResponse($camiseta);
        } else {
            jsonResponse(['error' => 'Camiseta no encontrada'], 404);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $required = ['titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'detalles', 'codigo_producto'];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                jsonResponse(['error' => "Campo requerido: $field"], 400);
            }
        }

        if (Camiseta::create($data)) {
            jsonResponse(['message' => 'Camiseta creada con éxito'], 201);
        } else {
            jsonResponse(['error' => 'Error al crear camiseta'], 500);
        }
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!Camiseta::find($id)) {
            jsonResponse(['error' => 'Camiseta no encontrada'], 404);
        }

        if (Camiseta::update($id, $data)) {
            jsonResponse(['message' => 'Camiseta actualizada con éxito']);
        } else {
            jsonResponse(['error' => 'Error al actualizar camiseta'], 500);
        }
    }

    public static function destroy($id) {
        if (!Camiseta::find($id)) {
            jsonResponse(['error' => 'Camiseta no encontrada'], 404);
        }

        if (Camiseta::delete($id)) {
            jsonResponse(['message' => 'Camiseta eliminada con éxito']);
        } else {
            jsonResponse(['error' => 'Error al eliminar camiseta'], 500);
        }
    }

    public static function precioFinal($camisetaId, $clienteId) {
        $camiseta = Camiseta::obtenerConPrecioFinal($camisetaId, $clienteId);
        if ($camiseta) {
            jsonResponse([
                'titulo' => $camiseta['titulo'],
                'cliente_categoria' => $camiseta['categoria'],
                'precio_base' => (float)$camiseta['precio_base'],
                'precio_final' => (float)$camiseta['precio_final']
            ]);
        } else {
            jsonResponse(['error' => 'Camiseta o cliente no encontrados'], 404);
        }
    }
}
