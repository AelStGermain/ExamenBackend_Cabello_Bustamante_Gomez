<?php
// models/Talla.php

require_once 'DB.php';

class Talla {

    // Listar todas las tallas
    public static function findAll() {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM tallas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una talla por ID
    public static function findById($id) {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM tallas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva talla
    public static function create($data) {
        $db = DB::getConnection();
        $stmt = $db->prepare("INSERT INTO tallas (nombre) VALUES (?)");
        $result = $stmt->execute([
            $data['nombre']
        ]);
        return $result ? $db->lastInsertId() : false;
    }

    // Actualizar una talla existente
    public static function update($id, $data) {
        $db = DB::getConnection();
        $stmt = $db->prepare("UPDATE tallas SET nombre = ? WHERE id = ?");
        return $stmt->execute([
            $data['nombre'],
            $id
        ]);
    }

    // Eliminar una talla
    public static function destroy($id) {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM tallas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
