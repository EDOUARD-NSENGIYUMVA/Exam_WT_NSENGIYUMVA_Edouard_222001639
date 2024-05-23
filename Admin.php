<?php
// Include the database connection file
require_once "databaseconnection.php";
//Nsengiyumva edouard 222001639 /2024
// Perform SELECT query to retrieve data
$sql = "SELECT * FROM admin";
$result = $connection->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Admin Information</h2>";
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Email</th><th>Username</th><th>Email</th><th>Contact</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["contact"] . "</td>";
    
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
