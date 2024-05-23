<?php
session_start();
// Nsengiyumva Edouard 222001639 on 20th May 2024
// Connect to database (replace dbname, username, password with actual credentials)
require_once "databaseconnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $WorkshopID = $_POST['WorkshopID'];
    $WorkshopName = $_POST['WorkshopName'];
    $DateTime = $_POST['DateTime'];
    $InstructorID = $_POST['InstructorID'];
    $MaxParticipants = $_POST['MaxParticipants'];
    $sql = "INSERT INTO Workshops (WorkshopID, WorkshopName, DateTime, InstructorID, MaxParticipants) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $WorkshopID, $WorkshopName, $DateTime, $InstructorID, $MaxParticipants);

    if ($stmt->execute()) {
        echo "Record added successfully.";
    } else {
        echo "Error adding record: " . $stmt->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['WorkshopID'];
    $newWorkshopID = $_POST['newWorkshopID'];
    $newWorkshopName = $_POST['newWorkshopName'];
    $newDateTime = $_POST['newDateTime'];
    $newInstructorID = $_POST['newInstructorID'];
    $newMaxParticipants = $_POST['newMaxParticipants'];
    $sql = "UPDATE Workshops SET WorkshopID=?, WorkshopName=?, DateTime=?, InstructorID=?, MaxParticipants=? WHERE WorkshopID=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssi", $newWorkshopID, $newWorkshopName, $newDateTime, $newInstructorID, $newMaxParticipants, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['WorkshopID'];
    $sql = "DELETE FROM Workshops WHERE WorkshopID=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['read'])) {
    $id = $_POST['WorkshopID'];
    $sql = "SELECT * FROM Workshops WHERE WorkshopID=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch and display department information
        $row = $result->fetch_assoc();
        echo "WorkshopID: " . $row["WorkshopID"] . "<br>";
        echo "WorkshopName: " . $row["WorkshopName"] . "<br>";
        echo "DateTime: " . $row["DateTime"] . "<br>";
        echo "InstructorID: " . $row["InstructorID"] . "<br>";
        echo "MaxParticipants: " . $row["MaxParticipants"] . "<br>";
    } else {
        echo "No workshop found with the provided ID.";
    }
}
?>
