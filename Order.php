<?php include('./constant/layout/head.php');?>
<!--  Author Name- Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website - solutiontechservices.com -->

<?php include('./constant/layout/header.php');?>

<?php //include('./constant/layout/sidebar.php');?>

<?php include('./constant/connect');
 $user=$_SESSION['userId'];
 $sql = "
 SELECT o.order_id, o.order_date, c.name as client_name, o.client_contact, o.payment_status
 FROM orders o
 JOIN tbl_client c ON o.client_name = c.id
 WHERE o.order_status = 1 AND o.user_id = '$user'";
 $result = $connect->query($sql);
 

//echo $sql;exit;

    //echo $itemCountRow;exit; 
?>
       <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> View Invoice</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">View Invoice</li>
                    </ol>
                </div>
            </div>
            
            
            <!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->

<div class="container-fluid">
                
                
                
                
                 <div class="card">
                            <div class="card-body">
                              
                            <a href="add-order.php"><button class="btn btn-primary">Add Invoice</button></a>
                         
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                              <th>#</th>
                        <th>Invoice Date</th>
                        <th>Client Name</th>
                        <th>Contact</th>
                        <th>Total Invoice Item</th>
                        <th>Payment Status</th>
                                                <th>Action</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                        <?php
foreach ($result as $row) {

    ?>
                                        <tr>
                                            <td><?php echo $row['order_id'] ?></td>
                                            <td><?php echo $row['order_date'] ?></td>
                                             <td><?php echo $row['client_name'] ?></td>
                                              <td><?php echo $row['client_contact'] ?></td>
                                              <td>
                                                <?php
                                                $orderId = $row['order_id'];
                                                $itemSql = "SELECT COUNT(*) AS itemCount FROM order_item WHERE order_id = '$orderId'";
                                                $itemResult = $connect->query($itemSql);
                                                $itemData = $itemResult->fetch_assoc();
                                                echo $itemData['itemCount'];
                                                ?>
                                                </td>

                                            <td><?php  if($row['payment_status']==1)
                                            {
                                                 
                                                 $paymentStatus = "<label class='label label-success' ><h4>Full Payment</h4></label>";
                                                 echo $paymentStatus;
                                            }
                                            else if($row['payment_status']==2){
                                                $paymentStatus = "<label class='label label-danger'><h4>Advance Payment</h4></label>";
                                                echo $paymentStatus;
                                            }else {
                                                $paymentStatus = "<label class='label label-warning'><h4>No Payment</h4></label>";
                                                 echo $paymentStatus;
                                                } // /els
                                            ?></td>
                                            <td>
            
                                                <a href="editorder.php?id=<?php echo $row['order_id']?>"><button type="button" class="btn btn-xs btn-primary" ><i class="fa fa-pencil"></i></button></a>
                                                <a href="print.php?id=<?php echo $row['order_id']?>"><button type="button" class="btn btn-xs btn-info" ><i class="fa fa-print"></i></button></a>

                                              

             
                                                <a href="php_action/removeOrder.php?id=<?php echo $row['order_id']?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
                                           
                                                
                                                </td>
                                        </tr>

                                   <?php    
}

?>
 </tbody>
                               </table>
                                </div>
                            </div>
                        </div>
                    

<!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->
 <?php include('./constant/layout/footer.php'); ?>

<!-- Script to initialize DataTable -->
<script>
  $(document).ready(function() {
    // Confirm that jQuery and DataTables are loaded
    console.log('Page loaded, initializing DataTable...');
    $('#myTable').DataTable({
      searching: true,
      ordering: true
    });
  });
</script>



