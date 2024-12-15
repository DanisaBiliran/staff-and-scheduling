<?php
include 'sessioncheck.php';
include 'conn.php';

if (isset($_GET['id'])) {
    $vendorID = intval($_GET['id']); 


    $deleteQuery = "DELETE FROM vendor WHERE VendorID = $vendorID";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>
                alert('Vendor deleted successfully!');
                window.location.href = 'index.php'; // Redirect to the patient list
              </script>";
    } else {

        echo "<script>
                alert('Error deleting vendor: {$conn->error}');
                window.location.href = 'index.php'; // Redirect to the vendor list
              </script>";
    }
} else {

    echo "<script>
            alert('No vendor ID provided.');
            window.location.href = 'index.php';
          </script>";
}

$conn->close();
?>
