<?php
// Include the database connection file
require_once "databaseconnection.php";

// Perform SELECT query to retrieve data
$sql = "SELECT * FROM Categories";
$result = $connection->query($sql);
//Nsengiyumva Edouard 222001639 on 18th May 2024
// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Categories Information</h2>";
    echo "<table border='1'>";
    echo "<tr><th>CategoryID</th>
    <th>CategoryName</th>
    <th>Description</th>
   </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["CategoryID"] . "</td>";
        echo "<td>" . $row["CategoryName"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
