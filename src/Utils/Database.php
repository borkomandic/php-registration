<?php

namespace App\Utils;

use mysqli;

class Database
{
    protected static $instance = null;

    public static function getInstance(): mysqli
    {
        if (self::$instance === null) {
            self::$instance = new mysqli("db", "my_user", "my_password", "my_db");
            if (self::$instance->connect_error) {
                die("Connection failed: " . self::$instance->connect_error);
            }
        }

        return self::$instance;
    }
}
