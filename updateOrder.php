<?php
include 'conn.php';

// Fetch items for the dropdown
$itemQuery = "SELECT ItemID, ItemName FROM medicalsurgicalitem WHERE Type='Medicine'";
$itemResult = $conn->query($itemQuery);

// Fetch physicians for the dropdown
$physicianQuery = "SELECT PhysicianID, PhysicianName FROM physician";
$physicianResult = $conn->query($physicianQuery);

// Fetch patients for the datalist
$patientQuery = "SELECT PatientID, PatientName FROM patient";
$patientResult = $conn->query($patientQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemID = $_POST['item'];
    $orderType = $_POST['orderType'];
    $quantity = $_POST['quantity'];
    $orderedBy = $_POST['orderedBy'];
    $writtenBy = $_POST['writtenBy'];
    $status = $_POST['status'];

    $insertQuery = "INSERT INTO medicalorder (PatientID_FK, PhysicianID_FK, OrderType, Status, Item_FK) 
                    VALUES ('$orderedBy', 
                            (SELECT PhysicianID FROM physician WHERE PhysicianName='$writtenBy'), 
                            '$orderType', '$status', '$itemID')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<div class='alert success'>Order updated successfully!</div>";
        // Redirect after 3 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php'; //PAGE TO REDIRECT
                }, 1000);
            </script>";
    } else {
        echo "<div class='alert error'>Error: " . $insertQuery . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #F5F6FA;">
    <br>
    <div class="container">
        <h1>Order Form</h1>
        <form method="post" action="">
            <!-- ITEM -->
            <label for="item">Item:</label>
            <select name="item" id="item" required>
                <?php while($row = $itemResult->fetch_assoc()): ?>
                    <option value="<?= $row['ItemID'] ?>"><?= $row['ItemName'] ?></option>
                <?php endwhile; ?>
            </select>

            <!-- ORDER TYPE -->
            <label for="orderType">Order Type:</label>
            <select name="orderType" id="orderType" required>
                <option value="diagnostic">Diagnostic</option>
                <option value="drugs">Drugs</option>
            </select>

            <!-- QUANTITY -->
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required>

            <!-- ORDERED BY -->
            <label for="orderedBy">Ordered By (Patient ID):</label>
            <input type="text" name="orderedBy" id="orderedBy" list="patients" required>
            <datalist id="patients">
                <?php while($row = $patientResult->fetch_assoc()): ?>
                    <option value="<?= $row['PatientID'] ?>"><?= $row['PatientName'] ?></option>
                <?php endwhile; ?>
            </datalist>

            <!-- WRITTEN BY -->
            <label for="writtenBy">Written By (Physician Name):</label>
            <select name="writtenBy" id="writtenBy" required>
                <?php while($row = $physicianResult->fetch_assoc()): ?>
                    <option value="<?= $row['PhysicianName'] ?>"><?= $row['PhysicianName'] ?></option>
                <?php endwhile; ?>
            </select>

            <!-- ORDER STATUS -->
            <label for="status">Order Status:</label>
            <select name="status" id="status" required>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
                <option value="completed">Completed</option>
            </select>

            <button type="submit" class="btn confirm-btn">Confirm</button>
            <button type="button" class="btn back-btn" onclick="window.history.back();">Go Back</button>
        </form>
    </div>
    <br>
</body>
</html>

<style>
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
    font-size: 2.5em;
}

label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

input[type='text'], input[type='number'], select {
    padding: 12px;
    margin-top: 5px;
    border: 2px solid #E0E0E0;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

input[type='text'], input[type='number'] {
    width: calc(95% - 20px);
}

select {
    width: calc(100% - 20px);
}

input[type='text']:focus, input[type='number']:focus, select:focus {
    border-color: #752BDF;
}

/* BUTTONS */
.btn {
    background-color: #00D89E;
    color: white;
    border: none;
    padding: 12px 20px;
    margin-top: 20px;
    margin-right: 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn:hover {
    background-color: #009C7D;
    scale: 1.1;
    box-shadow: 3px 3px 10px black;
}

.back-btn {
   background-color: #752BDF; 
}

.back-btn:hover {
    background-color: #5C1BBF;
    scale: 1.1;
    box-shadow: 3px 3px 10px black;
}

/* WHEN CONFIRM BUTTON IS PRESSED */
.alert {
   padding: 10px;
   margin-top: 15px;
   border-radius: 5px;
   text-align: center;
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
