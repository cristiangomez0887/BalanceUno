<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $conn = null;

    public static function getConnection()
    {
        if (self::$conn == null) {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $db_name = $_ENV['DB_NAME'] ?? 'balanceuno';
            $username = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASS'] ?? '';

            try {
                self::$conn = new PDO(
                    "mysql:host={$host};dbname={$db_name}",
                    $username,
                    $password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
