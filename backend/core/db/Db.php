<?php

namespace core\db;

use PDO;
use PDOException;


class Db
{
    private static $connectDB = null;

    public static function connectDB()
    {
        if (self::$connectDB !== null) {
            return self::$connectDB;
        }

        try {
            ///connect to the database
            $conn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', DB_HOST, DB_NAME);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

            return self::$connectDB = new PDO($conn, DB_USER, DB_PASS, $option);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
