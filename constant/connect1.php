<?php
/* Local Database*/

$servername = "localhost";
$username = "garageuser";
$password = "W5y00t0x?";
$dbname = "garagedb";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?> 