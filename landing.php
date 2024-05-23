<?php
session_start();

// Connect to database (replace dbname, username, password with actual credentials)
require_once "databaseconnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact = $_POST['contact'];

    $sql = "INSERT INTO admin (email, username, password, contact) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssss", $email, $username, $password, $contact);

    if ($stmt->execute()) {
        echo "Record added successfully.";
    } else {
        echo "Error adding record: " . $stmt->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['user_id'];
    $newemail = $_POST['newemail'];
    $newusername = $_POST['newusername'];
    $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
    $newContact = $_POST['newContact'];

    $sql = "UPDATE admin SET email=?, username=?, password=?, contact=? WHERE user_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssi", $newemail, $newusername, $newpassword, $newContact, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['user_id'];

    $sql = "DELETE FROM admin WHERE user_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['read'])) {
    $id = $_POST['user_id'];

    $sql = "SELECT * FROM admin WHERE user_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "User_id: " . $row["user_id"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
        echo "Username: " . $row["username"] . "<br>";
        echo "Contact: " . $row["contact"] . "<br>";
    } else {
        echo "No user found with the provided ID.";
    }
}

// Close the database connection
$connection->close();
?>
