
<?php
require_once "databaseconnection.php";
//nsengiyumva edouard 222001639 on 18th May 2024
$sql = "SELECT * FROM Messages";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<title>The Information of Message</title>";
    echo "<h1>The Information of Messages</h1>";
    echo "<table border='1'>
            <tr>
                <th>MessageID</th>
                <th>SenderID</th>
                <th>ReceiverID</th>
                <th>MessageText</th>
                <th>SendDateTime</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["MessageID"] . "</td>";
        echo "<td>" . $row["SenderID"] . "</td>";
        echo "<td>" . $row["ReceiverID"] . "</td>";
        echo "<td>" . $row["MessageText"] . "</td>";
        echo "<td>" . $row["SendDateTime"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$connection->close();
?>
