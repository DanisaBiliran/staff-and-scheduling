<?php
include 'sessioncheck.php';
include 'conn.php';

if (isset($_GET['id'])) {
    $physicianID = intval($_GET['id']); 


    $deleteQuery = "DELETE FROM physician WHERE PhysicianID = $physicianID";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>
                alert('Physician deleted successfully!');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    } else {

        echo "<script>
                alert('Error deleting physician: {$conn->error}');
                window.location.href = 'index.php'; // Redirect to the physician list
              </script>";
    }
} else {

    echo "<script>
            alert('No physician ID provided.');
            window.location.href = 'index.php';
          </script>";
}

$conn->close();
?>
