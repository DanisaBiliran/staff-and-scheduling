<?php
include 'sessioncheck.php';
include 'conn.php';

if (isset($_GET['id'])) {
    $orderID = intval($_GET['id']); 


    $deleteQuery = "DELETE FROM medicalorder WHERE OrderID = $orderID";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>
                alert('Order deleted successfully!');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    } else {

        echo "<script>
                alert('Error deleting order: {$conn->error}');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    }
} else {

    echo "<script>
            alert('No oorder ID provided.');
            window.location.href = 'index.php';
          </script>";
}

$conn->close();
?>
