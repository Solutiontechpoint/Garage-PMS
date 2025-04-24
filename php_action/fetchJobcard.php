<?php

require_once 'core.php';

$sql = "SELECT job_card_id, datetime_in, customer_name, client_contact, payment_status FROM job_card WHERE job_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if ($result->num_rows > 0) {
    $paymentStatus = "";
    $x = 1;

    while ($row = $result->fetch_array()) {
        $jobCardId = $row[0];

        // Count items
        $countItemSql = "SELECT COUNT(*) FROM job_card_item WHERE job_card_id = $jobCardId AND job_card_item_status = 0";
        $itemCountResult = $connect->query($countItemSql);
        $itemCountRow = $itemCountResult->fetch_row();

        // Payment status
        if ($row[4] == 1) {
            $paymentStatus = "<label class='label label-success'>Full Payment</label>";
        } else if ($row[4] == 2) {
            $paymentStatus = "<label class='label label-info'>Advance Payment</label>";
        } else {
            $paymentStatus = "<label class='label label-warning'>No Payment</label>";
        }

        $button = '
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="jobcards.php?j=editJobcard&i=' . $jobCardId . '" id="editJobcardModalBtn"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                <li><a type="button" onclick="printJobcard(' . $jobCardId . ')"><i class="glyphicon glyphicon-print"></i> Print</a></li>
                <li><a type="button" data-toggle="modal" data-target="#removeJobcardModal" id="removeJobcardModalBtn" onclick="removeJobcard(' . $jobCardId . ')"><i class="glyphicon glyphicon-trash"></i> Remove</a></li>
            </ul>
        </div>';

        $output['data'][] = array(
            $x,
            $row[1],             // datetime_in
            $row[2],             // customer_name
            $row[3],             // client_contact
            $itemCountRow[0],    // item count
            $paymentStatus,
            $button
        );
        $x++;
    }
}
header('location:../jobcard.php');
$connect->close();

echo json_encode($output);
?>
