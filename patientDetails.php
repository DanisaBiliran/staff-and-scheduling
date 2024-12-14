<?php
include 'conn.php';

// Get the PatientID from the URL
if (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
    $patientID = $_GET['patient_id'];

    // Query to fetch patient details
    $sql = "SELECT 
                p.*, w.WardName
            FROM 
                patient p
            JOIN 
                ward w 
            ON 
                p.WardID = w.WardID
            WHERE 
                p.PatientID = $patientID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "<p>No patient found with ID $patientID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid Patient ID.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .details-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
           
        }
        h1 {
            text-align: center;
            color: #752BDF;
            margin-bottom: 20px;
        }
        .detail {
            margin-bottom: 10px;

        }
        .detail strong {
            display: inline-block;
            width: 150px;
            color: #333;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #752BDF;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="details-container">
        <h1>Patient Details</h1>
        <div class="detail"><strong>Patient ID:</strong> <?= htmlspecialchars($patient['PatientID']) ?></div>
        <div class="detail"><strong>Name:</strong> <?= htmlspecialchars($patient['PatientName']) ?></div>
        <div class="detail"><strong>Date of Birth:</strong> <?= htmlspecialchars($patient['DateOfBirth']) ?></div>
        <div class="detail"><strong>Gender:</strong> <?= htmlspecialchars($patient['Gender']) ?></div>
        <div class="detail"><strong>Ward:</strong> <?= htmlspecialchars($patient['WardName']) ?></div>
        <div class="detail"><strong>Status:</strong> <?= htmlspecialchars($patient['Status']) ?></div>
        <div class="detail"><strong>Symptoms:</strong> <?= htmlspecialchars($patient['Symptoms']) ?></div>
        <div class="detail"><strong>Allergies:</strong> <?= htmlspecialchars($patient['Allergies']) ?></div>
        <div class="detail"><strong>Medication:</strong> <?= htmlspecialchars($patient['Medication']) ?></div>
        <div class="detail"><strong>Medical History:</strong> <?= htmlspecialchars($patient['MedicalHistory']) ?></div>
        <div class="detail"><strong>Events:</strong> <?= htmlspecialchars($patient['Events']) ?></div>
        <div class="detail"><strong>Discharge Details:</strong> <?= htmlspecialchars($patient['DischargeDetails']) ?></div>
        <div class="back-link">
            <a href="patientList.php">Back to List</a>
        </div>
    </div>
</body>
</html>
