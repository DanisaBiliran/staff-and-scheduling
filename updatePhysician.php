<?php
include 'sessioncheck.php';
include 'conn.php';

// Fetch facilities for the datalist
$facilityQuery = "SELECT FacilityID, FacilityName FROM facility";
$facilityResult = $conn->query($facilityQuery);

// Check if physician_id is provided in the URL
if (!isset($_GET['physician_id'])) {
    echo "<div class='alert error'>No physician ID provided!</div>";
    exit;
}

$physicianID = $_GET['physician_id'];

// Fetch existing physician data
$physicianQuery = "SELECT * FROM physician WHERE PhysicianID = '$physicianID'";
$physicianResult = $conn->query($physicianQuery);

if ($physicianResult->num_rows == 0) {
    echo "<div class='alert error'>Physician not found!</div>";
    exit;
}

$physician = $physicianResult->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $physicianName = $_POST['physicianName'];
    $specialty = $_POST['specialty'];
    $facilityID = $_POST['facilityID'];

    $updateQuery = "UPDATE physician 
                    SET PhysicianName = '$physicianName', Specialty = '$specialty', FacilityID = '$facilityID' 
                    WHERE PhysicianID = '$physicianID'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<div class='alert success'>Physician updated successfully!</div>";
        // Redirect after 2 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php'; // PAGE TO REDIRECT
                }, 2000);
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
    <title>Update Physician</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: rgb(207, 174, 251);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #752BDF;
            margin-bottom: 20px;
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
            width: calc(100% - 20px);
            font-size: 1em;
        }

        input[type='text']:focus, input[type='number']:focus, select:focus {
            border-color: #752BDF;
            outline: none;
        }

        .btn {
            background-color: #00D89E;
            color: white;
            border: none;
            padding: 12px 20px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1em;
            text-transform: uppercase;
        }

        .btn:hover {
            scale: 1.1;
            transition: 0.3s;
            background-color: #009C7D; /* Darker shade on hover */
        }

        .bck-btn {
            margin: 15px;
        }

        .back-btn {
            width: 100%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            background-color: #00D89E;
            cursor: pointer;
        }

        .back-btn:hover {
            transition: 0.3s;
            scale: 1.1;
            box-shadow: 1px 1px 1px black;
        }

        /* Alerts */
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
</head>
<body>
    <div class="container">
        <h1>Update Physician</h1>
        <form method="post" action="">
            <!-- Physician Name -->
            <label for="physicianName">Physician Name:</label>
            <input type="text" name="physicianName" id="physicianName" value="<?= htmlspecialchars($physician['PhysicianName']) ?>" required>

            <!-- Specialty -->
            <label for="specialty">Specialty:</label>
            <input type="text" name="specialty" id="specialty" value="<?= htmlspecialchars($physician['Specialty']) ?>" required>

            <!-- Facility ID -->
            <label for="facilityID">Facility ID:</label>
            <input type="text" name="facilityID" id="facilityID" list="facilities" value="<?= htmlspecialchars($physician['FacilityID']) ?>" required>
            <datalist id="facilities">
                <?php while ($row = $facilityResult->fetch_assoc()): ?>
                    <option value="<?= $row['FacilityID'] ?>" <?= $row['FacilityID'] == $physician['FacilityID'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['FacilityName']) ?>
                    </option>
                <?php endwhile; ?>
            </datalist>

            <!-- Submit Button -->
            <button type="submit" class="btn">Update Physician</button>
        </form>
    </div>
</body>
</html>
