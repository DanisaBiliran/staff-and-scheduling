<?php
include 'sessioncheck.php';
include 'conn.php';

// Get the PatientID from the URL
if (isset($_GET['staff_id']) && is_numeric($_GET['staff_id'])) {
    $staffID = $_GET['staff_id'];

    // Query to fetch item details
    $sql = "SELECT * from staff WHERE StaffID = $staffID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
    } else {
        echo "<p>No staff found with ID $staffID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid Staff ID.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details</title>
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
        <h1>Staff Details</h1>
        <div class="detail"><strong>Staff ID:</strong> <?= htmlspecialchars($staff['StaffID']) ?></div>
        <div class="detail"><strong>Staff Name:</strong> <?= htmlspecialchars($staff['StaffName']) ?></div>
        <div class="detail"><strong>Role:</strong> <?= htmlspecialchars($staff['Role']) ?></div>
        <div class="back-link">
            <a href="staffList.php">Back to List</a>
        </div>
    </div>
</body>
</html>
