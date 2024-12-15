<?php
$host = 'localhost';
$db = 'mvch';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch facilities for the datalist
$facilityQuery = "SELECT FacilityID, Name FROM facility";
$facilityResult = $conn->query($facilityQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $physicianName = $_POST['physicianName'];
    $specialty = $_POST['specialty'];
    $facilityID = $_POST['facilityID'];

    $insertQuery = "INSERT INTO physician (PhysicianName, Specialty, FacilityID) 
                    VALUES ('$physicianName', '$specialty', '$facilityID')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<div class='alert success'>Physician added successfully!</div>";
        // Redirect after 2 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php'; // PAGE TO REDIRECT
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
    <title>Add Physician</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: rgb(207, 174, 251)">
<div class="bck-btn">
        <a href="index.php"><button class="back-btn"><i class="fa-solid fa-backward"></i> Back</button></a>
    </div>
    <br>
    <div class="container">
        <h1>Add Physician</h1>
        <form method="post" action="">
            <label for="physicianName">Physician Name:</label>
            <input type="text" name="physicianName" id="physicianName" required>

            <label for="specialty">Specialty:</label>
            <input type="text" name="specialty" id="specialty" required>

            <label for="facilityID">Facility ID:</label>
            <input type="text" name="facilityID" id="facilityID" list="facilities" required>
            <datalist id="facilities">
                <?php while($row = $facilityResult->fetch_assoc()): ?>
                    <option value="<?= $row['FacilityID'] ?>"><?= $row['Name'] ?></option>
                <?php endwhile; ?>
            </datalist>

            <button type="submit" class="btn add-btn">Add</button>
        </form>
    </div>
    <br>
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

input[type='text'], input[type='number'], select {
    padding: 12px;
    margin-top: 5px;
    border: 2px solid rgb(177, 127, 248);
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
    background-color:#00D89E;
    color: white;
    border: none;
    padding: 12px 20px;
    margin-top: 20px;
    cursor: pointer;
    border-radius: 5px;
}

.btn:hover {
    scale: 1.1;
    transition: 0.3s;
   background-color: #009C7D; /* Darker shade on hover */
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
