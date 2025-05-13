<?php
require_once '../constant/connect.php';

if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Order_Report_{$startDate}_to_{$endDate}.xls");

    $sql = "SELECT * FROM orders WHERE order_date >= '$startDate' AND order_date <= '$endDate' AND order_status = 1";
    $query = $connect->query($sql);

    echo '
    <table border="1">
        <tr>
            <th>Bill No</th>
            <th>Bill Date</th>
            <th>Customer Party Name</th>
            <th>Contact Number</th>
            <th>GST No</th>
            <th>HSN</th>
            <th>Taxable Value</th>
            <th>Rate of Tax (%)</th>
            <th>CGST</th>
            <th>SGST</th>
            <th>IGST</th>
        </tr>';

    $totalTaxable = 0;
    $totalTax = 0;

    while ($result = $query->fetch_assoc()) {
        $sql1 = "SELECT * FROM tbl_client WHERE id = '".$result['client_name']."'";
        $result1 = $connect->query($sql1);
        $data1 = $result1->fetch_assoc();

        echo '<tr>
            <td>'.$result['order_id'].'</td>
            <td>'.$result['order_date'].'</td>
            <td>'.$data1['name'].'</td>
            <td>'.$data1['mob_no'].'</td>
            <td>'.$result['gst_no'].'</td>
            <td>'.$result['hsn'].'</td>
            <td>'.$result['total_amount'].'</td>
            <td>18%</td>
            <td>'.($result['vat']/2).'</td>
            <td>'.($result['vat']/2).'</td>
            <td>0</td>
        </tr>';

        $totalTaxable += $result['total_amount'];
        $totalTax += $result['vat'];
    }

    echo '<tr>
        <td colspan="6"><strong>Total</strong></td>
        <td><strong>'.$totalTaxable.'</strong></td>
        <td></td>
        <td colspan="3"><strong>'.$totalTax.'</strong></td>
    </tr>';

    echo '</table>';
}
?>
