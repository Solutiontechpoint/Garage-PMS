<?php include('./constant/layout/head.php');?>
<!--  Author Name- Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website - solutiontechservices.com -->

<?php include('./constant/layout/header.php');?>

<?php //include('./constant/layout/sidebar.php');?> 
<?php include('./constant/connect.php');



  $sql="SELECT * from tbl_client where  id='".$_GET['id']."'";
  $result=$connect->query($sql)->fetch_assoc();



    ?> 
 
        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Client Management</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Client Brand</li>
                    </ol>
                </div>
            </div>
            
            
            <!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->

<div class="container-fluid">
                
                
                
                
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-title">
                               
                            </div>
                            <div id="add-brand-messages"></div>
                            <div class="card-body">
                                <div class="input-states">
                                    <form class="form-horizontal" method="POST"  id="submitBrandForm" action="php_action/editclient.php?id=<?php echo $_GET['id'];?>" enctype="multipart/form-data">

                                   <input type="hidden" name="currnt_date" class="form-control">

                                       <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label"> Name</label>
                                                <div class="col-sm-9">
                                                  <input type="text" class="form-control" id="name" placeholder=" Name" name="name" autocomplete="off" required="" value="<?php  echo$result['name'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Gender</label>
                                                <div class="col-sm-9">
                                                                                                  <select class="form-control" id="brandName" name="gender">
                                                                                                    <option value="Female" <?php if($result['gender']=="Female"){ echo "selected";}?>>Female</option>
                                                                                                    <option value="Male" <?php if($result['gender']=="Male"){ echo "selected";}?>>Male</option>
</select></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Mobile No
</label>
                                                <div class="col-sm-9">
                        <input type="text" class="form-control" id="" placeholder="" name="mob_no" autocomplete="off" required="" value="<?php  echo$result['mob_no'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Referral Number</label>
                                                <div class="col-sm-9">
                                                                                                    <input type="text" class="form-control" id="" placeholder="" name="reffering" autocomplete="off" value="<?php  echo$result['reffering'];?>" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Vehicle Type</label>
                                                <div class="col-sm-9">
                                                   <select class="form-control select2" id="clientName" name="vtype">
                                                <option value="" readonly>~~SELECT~~</option>
                                         <option <?php if($result['vehicle_type']=="twowheeler"){ ?> selected="selected" <?php }?> value='twowheeler' >Two Wheeler</option>
                                                  
                                                   
                                         <option <?php if($result['vehicle_type']=="threewheeler"){ ?> selected="selected" <?php }?> value='threewheeler' >Three Wheeler</option>
  
                                         <option <?php if($result['vehicle_type']=="fourwheeler"){ ?> selected="selected" <?php }?> value='fourwheeler' >Four Wheeler </option>
  
 
                                                
                                               </select>
                                             </div>
                                             </div>
                                             </div>

                                             <div class="form-group">
                                             <div class="row">

                                                <label class="col-sm-3 control-label">Vehicle Number</label>
                                                <div class="col-sm-9">
                                               
                          <input type="text" class="form-control" id="mob_no" name="vname" value="<?php echo $result['vehicle_name'] ?>"  style="color:black;" >
                                                </div>
                                            

                                            </div>

                                        </div>

                                     <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                                                                    <textarea type="text" class="form-control" id="" placeholder="" name="address" autocomplete="off" required="" style="height: 150px;"><?php  echo$result['address'];?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                  

                                        <button type="submit" name="create" id="createBrandBtn" class="btn btn-primary btn-flat m-b-30 m-t-30">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                
               


<!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->
<?php include('./constant/layout/footer.php');?>


