<?php 

require_once '../constant/connect.php';

if($_POST) {
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];

	$table = '
	<table border="1" cellspacing="0" cellpadding="5" style="width:100%; border-collapse: collapse;">
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

	// ===== ORDERS =====
	$sql = "SELECT * FROM orders WHERE order_date >= '$startDate' AND order_date <= '$endDate' and order_status = 1";
	$query = $connect->query($sql);

	while ($result = $query->fetch_assoc()) {
		$clientSql = "SELECT * FROM tbl_client WHERE id = '".$result['client_name']."'";
		$clientRes = $connect->query($clientSql);
		$client = $clientRes->fetch_assoc();

		$vat = floatval($result['vat']);
		$total = floatval($result['total_amount']);

		$table .= '<tr>
			<td><center>'.$result['order_id'].'</center></td>
			<td><center>'.$result['order_date'].'</center></td>
			<td><center>'.$client['name'].'</center></td>
			<td><center>'.$client['mob_no'].'</center></td>
			<td><center>'.$result['gst_no'].'</center></td>
			<td><center>'.$result['hsn'].'</center></td>
			<td><center>'.$total.'</center></td>
			<td><center>18%</center></td>
			<td><center>'.($vat/2).'</center></td>
			<td><center>'.($vat/2).'</center></td>
			<td><center>0</center></td>
		</tr>';

		$totalTaxable += $total;
		$totalTax += $vat;
	}

	// ===== JOB CARDS =====
	$jobSql = "SELECT * FROM job_card WHERE DATE(datetime_in) >= '$startDate' AND DATE(datetime_in) <= '$endDate' AND job_status = 1";
	$jobQuery = $connect->query($jobSql);

	while ($row = $jobQuery->fetch_assoc()) {
		$clientSql = "SELECT * FROM tbl_client WHERE id = '".$row['customer_name']."'";
		$clientRes = $connect->query($clientSql);
		$client = $clientRes->fetch_assoc();

		$vat = floatval($row['vat']);
		$total = floatval($row['total_amount']);

		$table .= '<tr>
			<td><center>'.$row['job_card_id'].'</center></td>
			<td><center>'.substr($row['datetime_in'], 0, 10).'</center></td>
			<td><center>'.$client['name'].'</center></td>
			<td><center>'.$client['mob_no'].'</center></td>
			<td><center></center></td>
			<td><center>'.$row['service_type'].'</center></td>
			<td><center>'.$total.'</center></td>
			<td><center>18%</center></td>
			<td><center>'.($vat/2).'</center></td>
			<td><center>'.($vat/2).'</center></td>
			<td><center>0</center></td>
		</tr>';

		$totalTaxable += $total;
		$totalTax += $vat;
	}

	// ===== TOTAL ROW =====
	$table .= '
		<tr>
			<td colspan="6"><center><strong>Total Value</strong></center></td>
			<td><center><strong>'.$totalTaxable.'</strong></center></td>
			<td></td>
			<td colspan="3"><center><strong>'.$totalTax.'</strong></center></td>
		</tr>
	</table>';

	echo $table;
}
?>
