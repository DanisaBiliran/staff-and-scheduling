<?php
include 'sessioncheck.php';
include 'conn.php';

// Check if VendorID is provided in the URL
if (!isset($_GET['vendor_id'])) {
    echo "<div class='alert error'>No Vendor ID provided!</div>";
    exit;
}

$vendorID = $_GET['vendor_id'];

// Fetch existing vendor data
$vendorQuery = "SELECT * FROM vendor WHERE VendorID = '$vendorID'";
$vendorResult = $conn->query($vendorQuery);

if ($vendorResult->num_rows == 0) {
    echo "<div class='alert error'>Vendor not found!</div>";
    exit;
}

$vendor = $vendorResult->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendorName = $_POST['vendorName'];
    $contactInfo = $_POST['contactInfo'];
    $address = $_POST['address'];

    $updateQuery = "UPDATE vendor 
                    SET VendorName = '$vendorName', ContactInfo = '$contactInfo', Address = '$address' 
                    WHERE VendorID = '$vendorID'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<div class='alert success'>Vendor updated successfully!</div>";
        // Redirect after 1 second
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php'; // PAGE TO REDIRECT
                }, 1000);
            </script>";
    } else {
        echo "<div class='alert error'>Error: " . $updateQuery . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vendor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #F5F6FA;">
        <div class="bck-btn">
        <a href="index.php"><button class="back-btn"><i class="fa-solid fa-backward"></i> Back</button></a>
        </div>
    <br>
    <div class="container">
        <h1>Update Vendor</h1>
        <form method="post" action="">
            <label for="vendorName">Vendor Name:</label>
            <input type="text" name="vendorName" id="vendorName" value="<?= htmlspecialchars($vendor['VendorName']) ?>" required>

            <label for="contactInfo">Contact Info:</label>
            <input type="text" name="contactInfo" id="contactInfo" value="<?= htmlspecialchars($vendor['ContactInfo']) ?>" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?= htmlspecialchars($vendor['Address']) ?>" required>

            <button type="submit" class="btn add-btn">Update</button>
        </form>
    </div>
</body>
</html>

<style>
    .bck-btn{
        margin-left: 15px;
        width: 10%;
    }
    .back-btn{
        width: 100%;
        padding: 10px;
        color: white;
        border: none;
        border-radius: 5px;
        background-color: #00D89E;
        cursor: pointer;
    }
    .back-btn:hover{
        transition: 0.3s;
        scale: 1.1;
        box-shadow: 1px 1px 1px black;
    }
body {
    font-family: 'Arial', sans-serif;
}

.container {
    max-width: 600px;
    margin: auto;
    padding: 30px;
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
    color: #752BDF;
}

label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

input[type='text'] {
    width: calc(100% - 20px);
    padding: 12px;
    margin-top: 5px;
    border: 2px solid #E0E0E0;
    border-radius: 5px;
}

input[type='text']:focus {
    border-color: #752BDF;
}

.btn {
    background-color: #00D89E;
    color: white;
    border: none;
    padding: 12px 20px;
    margin-top: 20px;
    cursor: pointer;
    border-radius: 5px;
}

.btn:hover {
    transition: 0.3s;
    background-color: #00D89E; 
    scale: 1.1;
    box-shadow: 3px 3px 10px black;
}

.alert {
   padding: 10px;
   margin-top: 15px;
   border-radius: 5px;
   text-align: center; /* Center text in alerts */
}

.success {
   background-color: #d4edda; 
   color: #155724; 
   border-color: #c3e6cb; 
}

.error {
   background-color: #f8d7da; 
   color: #721c24; 
   border-color: #f5c6cb; 
}
</style>
