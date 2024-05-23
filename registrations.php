
<?php
require_once "databaseconnection.php";
//nsengiyumva edouard 222001639 on 18th May 2024
$sql = "SELECT * FROM registrations";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<title>The Information of registrations</title>";
    echo "<h1>The Information of registrations</h1>";
    echo "<table border='1'>
            <tr>
                <th>RegistrationID</th>
                <th>UserID</th>
                <th>WorkshopID</th>
                <th>PaymentStatus</th>
                <th>PaymentMethod</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["RegistrationID"] . "</td>";
        echo "<td>" . $row["UserID"] . "</td>";
        echo "<td>" . $row["WorkshopID"] . "</td>";
        echo "<td>" . $row["PaymentStatus"] . "</td>";
        echo "<td>" . $row["PaymentMethod"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$connection->close();
?>
