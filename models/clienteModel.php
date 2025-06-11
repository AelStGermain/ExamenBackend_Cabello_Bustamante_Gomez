<?php
// models/Cliente.php

require_once 'DB.php';

class Cliente {

    // Listar todos los clientes
    public static function findAll() {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM clientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un cliente por ID
    public static function findById($id) {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo cliente
    public static function create($data) {
        $db = DB::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO clientes (nombre_comercial, rut_id, direccion, categoria, contacto, porcentaje_oferta) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $result = $stmt->execute([
            $data['nombre_comercial'],
            $data['rut_id'],
            $data['direccion'],
            $data['categoria'],
            $data['contacto'],
            $data['porcentaje_oferta']
        ]);
        return $result ? $db->lastInsertId() : false;
    }

    // Actualizar un cliente existente
    public static function update($id, $data) {
        $db = DB::getConnection();
        $stmt = $db->prepare(
            "UPDATE clientes SET 
                nombre_comercial = ?, 
                rut_id = ?, 
                direccion = ?, 
                categoria = ?, 
                contacto = ?, 
                porcentaje_oferta = ? 
             WHERE id = ?"
        );
        return $stmt->execute([
            $data['nombre_comercial'],
            $data['rut_id'],
            $data['direccion'],
            $data['categoria'],
            $data['contacto'],
            $data['porcentaje_oferta'],
            $id
        ]);
    }

    // Eliminar un cliente
    public static function destroy($id) {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
