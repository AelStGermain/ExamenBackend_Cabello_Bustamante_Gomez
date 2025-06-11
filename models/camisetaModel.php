<?php
// models/Camiseta.php
require_once 'DB.php';
require_once 'Cliente.php';

class Camiseta {
    public static function findAll() {
        $db = DB::getConnection();
        $stmt = $db->prepare('SELECT * FROM camisetas');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = DB::getConnection();
        $stmt = $db->prepare('SELECT * FROM camisetas WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = DB::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO camisetas 
            (titulo, club, pais, tipo, color, precio, tallas_disponibles, detalles, codigo_producto, precio_oferta) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $result = $stmt->execute([
            $data['titulo'],
            $data['club'],
            $data['pais'],
            $data['tipo'],
            $data['color'],
            $data['precio'],
            isset($data['tallas_disponibles']) ? json_encode($data['tallas_disponibles']) : null,
            isset($data['detalles']) ? $data['detalles'] : null,
            $data['codigo_producto'],
            isset($data['precio_oferta']) ? $data['precio_oferta'] : null,
        ]);
        return $result ? $db->lastInsertId() : false;
    }

    public static function update($id, $data) {
        $db = DB::getConnection();
        $stmt = $db->prepare(
            "UPDATE camisetas SET 
                titulo = ?, club = ?, pais = ?, tipo = ?, color = ?, precio = ?, 
                tallas_disponibles = ?, detalles = ?, codigo_producto = ?, precio_oferta = ?
             WHERE id = ?"
        );
        return $stmt->execute([
            $data['titulo'],
            $data['club'],
            $data['pais'],
            $data['tipo'],
            $data['color'],
            $data['precio'],
            isset($data['tallas_disponibles']) ? json_encode($data['tallas_disponibles']) : null,
            isset($data['detalles']) ? $data['detalles'] : null,
            $data['codigo_producto'],
            isset($data['precio_oferta']) ? $data['precio_oferta'] : null,
            $id
        ]);
    }

    public static function destroy($id) {
        $db = DB::getConnection();
        $stmt = $db->prepare("DELETE FROM camisetas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getPrecioFinal($id, $cliente_id) {
        $camiseta = self::findById($id);
        if (!$camiseta) return null;
        $cliente = Cliente::findById($cliente_id);
        $precioFinal = $camiseta['precio'];
        // Si el cliente es preferencial y existe precio_oferta, se aplica la oferta
        if ($cliente && strtolower($cliente['categoria']) === 'preferencial' && !empty($camiseta['precio_oferta'])) {
            $precioFinal = $camiseta['precio_oferta'];
        }
        $camiseta['precio_final'] = $precioFinal;
        return $camiseta;
    }
}
?>
