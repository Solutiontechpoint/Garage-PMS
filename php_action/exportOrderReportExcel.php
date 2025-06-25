<?php
require_once '../constant/connect.php';

if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Combined_Report_{$startDate}_to_{$endDate}.xls");

    echo '<table border="1">
        <tr>
            <th>Bill No</th>
            <th>Date</th>
            <th>Customer Name</th>
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

    // ====== ORDERS ======
    $orderQuery = $connect->query("SELECT * FROM orders WHERE order_date >= '$startDate' AND order_date <= '$endDate' AND order_status = 1");

    while ($result = $orderQuery->fetch_assoc()) {
        $clientQuery = $connect->query("SELECT * FROM tbl_client WHERE id = '".$result['client_name']."'");
        $clientData = $clientQuery->fetch_assoc();

        $vat = floatval($result['vat']);
        $total_amount = floatval($result['total_amount']);

        echo '<tr>
            <td>'.$result['order_id'].'</td>
            <td>'.$result['order_date'].'</td>
            <td>'.$clientData['name'].'</td>
            <td>'.$clientData['mob_no'].'</td>
            <td>'.$result['gst_no'].'</td>
            <td>'.$result['hsn'].'</td>
            <td>'.$total_amount.'</td>
            <td>18%</td>
            <td>'.($vat / 2).'</td>
            <td>'.($vat / 2).'</td>
            <td>0</td>
        </tr>';

        $totalTaxable += $total_amount;
        $totalTax += $vat;
    }

    // ====== JOB CARDS ======
    $jobCardQuery = $connect->query("SELECT * FROM job_card WHERE DATE(datetime_in) >= '$startDate' AND DATE(datetime_in) <= '$endDate' AND job_status = 1");

    while ($row = $jobCardQuery->fetch_assoc()) {
      
        $clientQuery = $connect->query("SELECT * FROM tbl_client WHERE id = '".$row['customer_name']."'");
        $clientData = $clientQuery->fetch_assoc();

        $vat = floatval($row['vat']);
        $total_amount = floatval($row['total_amount']);

        echo '<tr>
            <td>'.$row['job_card_id'].'</td>
            <td>'.substr($row['datetime_in'], 0, 10).'</td>
            <td>'.$clientData['name'].'</td>
            <td>'.$clientData['mob_no'].'</td>
            <td></td>
            <td>'.$row['service_type'].'</td>
            <td>'.$total_amount.'</td>
            <td>18%</td>
            <td>'.($vat / 2).'</td>
            <td>'.($vat / 2).'</td>
            <td>0</td>
        </tr>';

        $totalTaxable += $total_amount;
        $totalTax += $vat;
    }

    // ====== TOTAL ROW ======
    echo '<tr>
        <td colspan="6"><strong>Total</strong></td>
        <td><strong>'.$totalTaxable.'</strong></td>
        <td></td>
        <td colspan="3"><strong>'.$totalTax.'</strong></td>
    </tr>';

    echo '</table>';
}
?>
