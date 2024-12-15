<?php
include 'sessioncheck.php';
include 'conn.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffName = $_POST['staffName'];
    $role = $_POST['role'];

    $insertQuery = "INSERT INTO staff (StaffName, Role) 
                    VALUES ('$staffName', '$role')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<div class='alert success'>Staff added successfully!</div>";
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
    <title>Add Staff</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: rgb(207, 174, 251);">
<div class="bck-btn">
        <a href="index.php"><button class="back-btn"><i class="fa-solid fa-backward"></i> Back</button></a>
    </div>
    <br>
    <div class="container">
        <h1>Add Staff</h1>
        <form method="post" action="">
            <label for="staffName">Staff Name:</label>
            <input type="text" name="staffName" id="staffName" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="Nurse">Nurse</option>
                <option value="IT">IT</option>
                <option value="Registrar">Registrar</option>
            </select>

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

input[type='text'], select {
    padding: 12px;
    margin-top: 5px;
    border: 2px solid rgb(177, 127, 248);
    border-radius: 5px;
}

input[type='text'] {
    width: calc(95% - 20px);
}

select {
    width: calc(100% - 20px);
}

input[type='text']:focus, select:focus {
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
