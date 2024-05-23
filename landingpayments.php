<?php
session_start();

require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $UserID = $_POST['UserID'];
        $WorkshopID = $_POST['WorkshopID'];
        $Amount = $_POST['Amount'];
         $PaymentStatus = $_POST['PaymentStatus'];
         // Prepare and execute the insert query
        $sql = "INSERT INTO payments ( UserID, WorkshopID, Amount,PaymentStatus) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
       $stmt->bind_param("ssss", $UserID, $WorkshopID, $Amount, $PaymentStatus); 
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including PaymentID 
     // Define $id here
        $id=$_POST['PaymentID'];
        $newUserID = $_POST['newUserID'];
        $newWorkshopID = $_POST['newWorkshopID'];
        $newAmount = $_POST['newAmount'];
        $newPaymentStatus = $_POST['newPaymentStatus'];

        // Prepare and execute the update query
        $sql = "UPDATE payments SET UserID=?, WorkshopID=?, Amount=?, PaymentStatus=? WHERE PaymentID =?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $newUserID, $newWorkshopID, $newAmount, $newPaymentStatus, $id); // Bind $id here

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve PaymentID  from form data
       // Define $id here

        // Prepare and execute the delete query
        $sql = "DELETE FROM payments WHERE PaymentID =?";
        $id=$_POST['PaymentID'];
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
    } elseif (isset($_POST['read'])) {
        // Retrieve PaymentID  from form data
         $id=$_POST['PaymentID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM payments WHERE PaymentID =?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "PaymentID:".$row["PaymentID"]."<br>";
            echo "UserID: " . $row["UserID"] . "<br>";
            echo "WorkshopID: " . $row["WorkshopID"] . "<br>";
            echo "Amount: " . $row["Amount"] . "<br>";
            echo "PaymentStatus: " . $row["PaymentStatus"] . "<br>";
        } else {
            $errors[] = "No payments found with the provided ID.";
        }
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
