<?php
require_once 'core.php';

$valid = ['success' => false, 'messages' => []];

if ($_POST) {
  $jobCardId = $_POST['jobCardId']; // Assuming jobCardId is sent from the form

  // Basic info
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
  $userId = $_SESSION['userId']; // you can choose to update or keep it

  // Update the job_card table
  $sql = "UPDATE `job_card` SET 
            customer_name = '$customer',
            client_contact = '$clientContact',
            handled_by = '$mechanicName',
            booked_by = '$supervisorName',
            vehicle_type = '$vehicleType',
            vehicle_name = '$vehicleName',
            datetime_in = '$datetimeIn',
            datetime_out = '$datetimeOut',
            odometer_reading = '$odometer',
            fuel_level = '$fuelLevel',
            items_in_car = '$itemsInCar',
            pickup_drop = '$pickupDrop',
            pickup_person_name = '$pickupPerson',
            floor_mat = '$floorMat',
            cut_mat = '$cutMat',
            dents_scratches_map = '$dentsMap',
            sub_total = '$subTotal',
            vat = '$vat',
            total_amount = '$total',
            discount = '$discount',
            grand_total = '$grandTotal',
            paid = '$paid',
            due = '$due',
            payment_type = '$paymentType',
            payment_status = '$paymentStatus',
            payment_place = '$paymentPlace'
          WHERE job_card_id = $jobCardId";

  if ($connect->query($sql) === true) {
    // First, remove all existing job_card_item entries for this job card
    $connect->query("DELETE FROM job_card_item WHERE job_card_id = $jobCardId");

    // Now, re-insert the updated items
    for ($x = 0; $x < count($_POST['productName']); $x++) {
      $productId = $_POST['productName'][$x];
      $qty = $_POST['quantity'][$x];
      $rate = $_POST['rateValue'][$x];
      $total = $_POST['totalValue'][$x];

      $connect->query("INSERT INTO job_card_item (job_card_id, product_id, quantity, rate, total, job_card_item_status)
        VALUES ('$jobCardId', '$productId', '$qty', '$rate', '$total', 1)");
    }

    $valid['success'] = true;
    $valid['messages'] = "Job Card Updated Successfully";
  } else {
    $valid['messages'] = "Error while updating job card: " . $connect->error;
  }

  echo json_encode($valid);
  header('location:fetchJobcard.php');
  $connect->close();
}
?>
