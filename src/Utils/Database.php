<?php

namespace App\Utils;

use mysqli;

class Database
{
    protected static $instance = null;

    public static function getInstance(): mysqli
    {
        if (self::$instance === null) {
            self::$instance = new mysqli($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);
            if (self::$instance->connect_error) {
                die("Connection failed: " . self::$instance->connect_error);
            }
        }

        return self::$instance;
    }
}
