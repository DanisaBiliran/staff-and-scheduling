<?php
require_once __DIR__ . "/../classes/patients.class.php";

$patients = new Patients();

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    $patients->upsert($_POST);
    break;
  case "DELETE":
    $patients->delete($_GET);
    break;
  default:
    $patients->fetch($_GET);
    break;
}


?>