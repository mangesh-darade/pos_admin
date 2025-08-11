<?php
 
global $conn;
  
 
define('DATABASE_NAME', 'sitadmin_simplysafe');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', '');
 

$conn = new mysqli("localhost", DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
 
 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  


define('CP_HOST', HOSTNAME);


 
?>