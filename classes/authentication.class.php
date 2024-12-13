<?php
require_once __DIR__ . "/database.class.php";
class Authentication extends Database
{
  function signIn($data)
  {

    $query = $this->conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $query->execute(["username" => $data["username"]]);
    $result = $query->fetch();

    if (password_verify($data["password"], $result["password_hash"])) {
      session_start();
      $_SESSION = array(
        "user_id" => $result["user_id"],
        "username" => $result["username"],
      );
      header("Location: ./index.php");
    }

  }
  function signOut()
  {
    session_destroy();
  }
}

?>