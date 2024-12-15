<?php
include 'sessioncheck.php';
include 'conn.php';

// Check if the item ID is provided
if (!isset($_GET['item_id']) || empty($_GET['item_id'])) {
    header("Location: inventory.php");
    exit();
}

$itemID = $_GET['item_id'];

// Fetch vendors for the datalist
$vendorQuery = "SELECT VendorID, VendorName FROM vendor";
$vendorResult = $conn->query($vendorQuery);

// Fetch current item details
$itemQuery = "SELECT * FROM medicalsurgicalitem WHERE ItemID = ?";
$stmt = $conn->prepare($itemQuery);
$stmt->bind_param("i", $itemID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert error'>Item not found.</div>";
    exit();
}

$item = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['itemName'];
    $itemType = $_POST['itemType'];
    $vendorID = $_POST['vendor'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];

    // Update the item in the database
    $updateQuery = "UPDATE medicalsurgicalitem 
                    SET ItemName = ?, Type = ?, VendorID = ?, Quantity = ?, cost = ? 
                    WHERE ItemID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssiiii", $itemName, $itemType, $vendorID, $quantity, $cost, $itemID);

    if ($updateStmt->execute()) {
        echo "<div class='alert success'>Item updated successfully!</div>";
        // Redirect after a short delay
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'itemList.php'; //PAGE TO REDIRECT
                }, 1000);
              </script>";
    } else {
        echo "<div class='alert error'>Error: Could not update item. Please try again later.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical/Surgical Item</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #F5F6FA;">
    <div class="bck-btn">
        <a href="itemList.php"><button class="back-btn"><i class="fa-solid fa-backward"></i> Back</button></a>
    </div>
    <br>
    <div class="container">
        <h1>Update Item</h1>
        <form method="post" action="">
            <!-- ITEM NAME -->
            <label for="itemName">Item Name:</label>
            <input type="text" name="itemName" id="itemName" value="<?= htmlspecialchars($item['ItemName']); ?>" required>

            <!-- ITEM TYPE -->
            <label for="itemType">Item Type:</label>
            <select name="itemType" id="itemType" required>
                <option value="Surgical" <?= $item['Type'] == 'Surgical' ? 'selected' : ''; ?>>Surgical</option>
                <option value="Medical" <?= $item['Type'] == 'Medical' ? 'selected' : ''; ?>>Medical</option>
                <option value="Medicine" <?= $item['Type'] == 'Medicine' ? 'selected' : ''; ?>>Medicine</option>
            </select>

            <!-- VENDOR -->
            <label for="vendor">Vendor:</label>
            <input type="text" name="vendor" id="vendor" list="vendors" value="<?= htmlspecialchars($item['VendorID']); ?>" required>
            <datalist id="vendors">
                <?php while ($row = $vendorResult->fetch_assoc()): ?>
                    <option value="<?= $row['VendorID'] ?>" <?= $item['VendorID'] == $row['VendorID'] ? 'selected' : ''; ?>><?= $row['VendorName'] ?></option>
                <?php endwhile; ?>
            </datalist>

            <!-- QUANTITY -->
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="<?= htmlspecialchars($item['Quantity']); ?>" required>

            <!-- COST -->
            <label for="cost">Cost (Php):</label>
            <input type="number" name="cost" id="cost" step=".01" value="<?= htmlspecialchars($item['cost']); ?>" required>

            <button type="submit" class="btn add-btn">Update</button>
        </form>
    </div>
    <br>
</body>
</html>

<style>
/* Use the same styles as provided in the original code */
body {
    font-family: 'Arial', sans-serif;
}
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
