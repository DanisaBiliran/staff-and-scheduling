<?php
include 'sessioncheck.php';
include 'conn.php';

// Get the PatientID from the URL
if (isset($_GET['vendor_id']) && is_numeric($_GET['vendor_id'])) {
    $vendorID = $_GET['vendor_id'];

    // Query to fetch item details
    $sql = "SELECT * from vendor WHERE VendorID = $vendorID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $vendor = $result->fetch_assoc();
    } else {
        echo "<p>No vendor found with ID $vendorID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid Vendor ID.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Details</title>
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
        <h1>Vendor Details</h1>
        <div class="detail"><strong>Vendor ID:</strong> <?= htmlspecialchars($vendor['VendorID']) ?></div>
        <div class="detail"><strong>Vendor Name:</strong> <?= htmlspecialchars($vendor['VendorName']) ?></div>
        <div class="detail"><strong>Contact Info:</strong> <?= htmlspecialchars($vendor['ContactInfo']) ?></div>
        <div class="detail"><strong>Address:</strong> <?= htmlspecialchars($vendor['Address']) ?></div>
        <div class="back-link">
            <a href="vendorList.php">Back to List</a>
        </div>
    </div>
</body>
</html>
