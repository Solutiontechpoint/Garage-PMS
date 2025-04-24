<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/connect.php'); 

$user = $_SESSION['userId'];

$sql = "SELECT job_card_id, datetime_in, customer_name, client_contact, payment_status 
        FROM job_card 
        WHERE job_status = 1 AND user_id = '$user'";
$result = $connect->query($sql);
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">View Job Cards</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Job Cards</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="add-jobcard.php"><button class="btn btn-primary">Add Job Card</button></a>

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date/Time In</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Total Items</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row) {
                                $jobCardId = $row['job_card_id'];
                                $itemCountSql = "SELECT COUNT(*) as total FROM job_card_item WHERE job_card_id = '$jobCardId' AND job_card_item_status = 1";
                                $itemResult = $connect->query($itemCountSql);
                                $itemRow = $itemResult->fetch_assoc();
                                $totalItems = $itemRow['total'];

                                $sql="SELECT * from tbl_client where id='".$row['customer_name']."'";
                                $result1 = $connect->query($sql);
                                $row1=$result1->fetch_assoc();

                                if ($row['payment_status'] == 1) {
                                    $paymentStatus = "<label class='label label-success'><h4>Full Payment</h4></label>";
                                } else if ($row['payment_status'] == 2) {
                                    $paymentStatus = "<label class='label label-info'><h4>Advance Payment</h4></label>";
                                } else {
                                    $paymentStatus = "<label class='label label-warning'><h4>No Payment</h4></label>";
                                }
                            ?>
                            <tr>
                                <td><?php echo $row['job_card_id']; ?></td>
                                <td><?php echo $row['datetime_in']; ?></td>
                                <td><?php echo $row1['name']; ?></td>
                                <td><?php echo $row['client_contact']; ?></td>
                                <td><?php echo $totalItems; ?></td>
                                <td><?php echo $paymentStatus; ?></td>
                                <td>
                                    <a href="editJobcard.php?id=<?php echo $row['job_card_id']; ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>
                                    <a href="printJobCard.php?id=<?php echo $row['job_card_id']; ?>"><button type="button" class="btn btn-xs btn-info"><i class="fa fa-print"></i></button></a>
                                    <a href="php_action/removeJobcard.php?id=<?php echo $row['job_card_id']; ?>" onclick="return confirm('Are you sure to delete this job card?')"><button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>
