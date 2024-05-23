<?php
// Include the database connection file
require_once "databaseconnection.php";
//Nsengiyumva Edouard222001639 on 15th May 2024
// Perform SELECT query to retrieve data
$sql = "SELECT * FROM Payments";
$result = $connection->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Payments Information</h2>";
    echo "<table border='1'>";
    echo "<tr><th>PaymentID</th>
    <th>UserID</th>
    <th>WorkshopID</th>
   <th>Amount</th>
    <th>PaymentStatus</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["PaymentID"] . "</td>";
        echo "<td>" . $row["UserID"] . "</td>";
       echo "<td>" . $row["WorkshopID"] . "</td>";
        echo "<td>" . $row["Amount"] . "</td>";
        echo "<td>" . $row["PaymentStatus"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
