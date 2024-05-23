<?php
session_start();

// Unset all of the session variables
$_SESSION = array();
//Nsengiyumva Edouard 222001839 on 16th May 2024
// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: index.html");
exit();
?>
