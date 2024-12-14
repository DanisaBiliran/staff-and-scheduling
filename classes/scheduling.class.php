<?php
require_once __DIR__ . "/database.class.php";

class Scheduling extends Database
{

  function fetchAll()
  {
    $query = $this->conn->prepare("SELECT schedule_id, p.patient_id, w.ward_id, p.name as patient_name, w.name as ward_name, start_date, end_date, status FROM scheduling s INNER JOIN patients p ON s.patient_id = p.patient_id INNER JOIN wards w ON s.ward_id = w.ward_id");
    $query->execute();

    return $query->fetchAll();
  }

  function fetch($data)
  {
    $query = $this->conn->prepare("SELECT * FROM scheduling WHERE schedule_id = :schedule_id LIMIT 1");
    $query->execute($data);

    echo json_encode($query->fetch());
  }


  function upsert($data)
  {
    $query = $this->conn->prepare("INSERT INTO scheduling (schedule_id, patient_id, start_date,  end_date, status, ward_id) VALUES (:schedule_id, :patient_id, :start_date, :end_date, :status, :ward_id) ON DUPLICATE KEY UPDATE patient_id = :patient_id, start_date = :start_date, end_date = :end_date, status = :status, ward_id = :ward_id");

    $query->execute([
      "schedule_id" => $data["schedule_id"],
      "patient_id" => $data["patient_id"],
      "start_date" => $data["start_date"],
      "end_date" => $data["end_date"],
      "status" => isset($data["status"]) ? $data["status"] : "Scheduled",
      "ward_id" => $data["ward_id"],
    ]);

    header("Location: ../scheduling.php");
  }

  function delete($data)
  {
    $query = $this->conn->prepare("DELETE FROM scheduling WHERE schedule_id = :schedule_id");
    $query->execute($data);
  }

}

?>