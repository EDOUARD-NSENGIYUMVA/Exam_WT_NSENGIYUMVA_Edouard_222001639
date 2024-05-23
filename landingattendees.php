<?php
require_once "databaseconnection.php";
// Initialize an array to hold errors
$errors = [];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle create operation
    if (isset($_POST['create'])) {
        $UserID = $_POST['UserID'];
        $WorkshopID = $_POST['WorkshopID'];
        $RegistrationDate = $_POST['RegistrationDate'];

        $sql = "INSERT INTO Attendees ( UserID, WorkshopID, RegistrationDate) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $UserID, $WorkshopID, $RegistrationDate);

        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
        $stmt->close();

    // Handle update operation
    } elseif (isset($_POST['update'])) {
        $AttendeeID = $_POST['AttendeeID'];
        $newUserID = $_POST['newUserID'];
        $newWorkshopID = $_POST['newWorkshopID'];
        $newRegistrationDate = $_POST['newRegistrationDate'];

        $sql = "UPDATE Attendees SET UserID=?, WorkshopID=?, RegistrationDate=? WHERE AttendeeID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssi", $newUserID, $newWorkshopID, $newRegistrationDate, $AttendeeID);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
        $stmt->close();

    // Handle delete operation
    } elseif (isset($_POST['delete'])) {
        $AttendeeID = $_POST['AttendeeID'];

        $sql = "DELETE FROM Attendees WHERE AttendeeID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $AttendeeID);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
        $stmt->close();

    // Handle read operation
    } elseif (isset($_POST['read'])) {
        $AttendeeID = $_POST['AttendeeID'];

        $sql = "SELECT * FROM Attendees WHERE AttendeeID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $AttendeeID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "AttendeeID: " . $row["AttendeeID"] . "<br>";
            echo "UserID: " . $row["UserID"] . "<br>";
            echo "WorkshopID: " . $row["WorkshopID"] . "<br>";
            echo "RegistrationDate: " . $row["RegistrationDate"] . "<br>";
        } else {
            $errors[] = "No record found with the provided ID.";
        }
        $stmt->close();
    } else {
        $errors[] = "Invalid action.";
    }
} else {
    $errors[] = "Invalid request method.";
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

// Close the database connection
$connection->close();
?>
