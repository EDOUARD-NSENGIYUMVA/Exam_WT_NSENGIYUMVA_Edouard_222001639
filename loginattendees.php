<?php
session_start();

// Connect to database (replace dbname, username, password with actual credentials)
require_once "databaseconnection.php";
//Nsengiyumva Edouard 222001639 on 9th May2024
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $website= $_POST['website'];
    $contact = $_POST['contact'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM attendees WHERE website=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $website);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (contact_verify($contact, $row['contact'])) {
            $_SESSION['website'] = $row['website']; // Set the website session variable
            header("Location: landingattendees.php");
            exit();
        } else {
            echo "Invalid contact and website.";
        }
    } else {
        echo "Website not found.";
    }
}

$connection->close();

function contact_verify($contact, $storedcontact) {
    // Implement your contact verification logic here
    // For simplicity, this function currently compares plain text contacts
    return $contact === $storedcontact;
}
?>
