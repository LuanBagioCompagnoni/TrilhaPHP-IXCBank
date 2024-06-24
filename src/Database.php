<?php
class Database {
    private static $instance = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new PDO('sqlite:' . __DIR__ . '/../database.db');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
?>
