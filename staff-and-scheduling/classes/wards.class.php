<?php
require_once __DIR__ . "/database.class.php";

class Wards extends Database
{

  function fetchAll()
  {
    $query = $this->conn->prepare(query:
      "SELECT 
        w.*, 
        w.capacity - (
            SELECT COUNT(*) 
            FROM scheduling s 
            WHERE s.ward_id = w.ward_id AND s.status = 'Scheduled'
        ) AS available_capacity
      FROM 
          wards w;");
    $query->execute();

    return $query->fetchAll();
  }

  function fetch($data)
  {
    $query = $this->conn->prepare("SELECT * FROM wards WHERE ward_id = :ward_id LIMIT 1");
    $query->execute($data);

    echo json_encode($query->fetch());
  }


  function upsert($data)
  {
    $query = $this->conn->prepare("INSERT INTO wards (ward_id, name, type, capacity) VALUES (:ward_id, :name, :type, :capacity) ON DUPLICATE KEY UPDATE name = :name, type = :type, capacity = :capacity");

    $query->execute([
      "ward_id" => $data["ward_id"],
      "name" => $data["name"],
      "type" => $data["type"],
      "capacity" => $data["capacity"],
    ]);

    header("Location: ../wards.php");
  }

  function delete($data)
  {
    $query = $this->conn->prepare("DELETE FROM wards WHERE ward_id = :ward_id");
    $query->execute($data);
  }

}

?>