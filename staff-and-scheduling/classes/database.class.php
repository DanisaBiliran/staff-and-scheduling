<?php

class Database
{
  protected $conn;

  function __construct()
  {
    $this->conn = new PDO("mysql: host=localhost;dbname=mvch", "root", "");
  }
}


?>