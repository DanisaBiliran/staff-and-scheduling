<?php
$host = 'localhost';
$db = 'mvch';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch wards for the datalist
$wardQuery = "SELECT WardID, WardName FROM ward";
$wardResult = $conn->query($wardQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientName = $_POST['patientName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['gender'];
    $wardID = $_POST['wardID'];
    $status = $_POST['status'];
    $symptoms = $_POST['symptoms'];
    $allergies = $_POST['allergies'];
    $medication = $_POST['medication'];
    $medicalHistory = $_POST['medicalHistory'];
    $events = $_POST['events'];
    $dischargeDetails = $_POST['dischargeDetails'];

    $insertQuery = "INSERT INTO patient (PatientName, DateOfBirth, Gender, WardID, Status, Symptoms, Allergies, Medication, MedicalHistory, Events, DischargeDetails) 
                    VALUES ('$patientName', '$dateOfBirth', '$gender', '$wardID', '$status', '$symptoms', '$allergies', '$medication', '$medicalHistory', '$events', '$dischargeDetails')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<div class='alert success'>Patient added successfully!</div>";
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
    <title>Add Patient</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color:rgb(207, 174, 251)">
    <br>
    <div class="container">
        <h1>Add Patient</h1>
        <form method="post" action="">
            <label for="patientName">Patient Name:</label>
            <input type="text" name="patientName" id="patientName" required>

            <label for="dateOfBirth">Date of Birth:</label>
            <input type="date" name="dateOfBirth" id="dateOfBirth" required>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>

            <label for="wardID">Ward ID:</label>
            <input type="text" name="wardID" id="wardID" list="wards" required>
            <datalist id="wards">
                <?php while($row = $wardResult->fetch_assoc()): ?>
                    <option value="<?= $row['WardID'] ?>"><?= $row['WardName'] ?></option>
                <?php endwhile; ?>
            </datalist>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="admitted">Admitted</option>
                <option value="discharge">Discharge</option>
            </select>

            <label for="symptoms">Symptoms:</label>
            <textarea name="symptoms" id="symptoms" rows="4"></textarea>

            <label for="allergies">Allergies:</label>
            <textarea name="allergies" id="allergies" rows="4"></textarea>

            <label for="medication">Medication:</label>
            <textarea name="medication" id="medication" rows="4"></textarea>

            <label for="medicalHistory">Medical History:</label>
            <textarea name="medicalHistory" id="medicalHistory" rows="4"></textarea>

            <label for="events">Events:</label>
            <textarea name="events" id="events" rows="4"></textarea>

            <label for="dischargeDetails">Discharge Details:</label>
            <textarea name="dischargeDetails" id="dischargeDetails" rows="4"></textarea>

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

input[type='text'], input[type='date'], input[type='number'], select, textarea {
    padding: 12px;
    margin-top: 5px;
    border: 2px solid rgb(177, 127, 248);
    border-radius: 5px;
}

input[type='text'], input[type='date'], input[type='number'], textarea {
    width: calc(95% - 20px);
}

select {
    width: calc(100% - 20px);
}

input[type='text']:focus, input[type='date']:focus, input[type='number']:focus, select:focus, textarea:focus {
    border-color: #752BDF;
}

.btn {
    background-color:rgb(14, 192, 14);
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
