<?php 

require_once '../constant/connect.php';

if($_POST) {
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];

	$sql = "SELECT * FROM orders WHERE order_date >= '$startDate' AND order_date <= '$endDate' and order_status = 1";

	$query = $connect->query($sql);

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
	while ($result = $query->fetch_assoc()) {
		$sql1 = "SELECT * FROM tbl_client  
		WHERE id = '".$result['client_name']."'";

	  $result1 = $connect->query($sql1);
	  $data1 = $result1->fetch_assoc();

		$table .= '<tr>
			<td><center>'.$result['order_id'].'</center></td>
			<td><center>'.$result['order_date'].'</center></td>
			<td><center>'.$data1['name'].'</center></td>
		    <td><center>'.$data1['mob_no'].'</center></td>
			<td><center>'.$result['gst_no'].'</center></td>
			<td><center>'.$result['hsn'].'</center></td>
			<td><center>'.$result['total_amount'].'</center></td>
			<td><center>18%</center></td>
			<td><center>'.($result['vat']/2).'</center></td>
			<td><center>'.($result['vat']/2).'</center></td>
			<td><center>0</center></td>
		</tr>';
		$totalTaxable += $result['total_amount'];
		$totalTax += $result['vat'];
	}

	$table .= '
		<tr>
			<td colspan="5"><center><strong>Total Value</strong></center></td>
			<td colspan="3"><center><strong>'.$totalTaxable.'</strong></center></td>
			<td colspan="3"><center><strong>'.$totalTax.'</strong></center></td>
		</tr>
	</table>';

	echo $table;
}
?>
