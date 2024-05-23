<?php
session_start();

require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $CategoryName = $_POST['CategoryName'];
        $Description = $_POST['Description'];
        // Prepare and execute the insert query
        $sql = "INSERT INTO Categories (CategoryName, Description) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $CategoryName, $Description);
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including CategoryID
        $id = $_POST['CategoryID']; // Define $id here
        $newCategoryID = $_POST['CategoryID'];
        $newCategoryName = $_POST['newCategoryName'];
        $newDescription = $_POST['newDescription'];
    

        // Prepare and execute the update query
        $sql = "UPDATE Categories SET CategoryName=?, Description=? WHERE CategoryID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssi",$newCategoryName, $newDescription, $id); // Bind $id here

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve CategoryID from form data
         // Define $id here

        // Prepare and execute the delete query
        $sql = "DELETE FROM Categories WHERE CategoryID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
    } elseif (isset($_POST['read'])) {
        // Retrieve CategoryID from form data
        $id = $_POST['CategoryID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM Categories WHERE CategoryID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "CategoryID: " . $row["CategoryID"] . "<br>";
            echo "CategoryName: " . $row["CategoryName"] . "<br>";
            echo "Description: " . $row["Description"] . "<br>";
        } else {
            $errors[] = "No Categories found with the provided ID.";
        }
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
