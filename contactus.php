<?php
session_start();

// Connect to database (replace dbname, username, password with actual credentials)
require_once "databaseconnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
       
        
        // Prepare the SQL statement
        $sql = "INSERT INTO contactmessages (name, email, phone, message,created_at) VALUES (?, ?, ?, ?,?)";
        
        // Check if the connection is successful
        if ($connection) {
            // Prepare the statement
            if ($stmt = $connection->prepare($sql)) {
                // Bind parameters
                $stmt->bind_param("sssss", $name, $email, $phone, $message,$created_at);
                
                // Execute the statement
                if ($stmt->execute()) {
                    echo "Record added successfully.";
                } else {
                    // Capture and display execution error
                    echo "Error adding record: " . $stmt->error;
                }
                
                // Close the statement
                $stmt->close();
            } else {
                // Capture and display statement preparation error
                echo "Error preparing statement: " . $connection->error;
            }
        } else {
            // Capture and display connection error
            echo "Error connecting to the database: " . $connection->connect_error;
        }
    }
}
?>