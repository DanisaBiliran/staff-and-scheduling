<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mvch";

// Create a new mysqli object for database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} //else {
//     echo "Connected successfully!<br>"; 
// }

// Total number of patients
$query_total_patients = "SELECT COUNT(*) AS total_patients FROM patient";
$result = $conn->query($query_total_patients);
$total_patients = $result->fetch_assoc()['total_patients'];

// Available staff
$query_available_staff = "SELECT COUNT(*) AS available_staff FROM staff";
$result = $conn->query($query_available_staff);
$available_staff = $result->fetch_assoc()['available_staff'];

// Inventory stocks
$query_inventory_stocks = "
    SELECT Type, SUM(Quantity) AS total_quantity 
    FROM medicalsurgicalitem 
    GROUP BY Type"; // This groups by Type (Medical/Surgical)
$result = $conn->query($query_inventory_stocks);
$inventory_by_type = [];
while ($row = $result->fetch_assoc()) {
    $inventory_by_type[$row['Type']] = $row['total_quantity'];
}

// Inventory pie chart
$medical_count = isset($inventory_by_type['Medical']) ? $inventory_by_type['Medical'] : 0;
$surgical_count = isset($inventory_by_type['Surgical']) ? $inventory_by_type['Surgical'] : 0;


// Total number of physicians
$query_total_physicians = "SELECT COUNT(*) AS total_physicians FROM physician";
$result = $conn->query($query_total_physicians);
$total_physicians = $result->fetch_assoc()['total_physicians'];

// Patients by gender
$query_patients_by_gender = "
    SELECT Gender, COUNT(*) AS count 
    FROM patient 
    GROUP BY Gender";
$result = $conn->query($query_patients_by_gender);
$patients_by_gender = [];
while ($row = $result->fetch_assoc()) {
    $patients_by_gender[$row['Gender']] = $row['count'];
}

// Gender pie chart
$male_count = isset($patients_by_gender['M']) ? $patients_by_gender['M'] : 0;
$female_count = isset($patients_by_gender['F']) ? $patients_by_gender['F'] : 0;


// Patients by status
$query_patients_by_status = "
    SELECT Status, COUNT(*) AS count 
    FROM patient 
    GROUP BY Status";
$result = $conn->query($query_patients_by_status);
$patients_by_status = [];
while ($row = $result->fetch_assoc()) {
    $patients_by_status[$row['Status']] = $row['count'];
}

// Counts for pie chart
$discharged_count = isset($patients_by_status['discharge']) ? $patients_by_status['discharge'] : 0;
$admitted_count = isset($patients_by_status['admitted']) ? $patients_by_status['admitted'] : 0;


// Output results
// echo "Total Patients: " . $total_patients . "<br>";
// echo "Available Staff: " . $available_staff . "<br>";
// echo "Total Physicians: " . $total_physicians . "<br>";
// echo "Patients by Gender: ";
// print_r($patients_by_gender);

// Close the database connection
$conn->close();
?>
