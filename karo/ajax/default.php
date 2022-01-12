<?php
$conn = new mysqli("localhost","phpmyadmin","Damian#3","admin_rcp");

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
} 
session_start();
?>