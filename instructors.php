<?php
// Include the database connection file
require_once "databaseconnection.php";
// edouard bit
// Define SQL query
$sql = "SELECT * FROM instructors";

// Perform SELECT query to retrieve data
$result = $connection->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>instructors Information</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>FullName</th>
            <th>Bio</th>
            <th>ContactInformation</th>
            <th>ProfilePicture</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["FullName"]."</td>";
        echo "<td>" . $row["Bio"]."</td>";
        echo "<td>" . $row["ContactInformation"]."</td>";
        echo "<td>" . $row["ProfilePicture"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
