<?php
require_once "databaseconnection.php";

try {
    // Query to select all rows from the "attendees" table
    $sql = "SELECT * FROM attendees";
    
    // Execute the SQL query
    $result = $connection->query($sql);
    
    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output HTML for the table
        echo "<title>The Information of Attendees</title>";
        echo "<table border='1'>
                <tr>
                    <th>AttendeeID </th>
                    <th>UserID</th>
                    <th>WorkshopID</th>
                    <th>RegistrationDate</th>
                </tr>";
    
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
             echo "<td>" . htmlspecialchars($row["AttendeeID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["UserID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["WorkshopID"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["RegistrationDate"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // If there are no results, output a message
        echo "0 results";
    }
    
    // Close the database connection
    $connection->close();
} catch (Exception $e) {
    // Handle any exceptions
    echo "Error: " . $e->getMessage();
}
?>
