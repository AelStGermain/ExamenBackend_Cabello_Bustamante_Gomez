<?php
// models/DB.php

class DB {
    private static $connection = null;
    
    public static function getConnection() {
        if (!self::$connection) {
            $host = 'localhost';
            $dbname = 'todo_camisetas';  // Nombre de la base de datos
            $username = 'root';
            $password = '';              // Ajustar según la configuración local
            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>
