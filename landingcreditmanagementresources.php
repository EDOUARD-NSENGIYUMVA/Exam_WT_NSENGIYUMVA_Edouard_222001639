<?php
session_start();

require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $ResourceName = $_POST['ResourceName'];
        $Description = $_POST['Description'];
        $Link = $_POST['Link'];
        
        // Prepare and execute the insert query
        $sql = "INSERT INTO creditmanagementresources (ResourceName, Description, Link) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $ResourceName, $Description, $Link);
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including ResourceID
        $id = $_POST['ResourceID'];
        $newResourceName = $_POST['newResourceName'];
        $newDescription = $_POST['newDescription'];
        $newLink = $_POST['NewLink'];

        // Prepare and execute the update query
        $sql = "UPDATE creditmanagementresources SET ResourceName=?, Description=?, Link=? WHERE ResourceID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssi", $newResourceName, $newDescription, $newLink, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve ResourceID from form data
        $id = $_POST['ResourceID'];

        // Prepare and execute the delete query
        $sql = "DELETE FROM creditmanagementresources WHERE ResourceID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
    } elseif (isset($_POST['read'])) {
        // Retrieve ResourceID from form data
        $id = $_POST['ResourceID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM creditmanagementresources WHERE ResourceID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "ResourceID: " . $row["ResourceID"] . "<br>";
            echo "ResourceName: " . $row["ResourceName"] . "<br>";
            echo "Description: " . $row["Description"] . "<br>";
            echo "Link: " . $row["Link"] . "<br>";
        } else {
            $errors[] = "No credit management resources found with the provided ID.";
        }
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
