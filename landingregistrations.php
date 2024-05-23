<?php
session_start();

require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $UserID = $_POST['UserID'];
        $WorkshopID = $_POST['WorkshopID'];
        $PaymentStatus = $_POST['PaymentStatus'];
       
        // Prepare and execute the insert query
        $sql = "INSERT INTO registrations (UserID,WorkshopID,PaymentStatus,PaymentMethod) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $UserID, $WorkshopID, $PaymentStatus, $PaymentMethod);
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including RegistrationID
        // Define $id here
        $newUserID = $_POST['newUserID'];
        $newWorkshopID = $_POST['newWorkshopID'];
        $newPaymentStatus = $_POST['newPaymentStatus'];
        $newPaymentMethod = $_POST['newPaymentMethod'];

        // Prepare and execute the update query
        $sql = "UPDATE registrations SET UserID=?,WorkshopID=?, PaymentStatus=?, PaymentMethod=? WHERE RegistrationID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $newUserID, $newWorkshopID, $newPaymentStatus, $newPaymentMethod, $id); // Bind $id here

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve RegistrationID from form data
        // Define $id here

        // Prepare and execute the delete query
        $sql = "DELETE FROM registrations WHERE RegistrationID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
    } elseif (isset($_POST['read'])) {
        // Retrieve RegistrationID from form data
        $id = $_POST['RegistrationID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM registrations WHERE RegistrationID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "UserID: " . $row["UserID"] . "<br>";
            echo "WorkshopID: " . $row["WorkshopID"] . "<br>";
            echo "PaymentStatus: " . $row["PaymentStatus"] . "<br>";
            echo "PaymentMethod: " . $row["PaymentMethod"] . "<br>";
        } else {
            $errors[] = "No registrations found with the provided ID.";
        }
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
