<?php
// Include the database connection file
require_once "databaseconnection.php";
// 222001639 Edouard nsenge
// Define the SQL query to retrieve data
$sql = "SELECT WorkshopID, WorkshopName, DateTime, InstructorID, MaxParticipants FROM workshops";

// Perform SELECT query to retrieve data
$result = $connection->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Workshops Information</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>WorkshopID</th>
            <th>WorkshopName</th>
            <th>DateTime</th>
            <th>InstructorID</th>
            <th>MaxParticipants</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["WorkshopID"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["WorkshopName"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["DateTime"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["InstructorID"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["MaxParticipants"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
