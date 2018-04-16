<?php
$servername = "localhost";
$username = "AccessLSGSD";
$password = "7567rghf";
$database = "LSGSD"; 

$mysqli = mysqli_connect($servername, $username, $password, $database);

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>