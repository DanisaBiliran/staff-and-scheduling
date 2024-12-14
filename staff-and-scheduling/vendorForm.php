<?php
$host = 'localhost';
$db = 'mvch';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendorName = $_POST['vendorName'];
    $contactInfo = $_POST['contactInfo'];
    $address = $_POST['address'];

    $insertQuery = "INSERT INTO vendor (VendorName, ContactInfo, Address) 
                    VALUES ('$vendorName', '$contactInfo', '$address')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<div class='alert success'>Item added successfully!</div>";
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
    <title>Add Vendor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: #F5F6FA;">
    <br>
    <div class="container">
        <h1>Add Vendor</h1>
        <form method="post" action="">
            <label for="vendorName">Vendor Name:</label>
            <input type="text" name="vendorName" id="vendorName" required>

            <label for="contactInfo">Contact Info:</label>
            <input type="text" name="contactInfo" id="contactInfo" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>

            <button type="submit" class="btn add-btn">Add</button>
        </form>
    </div>
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
    background-color: #009C7D; 
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
