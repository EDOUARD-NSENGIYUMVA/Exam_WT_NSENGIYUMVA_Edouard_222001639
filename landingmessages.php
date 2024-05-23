<?php
session_start();

require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $ReceiverID = $_POST['ReceiverID'];
        $MessageText = $_POST['MessageText'];
       
         // Prepare and execute the insert query
        $sql = "INSERT INTO Messages (SenderID, ReceiverID, MessageText, SendDateTime) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $SenderID, $ReceiverID, $MessageText, $SendDateTime);
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including MessageID
     // Define $id here
        $newReceiverID = $_POST['newReceiverID'];
        $newMessageText = $_POST['newMessageText'];
        $newSendDateTime = $_POST['newSendDateTime'];

        // Prepare and execute the update query
        $sql = "UPDATE Messages SET SenderID=?, ReceiverID=?, MessageText=?, SendDateTime=? WHERE MessageID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $newSenderID, $newReceiverID, $newMessageText, $newSendDateTime, $id); // Bind $id here

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve MessageID from form data
       // Define $id here

        // Prepare and execute the delete query
        $sql = "DELETE FROM Messages WHERE MessageID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
    } elseif (isset($_POST['read'])) {
        // Retrieve MessageID from form data

        // Prepare and execute the select query
        $sql = "SELECT * FROM Messages WHERE MessageID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "SenderID: " . $row["SenderID"] . "<br>";
            echo "ReceiverID: " . $row["ReceiverID"] . "<br>";
            echo "MessageText: " . $row["MessageText"] . "<br>";
            echo "SendDateTime: " . $row["SendDateTime"] . "<br>";
        } else {
            $errors[] = "No Messages found with the provided ID.";
        }
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
