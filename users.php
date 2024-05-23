<?php
// Include the database connection file
require_once "databaseconnection.php";

// Define SQL query
$sql = "SELECT * FROM Users";

// Perform SELECT query to retrieve data
$result = $connection->query($sql);
// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Users Information</h2>";
    echo "<table border='1'>";
    echo "<tr>
    <th>UserID<th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>RegistrationDate</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
         echo "<td>" . $row["UserID"] . "</td>";
        echo "<td>" . $row["Username"] . "</td>";
        echo "<td>" . $row["Email"] . "</td>";
        echo "<td>" . $row["Password"] . "</td>";
        echo "<td>" . $row["RegistrationDate"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
