<?php
require_once "databaseconnection.php";
//222001639 Nsengiyumva edouard  
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $UserID = $_POST['UserID'];
  $WorkshopID = $_POST['WorkshopID'];
  $RegistrationDate = $_POST['RegistrationDate'];
  $sql ="INSERT INTO Attendees (UserID,WorkshopID,RegistrationDate) VALUES ('$UserID','$WorkshopID','$RegistrationDate')";
  if($connection->query($sql)==TRUE){
    echo "Registration successiful!";
      header("UserID:loginattendees.html");
      exit();
  }else{
    echo "Error: ".$sql."<br>" .$connection->error;
  }
}$connection->close();
 ?>
