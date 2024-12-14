<?php
include 'conn.php';

// Get the PatientID from the URL
if (isset($_GET['item_id']) && is_numeric($_GET['item_id'])) {
    $itemID = $_GET['item_id'];

    // Query to fetch item details
    $sql = "SELECT 
                msi.*, v.VendorName 
            FROM 
                medicalsurgicalitem msi
            JOIN 
                vendor v ON msi.VendorID = v.VendorID 
            WHERE 
                msi.ItemID = $itemID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "<p>No item found with ID $itemID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid Item ID.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
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
        <h1>Item Details</h1>
        <div class="detail"><strong>Item ID:</strong> <?= htmlspecialchars($item['ItemID']) ?></div>
        <div class="detail"><strong>Item Name:</strong> <?= htmlspecialchars($item['ItemName']) ?></div>
        <div class="detail"><strong>Item Type:</strong> <?= htmlspecialchars($item['Type']) ?></div>
        <div class="detail"><strong>Vendor Name:</strong> <?= htmlspecialchars($item['VendorName']) ?></div>
        <div class="detail"><strong>Quantity:</strong> <?= htmlspecialchars($item['Quantity']) ?></div>
        <div class="detail"><strong>Cost:</strong> <?= htmlspecialchars($item['cost']) ?> PHP</div>
        <div class="back-link">
            <a href="itemList.php">Back to List</a>
        </div>
    </div>
</body>
</html>
