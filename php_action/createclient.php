<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
extract($_POST);
                $name = $_POST['name']; 
                $reffering = $_POST['reffering']; 
                $address = $_POST['address']; 
                $gender = $_POST['gender']; 
				$mob_no = $_POST['mob_no']; 
				$vehicleName = $_POST['vname'];
                $vehicleType = $_POST['vtype'];




 	
				$sql = "INSERT INTO `tbl_client`(`name`, `mob_no`, `reffering`, `address`, `gender`, `vehicle_type`, `vehicle_name`, `delete_status`)VALUES ('$name', '$mob_no', '$reffering', '$address','$gender','$vehicleType', '$vehicleName',0)";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";
					header('location:../client.php');	
				} 
				else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
					header('location:../client.php');
				}

			// /else	
		// if
	// if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST