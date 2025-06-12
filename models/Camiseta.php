<?php
require_once __DIR__ . '/../config/database.php';

class Camiseta {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM camisetas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM camisetas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO camisetas (titulo, club, pais, tipo, color, precio, precio_oferta, detalles, codigo_producto)
                              VALUES (:titulo, :club, :pais, :tipo, :color, :precio, :precio_oferta, :detalles, :codigo_producto)");

        return $stmt->execute([
            ':titulo' => $data['titulo'],
            ':club' => $data['club'],
            ':pais' => $data['pais'],
            ':tipo' => $data['tipo'],
            ':color' => $data['color'],
            ':precio' => $data['precio'],
            ':precio_oferta' => $data['precio_oferta'] ?? null,
            ':detalles' => $data['detalles'],
            ':codigo_producto' => $data['codigo_producto']
        ]);
    }

    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE camisetas SET
            titulo = :titulo,
            club = :club,
            pais = :pais,
            tipo = :tipo,
            color = :color,
            precio = :precio,
            precio_oferta = :precio_oferta,
            detalles = :detalles,
            codigo_producto = :codigo_producto
            WHERE id = :id");

        $data['id'] = $id;
        return $stmt->execute([
            ':titulo' => $data['titulo'],
            ':club' => $data['club'],
            ':pais' => $data['pais'],
            ':tipo' => $data['tipo'],
            ':color' => $data['color'],
            ':precio' => $data['precio'],
            ':precio_oferta' => $data['precio_oferta'] ?? null,
            ':detalles' => $data['detalles'],
            ':codigo_producto' => $data['codigo_producto'],
            ':id' => $id
        ]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM camisetas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function obtenerConPrecioFinal($camisetaId, $clienteId) {
        $db = Database::connect();

        $sql = "SELECT 
                    c.*, 
                    cli.categoria,
                    cli.porcentaje_descuento,
                    CASE 
                        WHEN cli.categoria = 'Preferencial' AND c.precio_oferta IS NOT NULL THEN c.precio_oferta
                        ELSE c.precio
                    END AS precio_base,
                    ROUND(
                        CASE 
                            WHEN cli.categoria = 'Preferencial' AND c.precio_oferta IS NOT NULL THEN 
                                c.precio_oferta * (1 - cli.porcentaje_descuento / 100)
                            ELSE 
                                c.precio * (1 - cli.porcentaje_descuento / 100)
                        END, 2
                    ) AS precio_final
                FROM camisetas c
                JOIN clientes cli ON cli.id = :cliente_id
                WHERE c.id = :camiseta_id";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':cliente_id' => $clienteId,
            ':camiseta_id' => $camisetaId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
