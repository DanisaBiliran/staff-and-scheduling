<?php
require_once __DIR__ . "/../classes/wards.class.php";

$wards = new Wards();

switch ($_SERVER["REQUEST_METHOD"]) {
  case "POST":
    $wards->upsert($_POST);
    break;
  case "DELETE":
    $wards->delete($_GET);
    break;
  default:
    $wards->fetch($_GET);
    break;
}


?>