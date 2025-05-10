<?php 
// DB credentials.
$localhost = "localhost";
$username = "garageuser";
$password = "W5y00t0x?";
$dbname = "solution_garagedb";
//$store_url = "http://localhost/phpinventory/";
// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}
?>





