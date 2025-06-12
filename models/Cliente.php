<?php
require_once __DIR__ . '/../config/database.php';

class Cliente {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO clientes (nombre_comercial, rut, direccion, categoria, contacto_nombre, contacto_correo, porcentaje_descuento)
                              VALUES (:nombre_comercial, :rut, :direccion, :categoria, :contacto_nombre, :contacto_correo, :porcentaje_descuento)");
        return $stmt->execute([
            ':nombre_comercial' => $data['nombre_comercial'],
            ':rut' => $data['rut'],
            ':direccion' => $data['direccion'],
            ':categoria' => $data['categoria'],
            ':contacto_nombre' => $data['contacto_nombre'],
            ':contacto_correo' => $data['contacto_correo'],
            ':porcentaje_descuento' => $data['porcentaje_descuento']
        ]);
    }

    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE clientes SET
            nombre_comercial = :nombre_comercial,
            rut = :rut,
            direccion = :direccion,
            categoria = :categoria,
            contacto_nombre = :contacto_nombre,
            contacto_correo = :contacto_correo,
            porcentaje_descuento = :porcentaje_descuento
            WHERE id = :id");

        $data['id'] = $id;
        return $stmt->execute([
            ':nombre_comercial' => $data['nombre_comercial'],
            ':rut' => $data['rut'],
            ':direccion' => $data['direccion'],
            ':categoria' => $data['categoria'],
            ':contacto_nombre' => $data['contacto_nombre'],
            ':contacto_correo' => $data['contacto_correo'],
            ':porcentaje_descuento' => $data['porcentaje_descuento'],
            ':id' => $id
        ]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
