<?php
require_once __DIR__ . '/../config/database.php';

class Talla {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM tallas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM tallas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($nombre) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO tallas (nombre) VALUES (:nombre)");
        return $stmt->execute([':nombre' => $nombre]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM tallas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function asignarATalla($camisetaId, $tallaId) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO camiseta_tallas (camiseta_id, talla_id) VALUES (:camiseta_id, :talla_id)");
        return $stmt->execute([
            ':camiseta_id' => $camisetaId,
            ':talla_id' => $tallaId
        ]);
    }

    public static function obtenerTallasPorCamiseta($camisetaId) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT t.nombre FROM camiseta_tallas ct 
                              JOIN tallas t ON ct.talla_id = t.id
                              WHERE ct.camiseta_id = :camiseta_id");
        $stmt->bindParam(':camiseta_id', $camisetaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
