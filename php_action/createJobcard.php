<?php 	
require_once 'core.php';

$valid = ['success' => false, 'messages' => [], 'job_card_id' => ''];

if ($_POST) {
  // Basic info
  $jobCardNo = 'JC' . time(); // auto-generated
  $customer = $_POST['clientName'];
  $clientContact = $_POST['clientContact'];
  $mechanicName = $_POST['mname'];
  $supervisorName = $_POST['sname'];
  $vehicleType = $_POST['vtype'];
  $vehicleName = $_POST['vname'];
  $datetimeIn = $_POST['orderDate'];
  $datetimeOut = $_POST['deliverydate'];
  $odometer = $_POST['odometer'];
  $fuelLevel = $_POST['fuel'];
  $itemsInCar = $_POST['items_in_car'];
  $pickupDrop = isset($_POST['pickup_drop']) ? 1 : 0;
  $pickupPerson = $_POST['pickup_person'];
  $floorMat = isset($_POST['floor_mat']) ? 1 : 0;
  $cutMat = isset($_POST['cut_mat']) ? 1 : 0;
  $dentsMap = $_POST['dents_map'];

  // Price and payment info
  $subTotal = $_POST['subTotalValue'];
  $vat = $_POST['vatValue'];
  $total = $_POST['totalAmountValue'];
  $discount = $_POST['discount'];
  $grandTotal = $_POST['grandTotalValue'];
  $paid = $_POST['paid'];
  $due = $_POST['dueValue'];
  $paymentType = $_POST['paymentType'];
  $paymentStatus = $_POST['paymentStatus'];
  $paymentPlace = $_POST['paymentPlace'];
  $userId = $_SESSION['userId'];

  $sql = "INSERT INTO `job_card` (job_card_no, customer_name, client_contact, handled_by, booked_by, vehicle_type, vehicle_name, datetime_in, datetime_out, odometer_reading, fuel_level, items_in_car, pickup_drop, pickup_person_name, floor_mat, cut_mat, dents_scratches_map, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_type, payment_status, payment_place, user_id, job_status)
  VALUES ('$jobCardNo', '$customer', '$clientContact', '$mechanicName', '$supervisorName', '$vehicleType', '$vehicleName', '$datetimeIn', '$datetimeOut', '$odometer', '$fuelLevel', '$itemsInCar', '$pickupDrop', '$pickupPerson', '$floorMat', '$cutMat', '$dentsMap', '$subTotal', '$vat', '$total', '$discount', '$grandTotal', '$paid', '$due', '$paymentType', '$paymentStatus', '$paymentPlace', '$userId', 1)";

  if ($connect->query($sql) === true) {
    $jobCardId = $connect->insert_id;
    $valid['job_card_id'] = $jobCardId;

    // Insert job card items
    for ($x = 0; $x < count($_POST['productName']); $x++) {
      $productId = $_POST['productName'][$x];
      $qty = $_POST['quantity'][$x];
      $rate = $_POST['rateValue'][$x];
      $total = $_POST['totalValue'][$x];

      // update product quantity
      $connect->query("UPDATE product SET quantity = quantity - $qty WHERE product_id = $productId");

      $connect->query("INSERT INTO job_card_item (job_card_id, product_id, quantity, rate, total, job_card_item_status)
        VALUES ('$jobCardId', '$productId', '$qty', '$rate', '$total', 1)");
    }

    $valid['success'] = true;
    $valid['messages'] = "Job Card Created Successfully";
  } else {
    $valid['messages'] = "Error: " . $connect->error;
  }
	
	echo json_encode($valid);
	header('location:fetchJobcard.php');	
  $connect->close();
}
?>
