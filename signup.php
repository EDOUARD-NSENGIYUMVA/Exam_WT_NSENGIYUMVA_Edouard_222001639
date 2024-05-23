<?php
// Start session
session_start();
require_once "databaseconnection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = $_POST['Email'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $registrationDate = $_POST['RegistrationDate'];

    // Prepare SQL query with prepared statements
    $sql = "INSERT INTO users (Email, Username, Password, RegistrationDate) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    
    // Bind parameters and execute the statement
    $stmt->bind_param("ssss", $email, $username, $password, $registrationDate);
    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.html");
        exit(); // Terminate script execution after redirection
    } else {
        // Handle errors by capturing the error message
        echo "Error: " . $stmt->error;
    }
} else {
    // Inform the user that the form is not submitted
    echo "Form not submitted.";
}
?>
