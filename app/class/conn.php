<?php
class Conn{	
    protected static $db;

    private function __construct() {
        try {
            self::$db = new PDO(
                    'mysql:host=localhost;dbname=bobbarp', 
                    'root', 
                    '', 
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
               );

            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch (PDOException $e) {
            die("Nous revenons.");
        }
    }

    public static function getConnection() {
        if (!self::$db) {
            new Conn();
        }
        return self::$db;
    }

    public static function closeConnection() {
        $db=null;
    }
}