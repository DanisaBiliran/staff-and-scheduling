<?php
include 'sessioncheck.php';
include 'conn.php';

// Get the PatientID from the URL
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $orderID = $_GET['order_id'];

    // Query to fetch patient details
    $sql = "SELECT 
                o.*, phy.PhysicianName, pat.PatientName 
            FROM 
                medicalorder o
            JOIN 
                physician phy ON o.PhysicianID_FK = phy.PhysicianID
            JOIN 
                 patient pat ON o.PatientID_FK = pat.PatientID
            WHERE 
                o.OrderID = $orderID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "<p>No order found with ID $orderID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid Order ID.</p>";
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
        <div class="detail"><strong>Order ID:</strong> <?= htmlspecialchars($order['OrderID']) ?></div>
        <div class="detail"><strong>Order Date:</strong> <?= htmlspecialchars($order['OrderDate']) ?></div>
        <div class="detail"><strong>Order Type:</strong> <?= htmlspecialchars($order['OrderType']) ?></div>
        <div class="detail"><strong>Physician Name:</strong> <?= htmlspecialchars($order['PhysicianName']) ?></div>
        <div class="detail"><strong>Patient Name:</strong> <?= htmlspecialchars($order['PatientName']) ?></div>
        <div class="detail"><strong>Status:</strong> <?= htmlspecialchars($order['Status']) ?></div>
        <div class="back-link">
            <a href="orderList.php">Back to List</a>
        </div>
    </div>
</body>
</html>
