<?php
include 'conn.php'; 


if (isset($_GET['id'])) {
    $patientID = intval($_GET['id']); 


    $deleteQuery = "DELETE FROM patient WHERE PatientID = $patientID";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>
                alert('Patient deleted successfully!');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    } else {

        echo "<script>
                alert('Error deleting patient: {$conn->error}');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    }
} else {

    echo "<script>
            alert('No patient ID provided.');
            window.location.href = 'index.php';
          </script>";
}

$conn->close();
?>
