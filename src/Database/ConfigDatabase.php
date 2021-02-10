<?php 

namespace App\Database;

use \PDO;

class ConfigDatabase
{

  private $host = 'localhost';
  private $dbname = 'portfolio';
  private $username = 'root';
  private $password = '';

  public function getConnexion(){
    $connection = new PDO('mysql:host='. $this->host .';dbname='. $this->dbname .';charset=utf8', $this->username, $this->password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;
  }
}
