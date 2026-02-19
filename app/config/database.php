<?php
class Database
{
    private static $host = "sql311.infinityfree.com";
    private static $db_name = "if0_41136129_balance_uno";
    private static $username = "if0_41136129";
    private static $password = "Cristian0887";
    private static $conn;

    public static function getConnection()
    {
        if (self::$conn == null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                    self::$username,
                    self::$password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
