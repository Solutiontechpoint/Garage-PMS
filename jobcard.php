<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/connect.php'); 

$user = $_SESSION['userId'];

$sql = "SELECT job_card_id, datetime_in, customer_name, client_contact, vehicle_type, vehicle_name, payment_status 
        FROM job_card 
        WHERE job_status = 1 AND user_id = '$user'";
$result = $connect->query($sql);
?>

<!-- Stylish CSS Start -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fa;
    color: #343a40;
}

.page-wrapper {
    padding: 20px;
}

.card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

h3.text-primary {
    font-weight: 700;
    color: #007bff;
}

.table {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.table th, .table td {
    vertical-align: middle;
    padding: 15px;
}

thead th {
    background-color: #343a40;
    color: #fff;
}

.btn {
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
}

.label-success, .label-info, .label-warning {
    font-size: 13px;
    padding: 6px 12px;
    border-radius: 5px;
    display: inline-block;
}

.label-success { background-color: #28a745; color: #fff; }
.label-info { background-color: #17a2b8; color: #fff; }
.label-warning { background-color: #ffc107; color: #212529; }

.table-responsive {
    margin-top: 20px;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .btn {
        margin-bottom: 5px;
    }
}
</style>
<!-- Stylish CSS End -->

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-6">
            <h3 class="text-primary">View Job Cards</h3> 
        </div>
        <div class="col-md-6 text-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Job Cards</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="add-jobcard.php" class="btn btn-primary mb-4">Add New Job Card</a>

                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date/Time In</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Vehicle</th>
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

                                $clientQuery = "SELECT name FROM tbl_client WHERE id='" . $row['customer_name'] . "'";
                                $clientResult = $connect->query($clientQuery);
                                $clientData = $clientResult->fetch_assoc();

                                // Payment status badges
                                if ($row['payment_status'] == 1) {
                                    $paymentStatus = "<span class='label label-success'>Full Payment</span>";
                                } elseif ($row['payment_status'] == 2) {
                                    $paymentStatus = "<span class='label label-info'>Advance Payment</span>";
                                } else {
                                    $paymentStatus = "<span class='label label-warning'>No Payment</span>";
                                }
                            ?>
                            <tr>
                                <td><?= $row['job_card_id']; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['datetime_in'])); ?></td>
                                <td><?= $clientData['name']; ?></td>
                                <td><?= $row['client_contact']; ?></td>
                                <td><?= $row['vehicle_type'] . ' - ' . $row['vehicle_name']; ?></td>
                                <td><?= $totalItems; ?></td>
                                <td><?= $paymentStatus; ?></td>
                                <td class="text-center">
                                    <a href="editJobcard.php?id=<?= $row['job_card_id']; ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="printJobCard.php?id=<?= $row['job_card_id']; ?>" class="btn btn-info btn-sm" title="Print"><i class="fa fa-print"></i></a>
                                    <a href="php_action/removeJobcard.php?id=<?= $row['job_card_id']; ?>" onclick="return confirm('Are you sure to delete this job card?')" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
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
