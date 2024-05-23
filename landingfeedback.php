<?php
session_start();
require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $UserID = $_POST['UserID'];
        $WorkshopID = $_POST['WorkshopID'];
        $Rating = $_POST['Rating'];
        $Comments = $_POST['Comments'];

        // Prepare and execute the insert query
        $sql = "INSERT INTO feedback (UserID, WorkshopID, Rating, Comments) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $UserID, $WorkshopID, $Rating, $Comments);

          if ($stmt->execute()) {
            echo "Record added successfully.";
           
            exit(); // Ensure no further code execution after redirection
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including feedbackID
        $id = $_POST['FeedbackID'];
        $newUserID = $_POST['newUserID'];
        $newWorkshopID = $_POST['newWorkshopID'];
        $newRating = $_POST['newRating'];
        $newComments = $_POST['newComments'];

        // Prepare and execute the update query
        $sql = "UPDATE feedback SET UserID=?, WorkshopID=?, Rating=?, Comments=? WHERE feedbackID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $newUserID, $newWorkshopID, $newRating, $newComments, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve feedbackID from form data
        $id = $_POST['FeedbackID'];

        // Prepare and execute the delete query
        $sql = "DELETE FROM feedback WHERE FeedbackID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
    } elseif (isset($_POST['read'])) {
        // Retrieve feedbackID from form data
        $id = $_POST['FeedbackID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM feedback WHERE feedbackID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "UserID: " . $row["UserID"] . "<br>";
            echo "WorkshopID: " . $row["WorkshopID"] . "<br>";
            echo "Rating: " . $row["Rating"] . "<br>";
            echo "Comments: " . $row["Comments"] . "<br>";
        } else {
            $errors[] = "No feedback found with the provided ID.";
        }
    }
}

// Output errors if any
foreach ($errors as $error) {
    echo $error . "<br>";
}

$connection->close();
?>
