<?php
session_start();
require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
       $RegistrationDate = $_POST['RegistrationDate'];
       
        // Prepare and execute the insert query
        $sql = "INSERT INTO users (Username, Email, Password,RegistrationDate) VALUES (?, ?, ?,?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $Username, $Email, $Password,$RegistrationDate);
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including UserID
        $id=$_POST['UserID'];
        $newUsername = $_POST['newUsername'];
        $newEmail = $_POST['newEmail'];
        $newPassword = $_POST['newPassword'];
        $newRegistrationDate = $_POST['newRegistrationDate'];

        // Prepare and execute the update query
        $sql = "UPDATE users SET Username=?, Email=?, Password=?,RegistrationDate=? WHERE UserID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $newUsername, $newEmail, $newPassword,$newRegistrationDate,$id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Retrieve UserID from form data
        $id = $_POST['UserID'];

        // Prepare and execute the delete query
        $sql = "DELETE FROM users WHERE UserID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['read'])) {
        // Retrieve UserID from form data
        $id = $_POST['UserID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM users WHERE UserID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "UserID:".$row["UserID"]."<br>";
            echo "Username: " . $row["Username"] . "<br>";
            echo "Email: " . $row["Email"] . "<br>";
            echo "Password: " . $row["Password"] . "<br>";
        } else {
            $errors[] = "No instructor found with the provided ID.";
        }
        $stmt->close();
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
