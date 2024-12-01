<?php

namespace Ivy;

use Delight\Db\PdoDatabase;
use PDO;
use PDOException;

class DB
{

    public static PdoDatabase $connection;

    public function __construct()
    {

        if (isset(self::$connection)) {
            return;
        }

        try {
            $pdo = new PDO("mysql:host=" . $_ENV['DB_SERVER'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'] . ";charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        } catch (PDOException) {
            die("ERROR: Could not connect");
        }

        self::$connection = PdoDatabase::fromPdo($pdo);
    }

}