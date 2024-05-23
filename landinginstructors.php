<?php
session_start();

require_once "databaseconnection.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create'])) {
        // Retrieve form data
        $FullName = $_POST['FullName'];
        $Bio = $_POST['Bio'];
        $ContactInformation = $_POST['ContactInformation'];
        $ProfilePicture = $_POST['ProfilePicture'];
       
        // Prepare and execute the insert query
        $sql = "INSERT INTO instructors (FullName, Bio, ContactInformation, ProfilePicture) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $FullName, $Bio, $ContactInformation, $ProfilePicture);
        
        if ($stmt->execute()) {
            echo "Record added successfully.";
        } else {
            $errors[] = "Error adding record: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Retrieve form data including instructorID
        
        $newFullName = $_POST['newFullName'];
        $newBio = $_POST['newBio'];
        $newContactInformation = $_POST['newContactInformation'];
        $newProfilePicture = $_POST['newProfilePicture'];

        // Prepare and execute the update query
        $sql = "UPDATE instructors SET FullName=?, Bio=?, ContactInformation=?, ProfilePicture=? WHERE instructorID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $newFullName, $newBio, $newContactInformation, $newProfilePicture, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            $errors[] = "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Retrieve instructorID from form data
        $id = $_POST['InstructorID'];

        // Prepare and execute the delete query
        $sql = "DELETE FROM instructors WHERE InstructorID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['read'])) {
        // Retrieve instructorID from form data
        $id = $_POST['InstructorID'];

        // Prepare and execute the select query
        $sql = "SELECT * FROM instructors WHERE InstructorID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "FullName: " . $row["FullName"] . "<br>";
            echo "Bio: " . $row["Bio"] . "<br>";
            echo "ContactInformation: " . $row["ContactInformation"] . "<br>";
            echo "ProfilePicture: " . $row["ProfilePicture"] . "<br>";
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
