<?php

namespace App\Database;

use \PDO;

/**
 * initialize the database
 */
class ConfigDatabase
{

  /**
   * connect the database with information of config file
   */
    public function getConnexion()
    {
        $data = require __DIR__ . './../Config/config.php';
        $connection = new PDO(
            'mysql:host=' . $data['db_host'] . ';dbname=' . $data['db_name'] . ';charset=utf8',
            $data['db_user'],
            $data['db_password'],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
        return $connection;
    }
}
