<?php
$servername = "localhost";
$username = "Edouard";
$password = "Edouard@2024";
$dbname = "virtual_credit_management_workshops_platform";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
