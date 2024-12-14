<?php
include 'conn.php';


$wardQuery = "SELECT WardID, WardName FROM ward";
$wardResult = $conn->query($wardQuery);


$patientName = $dateOfBirth = $gender = $wardID = $status = $symptoms = $allergies = $medication = $medicalHistory = $events = $dischargeDetails = '';
$isEdit = false;


if (isset($_GET['patient_id']) && is_numeric($_GET['patient_id'])) {
    $patientID = $_GET['patient_id'];
    $isEdit = true;

 
    $patientQuery = "SELECT * FROM patient WHERE PatientID = $patientID";
    $patientResult = $conn->query($patientQuery);

    if ($patientResult->num_rows > 0) {
        $patient = $patientResult->fetch_assoc();
        $patientName = $patient['PatientName'];
        $dateOfBirth = $patient['DateOfBirth'];
        $gender = $patient['Gender'];
        $wardID = $patient['WardID'];
        $status = $patient['Status'];
        $symptoms = $patient['Symptoms'];
        $allergies = $patient['Allergies'];
        $medication = $patient['Medication'];
        $medicalHistory = $patient['MedicalHistory'];
        $events = $patient['Events'];
        $dischargeDetails = $patient['DischargeDetails'];
    } else {
        echo "<div class='alert error'>Patient not found.</div>";
        exit;
    }
}


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


    $errorMessage = "";

 
    if (!is_numeric($wardID)) {
        $errorMessage = "Invalid Ward ID. Please enter a numeric Ward ID.";
    } else {
        $wardCheckQuery = "SELECT WardID FROM ward WHERE WardID = $wardID";
        $wardCheckResult = $conn->query($wardCheckQuery);

        if ($wardCheckResult->num_rows === 0) {
            $errorMessage = "Ward ID not found. Please enter a valid Ward ID.";
        }
    }

    
    if (empty($errorMessage)) {
        if ($isEdit) {
   
            $updateQuery = "UPDATE patient 
                            SET PatientName='$patientName', DateOfBirth='$dateOfBirth', Gender='$gender', WardID='$wardID', 
                                Status='$status', Symptoms='$symptoms', Allergies='$allergies', Medication='$medication', 
                                MedicalHistory='$medicalHistory', Events='$events', DischargeDetails='$dischargeDetails'
                            WHERE PatientID=$patientID";

            if ($conn->query($updateQuery) === TRUE) {
                echo "<div class='alert success'>Patient updated successfully!</div>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php'; // PAGE TO REDIRECT
                        }, 2000);
                    </script>";
            } else {
                echo "<div class='alert error'>Error: " . $conn->error . "</div>";
            }
        }
    } else {

        echo "<div class='alert error'>$errorMessage</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Patient' : 'Add Patient' ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: rgb(231, 232, 236);">
    <br>
    <div class="container">
        <h1><?= $isEdit ? 'Edit Patient' : 'Add Patient' ?></h1>
        <form method="post" action="">
            <label for="patientName">Patient Name:</label>
            <input type="text" name="patientName" id="patientName" value="<?= htmlspecialchars($patientName) ?>" required>

            <label for="dateOfBirth">Date of Birth:</label>
            <input type="date" name="dateOfBirth" id="dateOfBirth" value="<?= htmlspecialchars($dateOfBirth) ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="M" <?= $gender == 'M' ? 'selected' : '' ?>>Male</option>
                <option value="F" <?= $gender == 'F' ? 'selected' : '' ?>>Female</option>
            </select>

            <label for="wardID">Ward ID:</label>
            <input type="text" name="wardID" id="wardID" list="wards" value="<?= htmlspecialchars($wardID) ?>" required>
            <datalist id="wards">
                <?php while ($row = $wardResult->fetch_assoc()): ?>
                    <option value="<?= $row['WardID'] ?>" <?= $row['WardID'] == $wardID ? 'selected' : '' ?>>
                        <?= $row['WardName'] ?>
                    </option>
                <?php endwhile; ?>
            </datalist>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="admitted" <?= $status == 'admitted' ? 'selected' : '' ?>>Admitted</option>
                <option value="discharge" <?= $status == 'discharge' ? 'selected' : '' ?>>Discharge</option>
            </select>

            <label for="symptoms">Symptoms:</label>
            <textarea name="symptoms" id="symptoms" rows="4"><?= htmlspecialchars($symptoms) ?></textarea>

            <label for="allergies">Allergies:</label>
            <textarea name="allergies" id="allergies" rows="4"><?= htmlspecialchars($allergies) ?></textarea>

            <label for="medication">Medication:</label>
            <textarea name="medication" id="medication" rows="4"><?= htmlspecialchars($medication) ?></textarea>

            <label for="medicalHistory">Medical History:</label>
            <textarea name="medicalHistory" id="medicalHistory" rows="4"><?= htmlspecialchars($medicalHistory) ?></textarea>

            <label for="events">Events:</label>
            <textarea name="events" id="events" rows="4"><?= htmlspecialchars($events) ?></textarea>

            <label for="dischargeDetails">Discharge Details:</label>
            <textarea name="dischargeDetails" id="dischargeDetails" rows="4"><?= htmlspecialchars($dischargeDetails) ?></textarea>

            <button type="submit" class="btn add-btn"><?= $isEdit ? 'Update' : 'Add' ?></button>
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
        border: 2px solid #E0E0E0;
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