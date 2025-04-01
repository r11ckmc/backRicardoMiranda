<?php
class conexion {
    private static $pdo = null;

    // Configuración de la base de datos
    private static $db_host = 'localhost';
    private static $db_name = 'cervezas_db';
    private static $db_user = 'root';
    private static $db_pass = '';

    // Constructor privado para evitar instancias
    private function __construct() {}

    // Método estático para conectar a la BD
    public static function connect() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    "mysql:host=" . self::$db_host . ";dbname=" . self::$db_name . ";charset=utf8mb4",
                    self::$db_user,
                    self::$db_pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorno en array asociativo
                        PDO::ATTR_EMULATE_PREPARES => false // Seguridad contra SQL Injection
                    ]
                );
            } catch (PDOException $e) {
                die(json_encode([
                    'result' => [
                        'codigo' => 500,
                        'mensaje' => 'Error de conexión: ' . $e->getMessage(),
                        'object' => []
                    ]
                ]));
            }
        }
        return self::$pdo;
    }
}
