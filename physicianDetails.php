<?php
include 'sessioncheck.php';
include 'conn.php';

// Get the PatientID from the URL
if (isset($_GET['physician_id']) && is_numeric($_GET['physician_id'])) {
    $physicianID = $_GET['physician_id'];

    // Query to fetch item details
    $sql = "SELECT 
                phy.*, f.FacilityName 
            FROM 
                physician phy
            JOIN 
                facility f ON phy.FacilityID = f.FacilityID 
            WHERE 
                phy.PhysicianID = $physicianID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $physician = $result->fetch_assoc();
    } else {
        echo "<p>No physicians found with ID $physicianID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid Physician ID.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physician Details</title>
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
        <h1>Physician Details</h1>
        <div class="detail"><strong>Physician ID:</strong> <?= htmlspecialchars($physician['PhysicianID']) ?></div>
        <div class="detail"><strong>Physician Name:</strong> <?= htmlspecialchars($physician['PhysicianName']) ?></div>
        <div class="detail"><strong>Specialty:</strong> <?= htmlspecialchars($physician['Specialty']) ?></div>
        <div class="detail"><strong>Facility Assigned:</strong> <?= htmlspecialchars($physician['FacilityName']) ?></div>
        <div class="back-link">
            <a href="physicianList.php">Back to List</a>
        </div>
    </div>
</body>
</html>
