<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$userName 		= $_POST['userName'];
  $upassword 			= md5($_POST['upassword']);
  $uemail 			= $_POST['uemail'];
  $isAdmin 			= $_POST['isAdmin'];

	
				$sql = "INSERT INTO users (username, password,email, admin) 
				VALUES ('$userName', '$upassword' , '$uemail', $isAdmin)";
				//echo $sql;exit;
				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";	
					header('location:fetchUser.php');
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

				// /else	
		
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
