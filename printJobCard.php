<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/connect.php'); ?>

<?php
$jobCardSql = "SELECT * FROM job_card WHERE job_card_id = ?";
$stmt = $connect->prepare($jobCardSql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$jobCard = $stmt->get_result()->fetch_assoc();

$clientSql = "SELECT * FROM tbl_client WHERE id = ?";
$stmt2 = $connect->prepare($clientSql);
$stmt2->bind_param("i", $jobCard['customer_name']);
$stmt2->execute();
$data1 = $stmt2->get_result()->fetch_assoc();

$web = $connect->query("SELECT * FROM manage_website")->fetch_assoc();
?>

<!-- Stylish CSS Start -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fa;
    color: #343a40;
    margin: 20px;
}

.card {
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

h2, h4, h5 {
    font-weight: 600;
    color: #212529;
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

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

thead.thead-dark th {
    background-color: #343a40;
    color: #fff;
    font-weight: 600;
}

.btn {
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

.card-footer {
    background: none;
    border-top: 1px solid #dee2e6;
    margin-top: 20px;
}

@media print {
    .btn, .card-footer {
        display: none;
    }
}
</style>
<!-- Stylish CSS End -->

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Job Card #<?= $jobCard['job_card_no'] ?></h2>
                    <small class="text-muted">Date In: <?= date('d-m-Y H:i', strtotime($jobCard['datetime_in'])) ?></small>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4">
                        <img class="img-fluid" src="./assets/uploadImage/Logo/logo.jpg" style="height:100px;">
                    </div>
                    <div class="col-sm-4">
                        <h5>From:</h5>
                        <h4>Detailing Commando</h4>
                        <div>Email: <?= $web['currency_code'] ?></div>
                        <div>Contact: <?= $web['short_title'] ?></div>
                    </div>
                    <div class="col-sm-4">
                        <h5>To:</h5>
                        <h4><?= $data1['name']; ?></h4>
                        <div><?= $data1['address']; ?></div>
                        <div>Phone: <?= $data1['mob_no']; ?></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Vehicle Details</h5>
                        <p>Type: <?= $jobCard['vehicle_type'] ?></p>
                        <p>Vehicle Number: <?= $jobCard['vehicle_name'] ?></p>
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Service/Product</th>
                                <th class="text-end">Rate</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $itemsSql = "SELECT * FROM job_card_item WHERE job_card_id = ?";
                            $stmt3 = $connect->prepare($itemsSql);
                            $stmt3->bind_param("i", $_GET['id']);
                            $stmt3->execute();
                            $itemsData = $stmt3->get_result();
                            $no = 0;
                            while ($item = $itemsData->fetch_assoc()) {
                                $product = $connect->query("SELECT * FROM product WHERE product_id='" . $item['product_id'] . "'")->fetch_assoc();
                                $no++;
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $product['product_name'] ?></td>
                                    <td class="text-end"><?= $item['rate'] ?></td>
                                    <td class="text-center"><?= $item['quantity'] ?></td>
                                    <td class="text-end"><?= $item['total'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6">
                        <img src="./assets/uploadImage/Logo/rubber_stamp.png" style="height:200px;">
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-borderless">
                            <tr><td><strong>Subtotal</strong></td><td class="text-end"><?= $jobCard['sub_total'] ?></td></tr>
                            <tr><td><strong>Discount</strong></td><td class="text-end"><?= $jobCard['discount'] ?></td></tr>
                            <tr><td><strong>VAT</strong></td><td class="text-end"><?= $jobCard['vat'] ?></td></tr>
                            <tr><td><strong>Grand Total</strong></td><td class="text-end"><strong><?= $jobCard['grand_total'] ?></strong></td></tr>
                            <tr><td><strong>Paid</strong></td><td class="text-end"><?= $jobCard['paid'] ?></td></tr>
                            <tr><td><strong>Due</strong></td><td class="text-end"><?= $jobCard['due'] ?></td></tr>
                            <tr>
                                <td><strong>Payment Type</strong></td>
                                <td class="text-end">
                                    <?php 
                                    switch($jobCard['payment_type']) {
                                        case 1: echo 'Cash'; break;
                                        case 2: echo 'Card'; break;
                                        default: echo 'Other'; break;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr><td><strong>Payment Status</strong></td><td class="text-end"><?= $jobCard['payment_status'] == 1 ? 'Paid' : 'Pending' ?></td></tr>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <p>Thank you for choosing Detailing Commando!</p>
                    <small>Software by Solution Tech Services - solutiontechservices.com</small>
                </div>

                <div class="text-end mt-4">
                    <input type="button" class="btn btn-success me-2" value="Print Job Card" onclick="window.print();">
                    <a href="javascript:history.back();" class="btn btn-danger">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>
