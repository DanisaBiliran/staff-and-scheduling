<?php
$host = 'localhost';
$db = 'mvch';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch items for the dropdown
$itemQuery = "SELECT ItemID, ItemName FROM medicalsurgicalitem WHERE Type='Medicine'";
$itemResult = $conn->query($itemQuery);

// Fetch physicians for the dropdown
$physicianQuery = "SELECT PhysicianID, PhysicianName FROM physician";
$physicianResult = $conn->query($physicianQuery);

// Fetch patients for the datalist
$patientQuery = "SELECT PatientID, PatientName FROM patient";
$patientResult = $conn->query($patientQuery);

// Initialize variables
$orderID = $itemID = $orderType = $quantity = $orderedBy = $writtenBy = $status = '';
$isEdit = false;

// Check if editing an existing order
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $orderID = $_GET['order_id'];
    $isEdit = true;

    // Fetch the order details
    $orderQuery = "SELECT * FROM medicalorder WHERE OrderID = $orderID";
    $orderResult = $conn->query($orderQuery);

    if ($orderResult->num_rows > 0) {
        $order = $orderResult->fetch_assoc();
        $itemID = $order['Item_FK'];
        $orderType = $order['OrderType'];
        $quantity = $order['Quantity'];
        $orderedBy = $order['PatientID_FK'];
        $writtenBy = $order['PhysicianID_FK'];
        $status = $order['Status'];
    } else {
        echo "<div class='alert error'>Order not found.</div>";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemID = $_POST['item'];
    $orderType = $_POST['orderType'];
    $quantity = $_POST['quantity'];
    $orderedBy = $_POST['orderedBy'];
    $writtenBy = $_POST['writtenBy'];
    $status = $_POST['status'];

    if ($isEdit) {
        // Update query
        $updateQuery = "UPDATE medicalorder SET 
                        Item_FK = '$itemID', 
                        OrderType = '$orderType', 
                        Quantity = '$quantity', 
                        PatientID_FK = '$orderedBy', 
                        PhysicianID_FK = (SELECT PhysicianID FROM physician WHERE PhysicianName = '$writtenBy'), 
                        Status = '$status' 
                        WHERE OrderID = $orderID";

        if ($conn->query($updateQuery) === TRUE) {
            echo "<div class='alert success'>Order updated successfully!</div>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php'; // PAGE TO REDIRECT
                    }, 1000);
                  </script>";
        } else {
            echo "<div class='alert error'>Error: " . $updateQuery . "<br>" . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Update Order' : 'New Order' ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #F5F6FA;">
    <br>
    <div class="container">
        <h1><?= $isEdit ? 'Update Order' : 'New Order' ?></h1>
        <form method="post" action="">
            <!-- ITEM -->
            <label for="item">Item:</label>
            <select name="item" id="item" required>
                <?php while($row = $itemResult->fetch_assoc()): ?>
                    <option value="<?= $row['ItemID'] ?>" <?= $row['ItemID'] == $itemID ? 'selected' : '' ?>>
                        <?= $row['ItemName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <!-- ORDER TYPE -->
            <label for="orderType">Order Type:</label>
            <select name="orderType" id="orderType" required>
                <option value="diagnostic" <?= $orderType == 'diagnostic' ? 'selected' : '' ?>>Diagnostic</option>
                <option value="drugs" <?= $orderType == 'drugs' ? 'selected' : '' ?>>Drugs</option>
            </select>

            <!-- QUANTITY -->
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="<?= htmlspecialchars($quantity) ?>" required>

            <!-- ORDERED BY -->
            <label for="orderedBy">Ordered By (Patient ID):</label>
            <input type="text" name="orderedBy" id="orderedBy" list="patients" value="<?= htmlspecialchars($orderedBy) ?>" required>
            <datalist id="patients">
                <?php while($row = $patientResult->fetch_assoc()): ?>
                    <option value="<?= $row['PatientID'] ?>" <?= $row['PatientID'] == $orderedBy ? 'selected' : '' ?>>
                        <?= $row['PatientName'] ?>
                    </option>
                <?php endwhile; ?>
            </datalist>

            <!-- WRITTEN BY -->
            <label for="writtenBy">Written By (Physician Name):</label>
            <select name="writtenBy" id="writtenBy" required>
                <?php while($row = $physicianResult->fetch_assoc()): ?>
                    <option value="<?= $row['PhysicianName'] ?>" <?= $row['PhysicianName'] == $writtenBy ? 'selected' : '' ?>>
                        <?= $row['PhysicianName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <!-- ORDER STATUS -->
            <label for="status">Order Status:</label>
            <select name="status" id="status" required>
                <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="cancelled" <?= $status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                <option value="completed" <?= $status == 'completed' ? 'selected' : '' ?>>Completed</option>
            </select>

            <button type="submit" class="btn confirm-btn">Confirm</button>
            <button type="button" class="btn back-btn" onclick="window.history.back();">Go Back</button>
        </form>
    </div>
    <br>
</body>
</html>
