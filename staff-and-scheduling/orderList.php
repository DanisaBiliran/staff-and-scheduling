<?php
    include 'conn.php';

    // Capture the search query if available
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Modify the SQL query to include filtering
    $sql = "SELECT mo.*, phy.PhysicianName, pat.PatientName
        FROM medicalorder mo
        JOIN physician phy ON mo.PhysicianID_FK = phy.PhysicianID
        JOIN patient pat ON mo.PatientID_FK = pat.PatientID";
    if (!empty($search)) {
        $sql .= " WHERE OrderID LIKE '%$search%' OR OrderType LIKE '%$search%'";
    }

    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order List</title>
        <style>
            * {
                box-sizing: border-box;
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            body {
                background-color: #f3f4f6;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .table-container {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 85%;
                height: 80%;
                overflow-x: auto;
            }

            .searchbox {
                display: flex;
                justify-content: center;
                margin-bottom: 15px;
            }

            .searchbox input {
                width: 80%;
                padding: 10px;
                border: 1px solid #e2e8f0;
                border-radius: 4px 0 0 4px;
                outline: none;
            }

            .searchbox button {
                padding: 10px 20px;
                background-color: #752BDF;
                color: #fff;
                border: none;
                cursor: pointer;
                border-radius: 0 4px 4px 0;
                text-transform: uppercase;
                font-weight: bold;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th, td {
                padding: 15px;
                text-align: left;
                border-bottom: 2px solid #e2e8f0;
                color: #333;
                font-size: 1em;
            }

            th {
                background-color: #752BDF;
                font-weight: bold;
                color: #fff;
                text-transform: uppercase;
            }

            tr:nth-child(even) {
                background-color: #f9fafb;
            }

            tr:hover {
                background-color: #e5e7eb;
            }

            .table-title {
                font-size: 1.5em;
                color: #333;
                text-align: center;
                margin-bottom: 10px;
            }

            .btn {
                margin-left: 10px;
            }

            .view {
                color: #FF8B4F;
                text-decoration: none;
            }

            .update {
                color: #08A77C;
                text-decoration: none;
            }

            .delete {
                color: #FF0000;
                text-decoration: none;
            }
            a{
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="table-container">
            <h2 class="table-title">Order Information</h2>
            <!-- Search Form -->
            <form method="GET" action="">
                <div class="searchbox">
                    <input type="text" name="search" id="search" placeholder="Search patients..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">Search</button>
                </div>
            </form>
            <a href="index.php">Go Back</a>
            <!-- Patient Table -->
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Order Type</th>
                    <th>Written By</th>
                    <th>Ordered By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                <tr>
                                    <td>$row[OrderID]</td>
                                    <td>$row[OrderDate]</td>
                                    <td>$row[OrderType]</td>
                                    <td>$row[PhysicianName]</td>
                                    <td>$row[PatientName]</td>
                                    <td>$row[Status]</td>
                                    <td>
                                        <a class='btn view' href='orderDetails.php?order_id={$row['OrderID']}'>View</a>
                                        <a class='btn update' href='updateOrder.php?order_id={$row['OrderID']}'>Update</a> 
                                        <a class='btn delete' href=''>Delete</a>
                                    </td>
                                </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No results found</td></tr>";
                    }
                ?>
            </table>
        </div>
    </body>
</html>