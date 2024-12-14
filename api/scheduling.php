<?php
require_once __DIR__ . "/../classes/scheduling.class.php";

$scheduling = new Scheduling();

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    var_dump($_POST);
    $scheduling->upsert($_POST);
    break;
  case "DELETE":
    $scheduling->delete($_GET);
    break;
  default:
    $scheduling->fetch($_GET);
    break;
}


?>