<?php include('./constant/layout/head.php');?>
<!--  Author Name- Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website - solutiontechservices.com -->

<?php include('./constant/layout/header.php');?>

<?php //include('./constant/layout/sidebar.php');?>   
<?php include('./constant/connect');
$sql = "SELECT * FROM tbl_client WHERE delete_status = 0";
$result = $connect->query($sql);
//echo $sql;exit;

?>
       <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> View Clent</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">View Clent</li>
                    </ol>
                </div>
            </div>
            
            
            <!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->

<div class="container-fluid">
                
                
                
                
                 <div class="card">
                            <div class="card-body">
                              
                            <a href="add_client.php"><button class="btn btn-primary">Add Client</button></a>
                         
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                              <th>#</th>
                                                <th>Client Name</th>
                                                <th>Gender</th>
                                                <th>Mobile NO</th>
                                                <th>Referral Number</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                        <?php
foreach ($result as $row) {
    $no+=1;
    ?>
                                        <tr>
                                            <td><?php echo$no; ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['gender'] ?></td>
                                              <td><?php echo $row['mob_no'] ?></td>
                                            <td><?php echo $row['reffering'] ?></td>
                                            <td><?php echo $row['address'] ?></td>
                                          
                                            <td>
            
                                                <a href="editclient.php?id=<?php echo $row['id']?>"><button type="button" class="btn btn-xs btn-primary" ><i class="fa fa-pencil"></i></button></a>
                                              

             
                                                <a href="php_action/removeclient.php?id=<?php echo $row['id']?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
                                           
                                                
                                                </td>
                                        </tr>
                                      
                                    </tbody>
                                   <?php    
}
?>
                               </table>
                                </div>
                            </div>
                        </div>

<!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->
<?php include('./constant/layout/footer.php');?>


