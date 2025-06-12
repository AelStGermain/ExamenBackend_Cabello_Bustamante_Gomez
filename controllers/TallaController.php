<?php
require_once __DIR__ . '/../models/Talla.php';
require_once __DIR__ . '/../models/Camiseta.php';
require_once __DIR__ . '/../utils/response.php';

class TallaController {
    public static function index() {
        jsonResponse(Talla::all());
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['nombre'])) {
            jsonResponse(['error' => 'Nombre de talla requerido'], 400);
        }

        if (Talla::create($data['nombre'])) {
            jsonResponse(['message' => 'Talla creada'], 201);
        } else {
            jsonResponse(['error' => 'Error al crear talla'], 500);
        }
    }

    public static function destroy($id) {
        if (!Talla::find($id)) {
            jsonResponse(['error' => 'Talla no encontrada'], 404);
        }

        if (Talla::delete($id)) {
            jsonResponse(['message' => 'Talla eliminada']);
        } else {
            jsonResponse(['error' => 'Error al eliminar talla'], 500);
        }
    }

    public static function asignar() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['camiseta_id']) || empty($data['talla_id'])) {
            jsonResponse(['error' => 'camiseta_id y talla_id requeridos'], 400);
        }

        if (!Camiseta::find($data['camiseta_id'])) {
            jsonResponse(['error' => 'Camiseta no existe'], 404);
        }

        if (!Talla::find($data['talla_id'])) {
            jsonResponse(['error' => 'Talla no existe'], 404);
        }

        if (Talla::asignarATalla($data['camiseta_id'], $data['talla_id'])) {
            jsonResponse(['message' => 'Talla asignada a camiseta']);
        } else {
            jsonResponse(['error' => 'Error al asignar talla'], 500);
        }
    }

    public static function verPorCamiseta($id) {
        $tallas = Talla::obtenerTallasPorCamiseta($id);
        jsonResponse($tallas);
    }
}
