<?php
// Include the database connection file
require_once "databaseconnection.php";

// Perform SELECT query to retrieve data
$sql = "SELECT * FROM creditmanagementresources";
$result = $connection->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Table:creditmanagementresources Information</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>ResourceID</th>
            <th>ResourceName</th>
            <th>Description</th>
            <th>Link</th>
          </tr>"; // This line was missing

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ResourceID"] . "</td>";
        echo "<td>" . $row["ResourceName"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "<td>" . $row["Link"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
