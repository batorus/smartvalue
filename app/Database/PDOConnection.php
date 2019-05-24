<?php 
namespace Smartvalue\Database;
use \PDO;

class PDOConnection implements IConnection{

  // DB Params
  private $host = 'localhost';
  private $db_name = 'smartvalue';
  private $username = 'root';
  private $password = '';
  private $conn;

  public function __construct(){

    try { 

      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    } catch(PDOException $e) {

      echo 'Connection Error: ' . $e->getMessage();

    }

  }

  public function getConnection():object{
      return $this->conn;
  }


}