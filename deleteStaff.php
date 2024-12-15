<?php
include 'sessioncheck.php';
include 'conn.php';

if (isset($_GET['id'])) {
    $staffID = intval($_GET['id']); 


    $deleteQuery = "DELETE FROM staff WHERE StaffID = $staffID";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>
                alert('Staff deleted successfully!');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    } else {

        echo "<script>
                alert('Error deleting Staff: {$conn->error}');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    }
} else {

    echo "<script>
            alert('No Staff ID provided.');
            window.location.href = 'index.php';
          </script>";
}

$conn->close();
?>
