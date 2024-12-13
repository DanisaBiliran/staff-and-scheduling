<?php
require_once __DIR__ . "/database.class.php";

class Patients extends Database
{

  function fetchAll()
  {
    $query = $this->conn->prepare("SELECT * FROM patients");
    $query->execute();

    return $query->fetchAll();
  }

  function fetch($data)
  {
    $query = $this->conn->prepare("SELECT * FROM patients WHERE patient_id = :patient_id LIMIT 1");
    $query->execute($data);

    echo json_encode($query->fetch());
  }


  function upsert($data)
  {
    $query = $this->conn->prepare("INSERT INTO patients (patient_id, name, birthdate, sex, contact) VALUES (:patient_id, :name, :birthdate, :sex, :contact) ON DUPLICATE KEY UPDATE name = :name, birthdate = :birthdate, sex = :sex, contact = :contact");

    $query->execute([
      "patient_id" => $data["patient_id"],
      "name" => $data["name"],
      "birthdate" => $data["birthdate"],
      "sex" => $data["sex"],
      "contact" => $data["contact"],
    ]);

    header("Location: ../patients.php");
  }

  function delete($data)
  {
    $query = $this->conn->prepare("DELETE FROM patients WHERE patient_id = :patient_id");
    $query->execute($data);
  }

}

?>