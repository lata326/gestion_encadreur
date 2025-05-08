<?php
// C:\xampp\htdocs\gestion_encadreur\config\Database.php

class Database {
    private static $host     = 'localhost';
    private static $db_name  = 'gestion_encadreurs';  // <-- doit matcher ta BDD
    private static $username = 'root';
    private static $password = '';
    private static $conn     = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=utf8mb4',
                    self::$host,
                    self::$db_name
                );
                self::$conn = new PDO($dsn, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
