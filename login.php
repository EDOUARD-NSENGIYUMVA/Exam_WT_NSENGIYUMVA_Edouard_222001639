<?php
// Connect to database (replace dbname, username, password with actual credentials)
require_once "databaseconnection.php";
//nsengiyumv edouard 222001639 on 20th May 2024

$uname = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT *FROM users WHERE username='$uname' AND password='$password'";
$result =$connection->query($sql);
if ($result->num_rows >0) {
  // echo "successfully loggedin!";
  header("Location: Dashboard.html");
      exit();
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

$connection->close();
?>
