<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/connect.php'); ?>

<?php
$jobCardSql = "SELECT * FROM job_card WHERE job_card_id = '" . $_GET['id'] . "'";
$jobCardData = $connect->query($jobCardSql);
$jobCard = $jobCardData->fetch_assoc();

$sql1 = "SELECT * FROM tbl_client  
WHERE id = '".$jobCard['customer_name']."'";

$result1 = $connect->query($sql1);
$data1 = $result1->fetch_assoc();
?>

<div class="container-fluid" style="background-color: #ffffff;">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title">
                    <div class="float-left">
                        <h2 class="mb-0" style="color: black;">Job Card #<?= $jobCard['job_card_no'] ?></h2>
                    </div>
                    <div class="float-right">
                        Date In: <?= $jobCard['datetime_in'] ?>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-4 mt-4">
                            <?php
                            $web = $connect->query("SELECT * FROM manage_website")->fetch_assoc();
                            ?>
                            <image class="profile-img" src="./assets/uploadImage/Logo/logo.jpg" style="height:100px;width:auto;">
                        </div>
                        <div class="col-sm-4">
                            <br>
                            <h5 class="mb-3" style="color: black;">From:</h5>
                            <h3 class="text-dark mb-1">Detailing Commando</h3>
                            <div>Email: <?= $web['currency_code'] ?></div>
                            <div>Contact: <?= $web['short_title'] ?></div>
                        </div>
                        <div class="col-sm-4">
                            <br>
                            <h5 class="mb-3" style="color: black;">To:</h5>
                            <h3 class="text-dark mb-1"><?= $data1['name']; ?></h3>                                            
                                            <div><?= $data1['address']; ?></div>

                                            <div>Phone: <?= $data1['mob_no']; ?></div>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Service/Product</th>
                                    <th class="right">Rate</th>
                                    <th class="center">Qty</th>
                                    <th class="right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $itemsSql = "SELECT * FROM job_card_item WHERE job_card_id = '" . $_GET['id'] . "'";
                                $itemsData = $connect->query($itemsSql);
                                $no = 0;
                                while ($item = $itemsData->fetch_assoc()) {
                                    $product = $connect->query("SELECT * FROM product WHERE product_id='" . $item['product_id'] . "'")->fetch_assoc();
                                    $no++;
                                ?>
                                    <tr>
                                        <td class="center"><?= $no ?></td>
                                        <td class="left strong"><?= $product['product_name'] ?></td>
                                        <td class="right"><?= $item['rate'] ?></td>
                                        <td class="center"><?= $item['quantity'] ?></td>
                                        <td class="right"><?= $item['total'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-5">
                            <img style="height: 250px; padding-left: 316px;" src="./assets/uploadImage/Logo/rubber_stamp.png">
                        </div>
                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                    <tr>
                                        <td class="left"><strong class="text-dark">Subtotal</strong></td>
                                        <td class="right"><?= $jobCard['sub_total'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong class="text-dark">Discount</strong></td>
                                        <td class="right"><?= $jobCard['discount'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong class="text-dark">VAT</strong></td>
                                        <td class="right"><?= $jobCard['vat'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong class="text-dark">Grand Total</strong></td>
                                        <td class="right"><strong class="text-dark"><?= $jobCard['grand_total'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong class="text-dark">Paid</strong></td>
                                        <td class="right"><?= $jobCard['paid'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong class="text-dark">Due</strong></td>
                                        <td class="right"><?= $jobCard['due'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <p class="mb-0">Thank you for choosing us!</p>
                </div>
                <br><br><br>
                <p style="text-align:right;">Software Developed by Solution Tech Services - solutiontechservices.com</p>
                <input type="button" class="btn btn-success btn-flat m-b-30 m-t-30" value="Print Job Card" onclick="window.print();">
                <input type="button" class="btn btn-danger btn-flat m-b-30 m-t-30" value="Go Back" onclick="goBack();">
            </div>
        </div>
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<?php include('./constant/layout/footer.php'); ?>
