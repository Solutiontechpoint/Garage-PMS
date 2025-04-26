<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

//$orderId = $_POST['orderId'];
$jobCardId= $_GET['id'];
if($jobCardId) { 

 $sql = "UPDATE job_card SET job_status = 2 WHERE job_card_id = {$jobCardId}";

 $jobcardItem = "UPDATE job_card_item SET job_card_item_status = 2 WHERE  job_card_id = {$jobCardId}";

 if($connect->query($sql) === TRUE && $connect->query($jobcardItem) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";
	header('location:../jobcard.php');		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST