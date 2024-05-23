<?php
// Include the database connection file
require_once "databaseconnection.php";

// Define SQL query
$sql = "SELECT * FROM feedback";

// Perform SELECT query to retrieve data
$result = $connection->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<h2>Feedback Information</h2>";
    echo "<table border='1'>";
    echo "<tr>
    <th>FeedbackID</th>
            <th>UserID</th>
            <th>WorkshopID</th>
            <th>Rating</th>
            <th>Comments</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
         echo "<td>" . $row["FeedbackID"] . "</td>";
        echo "<td>" . $row["UserID"] . "</td>";
        echo "<td>" . $row["WorkshopID"] . "</td>";
        echo "<td>" . $row["Rating"] . "</td>";
        echo "<td>" . $row["Comments"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close the database connection
$connection->close();
?>
