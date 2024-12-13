<?php
$host = 'localhost';
$db = 'mvch';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch vendors for the datalist
$vendorQuery = "SELECT VendorID, VendorName FROM vendor";
$vendorResult = $conn->query($vendorQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['itemName'];
    $itemType = $_POST['itemType'];
    $vendorID = $_POST['vendor'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];

    $insertQuery = "INSERT INTO medicalsurgicalitem (ItemName, Type, VendorID, Quantity, cost) 
                    VALUES ('$itemName', '$itemType', '$vendorID', '$quantity', '$cost')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<div class='alert success'>Item added successfully!</div>";
        // Redirect after 3 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php'; //PAGE TO REDIRECT
                }, 2000);
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
    <title>Add Medical/Surgical Item</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #F5F6FA;">
    <br>
    <div class="container">
        <h1>Item</h1>
        <form method="post" action="">
            <!-- ITEM NAME -->
            <label for="itemName">Item Name:</label>
            <input type="text" name="itemName" id="itemName" required>

            <!-- ITEM TYPE -->
            <label for="itemType">Item Type:</label>
            <select name="itemType" id="itemType" required>
                <option value="Surgical">Surgical</option>
                <option value="Medical">Medical</option>
                <option value="Medicine">Medicine</option>
            </select>

            <!-- VENDOR -->
            <label for="vendor">Vendor:</label>
            <input type="text" name="vendor" id="vendor" list="vendors" required>
            <datalist id="vendors">
                <?php while($row = $vendorResult->fetch_assoc()): ?>
                    <option value="<?= $row['VendorID'] ?>"><?= $row['VendorName'] ?></option>
                <?php endwhile; ?>
            </datalist>

            <!-- QUANTITY -->
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required>

            <!-- COST -->
            <label for="cost">Cost (Php):</label>
            <input type="number" name="cost" id="cost" step=".01" required>

            <button type="submit" class="btn add-btn">Add</button>
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
    background-color: #009C7D; 
    scale: 1.1;
    box-shadow: 3px 3px 10px black;
}

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
