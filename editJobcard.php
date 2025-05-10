<?php 
include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/connect.php');

if (!isset($_GET['id'])) {
  echo "<script>alert('Invalid Job Card ID'); window.location='manage-jobcard.php';</script>";
  exit();
}

$jobCardId = intval($_GET['id']);
$sql = "SELECT * FROM job_card WHERE job_card_id = $jobCardId";
$result = $connect->query($sql);

if ($result->num_rows != 1) {
  echo "<script>alert('Job Card not found'); window.location='manage-jobcard.php';</script>";
  exit();
}

$row = $result->fetch_assoc();
?>

<link rel="stylesheet" href="custom/js/order.js">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  #productTable th {
  background-color: #0b2a97;
  color: #fff;
  text-align: center;
  padding: 12px;
  font-size: 15px;
  font-weight: 600;
}
/* 1. Card background + shadow */
.card {
  background-color: #f9f9f9;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  border-radius: 10px;
  padding: 25px;
  margin-bottom: 30px;
}

/* 2. Fade-in Animation */
.card {
  animation: fadeInUp 0.7s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* 3. Buttons style */
.btn {
  border-radius: 30px;
  padding: 10px 25px;
  font-weight: 600;
  letter-spacing: 0.5px;
}


/* 5. Input field highlight on focus */
.form-control:focus {
  border-color: #0b2a97;
  box-shadow: 0 0 5px rgba(11,42,151,0.3);
}

/* 6. Stylish divider */
.section-divider {
  border-top: 1px #ccc;
  margin: 20px 0;
}
</style>
<ol class="breadcrumb">
  <li><a href="dashboard.php">Home / </a></li>
  <li><a href="jobcard.php">Job Card Management / </a></li>
  <li class="active">Edit Job Card</li>
</ol>

<div class="page-wrapper">
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-primary">Job Card Management</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Job Card Management</li>
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-11 mx-auto">
        <form class="form-horizontal" method="POST" action="php_action/editJobcard.php" id="updateJobcardForm">
          <input type="hidden" name="job_card_id" value="<?= $row['job_card_id'] ?>">

          <!-- Include the same form layout as add-jobcard.php -->
          <!-- Just prefill the values from $row -->

          <!-- Example - Job Card No -->
          <div class="card">
            <div class="card-body">
            <h4 class="card-title" style="color: #0b2a97; font-weight: bold; font-size: 20px;">
  <span style="background-color: #0b2a97; color: #fff; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px;">1</span>
  Job Details
</h4>
    <br>

              <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Job Card No</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="jobCardNo" value="<?= $row['job_card_no'] ?>" readonly>
                  </div>

                  <label class="col-sm-2 control-label">Date/Time In</label>
                  <div class="col-sm-4">
                    <input type="datetime-local" class="form-control" name="orderDate" value="<?= date('Y-m-d\TH:i', strtotime($row['datetime_in'])) ?>">
                  </div>
                </div>
              </div>

              <!-- Client Name -->
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Client Name</label>
                  <div class="col-sm-4">
                    <select class="form-control select2" name="clientName" id="clientName">
                      <option value="">~~SELECT~~</option>
                      <?php
                        $clientSql = "SELECT * FROM tbl_client WHERE delete_status = 0";
                        $clientResult = $connect->query($clientSql);
                        while($client = $clientResult->fetch_assoc()) {
                          $selected = ($client['id'] == $row['customer_name']) ? "selected" : "";
                          echo "<option value='{$client['id']}' $selected>{$client['name']}</option>";
                        }
                      ?>
                    </select>
                  </div>

                  <label class="col-sm-2 control-label">Client Contact</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="clientContact" value="<?= $row['client_contact'] ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Vehicle Type</label>
                  <div class="col-sm-4">
                    <select class="form-control select2" name="vtype" id="vtype">
                      <option value="">~~SELECT~~</option>
                      <option value="twowheeler" <?php if($row['vehicle_type'] == 'twowheeler'){ echo "selected"; } ?>>Two Wheeler</option>
                      <option value="threewheeler" <?php if($row['vehicle_type'] == 'threewheeler'){ echo "selected"; } ?>>Three Wheeler</option>
                      <option value="fourwheeler" <?php if($row['vehicle_type'] == 'fourwheeler'){ echo "selected"; } ?>>Four Wheeler</option>
                    </select>
                  </div>
                  <label class="col-sm-2 control-label">Vehicle Number</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="vname" id="vname" value="<?= $row['vehicle_name'] ?>" required />
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <label class="col-sm-2 control-label">Mechanic Name</label>
                  <div class="col-sm-4">
                    <input type="text" name="mname" class="form-control" id="mname" value="<?= $row['handled_by'] ?>" required />
                  </div>
                  <label class="col-sm-2 control-label">Supervisor Name</label>
                  <div class="col-sm-4">
                    <input type="text" name="sname" class="form-control" id="sname" value="<?= $row['booked_by'] ?>" />
                  </div>
                </div>
              </div>

              <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Date/Time Out</label>
                    <div class="col-sm-4">
                      <input type="datetime-local" class="form-control" name="deliverydate" id="deliverydate" value="<?= date('Y-m-d\TH:i', strtotime($row['datetime_out'])) ?>" />
                    </div>

                    
                    <div class="col-sm-2">
                    <label class="control-label">Floor Mat</label>&nbsp;
                      <input type="checkbox" name="floor_mat" id="floor_mat" <?php if ($row['floor_mat'] == 1) echo "checked"; ?> />
                    </div>
                   
                    <div class="col-sm-2">
                    <label class="control-label">Cut Mat</label>&nbsp;
                      <input type="checkbox" name="cut_mat" id="cut_mat" <?php if ($row['cut_mat'] == 1) echo "checked"; ?> />
                    </div>
                   
                    <div class="col-sm-2">
                    <label class="control-label">Pick-up & Drop</label>&nbsp;
                      <input type="checkbox" name="pickup_drop" id="pickup_drop" <?php if ($row['pickup_drop'] == 1) echo "checked"; ?> /> 
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Pick-up Person</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="pickup_person" id="pickup_person" value="<?= $row['pickup_person_name'] ?>" />
                    </div>      
                </div>
                      </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Items in Car</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="items_in_car" id="items_in_car"><?= $row['items_in_car'] ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Odometer</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="odometer" id="odometer" value="<?= $row['odometer_reading'] ?>" />
                    </div>
                    <label class="col-sm-2 control-label">Fuel Level</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="fuel" id="fuel" value="<?= $row['fuel_level'] ?>" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Dents / Scratches Map</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="dents_map" id="dents_map"><?= $row['dents_scratches_map'] ?></textarea>
                    </div>
                  </div>
                </div>
                    </div></div>
              <!-- Continue exactly like your add-jobcard.php fields -->
              <!-- Prepopulate vehicle type, vehicle number, etc. -->

              <!-- Then load service items -->
              <div class="section-divider"></div>

              <div class="card">
                <div class="card-body">
                <h4 class="card-title" style="color: #0b2a97; font-weight: bold; font-size: 20px;">
  <span style="background-color: #0b2a97; color: #fff; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px;">2</span>
  Service Details
</h4>
    <br>

    <table class="table" id="productTable">
  <thead>
    <tr>              
      <th style="width:40%;">Product</th>
      <th style="width:20%;">Rate</th>
      <th style="width:10%;">Avail.</th>
      <th style="width:15%;">Quantity</th>              
      <th style="width:25%;">Total</th>             
      <th style="width:10%;">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $productSql = "SELECT * FROM job_card_item WHERE job_card_id = $jobCardId AND job_card_item_status = 1";
      $productResult = $connect->query($productSql);
      $x = 1;
      while($item = $productResult->fetch_assoc()) {
    ?>
    <tr id="row<?= $x ?>" class="<?= $x ?>">
      <td style="margin-left:20px;">
        <div class="form-group">
          <select class="form-control select2" style="width:100% !important;" name="productName[]" id="productName<?= $x ?>" onchange="getProductData(<?= $x ?>)">
            <option value="">~~SELECT~~</option>
            <?php
              $products = $connect->query("SELECT * FROM product WHERE active = 1 AND status = 1");
              while($prod = $products->fetch_assoc()) {
                $selected = ($prod['product_id'] == $item['product_id']) ? "selected" : "";
                echo "<option value='{$prod['product_id']}' $selected>{$prod['product_name']}</option>";
              }
            ?>
          </select>
        </div>
      </td>
      <td style="padding-left:20px;">
        <input type="text" name="rate[]" style="width:70% !important; display:inline !important;" id="rate<?= $x ?>" value="<?= $item['rate'] ?>" autocomplete="off" disabled="true" class="form-control" />
        <input type="hidden" name="rateValue[]" id="rateValue<?= $x ?>" value="<?= $item['rate'] ?>" autocomplete="off" class="form-control" />
        <button type="button" class="btn btn-xs btn-primary" style="display:inline !important;" onclick="editRow(<?= $x ?>)"><i class="fa fa-pencil"></i></button>
      </td>
      <!-- <td style="padding-left:20px;">
        <div class="form-group">
          <p id="available_quantity<?= $x ?>"></p>
        </div>
      </td> -->
      <td style="padding-left:20px;">
                  <div class="form-group">
                  <?php
                      $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
                      $productData = $connect->query($productSql);

                      while($data1 = $productData->fetch_array()) {                     
                        $selected = "";
                        if($data1['product_id'] == $item['product_id']) { 
                          echo "<p id='available_quantity".$data1['product_id']."'>".$data1['quantity']."</p>";
                      }
                         else {
                          $selected = "";
                        }

                        //echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
                      } // /while 

                    ?>
                  
                  </div>
                </td>
      <td style="padding-left:20px;">
        <div class="form-group">
          <input type="number" name="quantity[]" id="quantity<?= $x ?>" value="<?= $item['quantity'] ?>" onkeyup="getTotal(<?= $x ?>)" autocomplete="off" class="form-control" min="1" />
        </div>
      </td>
      <td>
        <input type="text" name="total[]" id="total<?= $x ?>" value="<?= $item['total'] ?>" autocomplete="off" class="form-control" disabled="true" />
        <input type="hidden" name="totalValue[]" id="totalValue<?= $x ?>" value="<?= $item['total'] ?>" autocomplete="off" class="form-control" />
      </td>
      <td>
        <button class="btn btn-danger removeProductRowBtn" type="button" onclick="removeProductRow(<?= $x ?>)"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
    <?php
        $x++;
      }
    ?>
  </tbody>          
</table>


                  <button type="button" class="btn btn-primary" onclick="addRow()">Add New Row</button>

                </div>
              </div>

              <div class="section-divider"></div>

<div class="card">
  <div class="card-body">
  <h4 class="card-title" style="color: #0b2a97; font-weight: bold; font-size: 20px;">
  <span style="background-color: #0b2a97; color: #fff; border-radius: 50%; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px;">3</span>
  Pricing Details
</h4>
    <br>
                <!-- Pricing Section IDs added below -->
                <?php
$totalAmount = $row['total_amount'];
$discount = $row['discount'];
$grandTotal = $row['grand_total'];
$paid = $row['paid'];
$dueValue = $row['due'];
$paymentType = $row['payment_type'];
$paymentStatus = $row['payment_status'];
$paymentPlace = $row['payment_place'];
?>

<div class="form-group">
  <div class="row">
    <label class="col-sm-2 control-label">Sub Total</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="subTotal" name="subTotal" value="<?= $row['sub_total'] ?>" disabled="true" />
      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?= $row['sub_total'] ?>" />
    </div>
    <label class="col-sm-2 control-label">GST</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="vat" name="gstn" value="<?= $row['vat'] ?>" readonly="true" />
      <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?= $row['vat'] ?>" />
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="col-sm-2 control-label">Total</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="totalAmount" name="totalAmount" value="<?= $totalAmount ?>" disabled="true"/>
      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?= $totalAmount ?>" />
    </div>
    <label class="col-sm-2 control-label">Discount</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="discount" name="discount" value="<?= $discount ?>" onkeyup="discountFunc()" autocomplete="off" pattern="^[0-9]+$"/>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="col-sm-2 control-label">Grand Total</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="grandTotal" name="grandTotal" value="<?= $grandTotal ?>" disabled="true" />
      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?= $grandTotal ?>" />
    </div>
    <label class="col-sm-2 control-label">Paid</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="paid" name="paid" value="<?= $paid ?>" autocomplete="off" onkeyup="paidAmount()" />
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="col-sm-2 control-label">Due</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="dueValue" id="dueValue" value="<?= $dueValue ?>" readonly />
    </div>
    <label class="col-sm-2 control-label">Payment Type</label>
    <div class="col-sm-4">
      <select class="form-control" name="paymentType" id="paymentType">
        <option value="">~~SELECT~~</option>
        <option value="1" <?= ($paymentType == 1) ? "selected" : "" ?>>Cheque</option>
        <option value="2" <?= ($paymentType == 2) ? "selected" : "" ?>>Cash</option>
        <option value="3" <?= ($paymentType == 3) ? "selected" : "" ?>>Credit Card</option>
        <option value="4" <?= ($paymentType == 4) ? "selected" : "" ?>>PhonePe</option>
        <option value="5" <?= ($paymentType == 5) ? "selected" : "" ?>>Google Pay</option>
        <option value="6" <?= ($paymentType == 6) ? "selected" : "" ?>>Amazon Pay</option>
      </select>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="row">
    <label class="col-sm-2 control-label">Payment Status</label>
    <div class="col-sm-4">
      <select class="form-control" name="paymentStatus" id="paymentStatus">
        <option value="">~~SELECT~~</option>
        <option value="1" <?= ($paymentStatus == 1) ? "selected" : "" ?>>Full Payment</option>
        <option value="2" <?= ($paymentStatus == 2) ? "selected" : "" ?>>Advance Payment</option>
        <option value="3" <?= ($paymentStatus == 3) ? "selected" : "" ?>>No Payment</option>
      </select>
    </div>

    <label class="col-sm-2 control-label">Payment Place</label>
    <div class="col-sm-4">
      <select class="form-control" name="paymentPlace" id="paymentPlace">
        <option value="">~~SELECT~~</option>
        <option value="1" <?= ($paymentPlace == 1) ? "selected" : "" ?>>In India</option>
        <option value="2" <?= ($paymentPlace == 2) ? "selected" : "" ?>>Out Of India</option>
      </select>
    </div>
  </div>
</div>

              <!-- Pricing Details (SubTotal, GST, Grand Total, Paid, Due etc.) prefilled -->
              <!-- Same structure as add form -->
              <input type="hidden" name="jobCardId" id="jobCardId" value="<?php echo $jobCardId; ?>" />
              <div class="form-group submitButtonFooter">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success">Update Job Card</button>
                  <a href="jobcard.php" class="btn btn-default">Cancel</a>
                </div>
              </div>
                    </div></div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?php include('./constant/layout/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function editRow(rowId) {
  // Make the rate field editable
  $('#rate' + rowId).prop('disabled', false);
  
  // Add event listener to trigger getTotal on change and update rate value array
  $('#rate' + rowId).on('change keyup', function() {
    getTotal(rowId);
    $("#rateValue" + rowId).val($(this).val()); // update rate value array
  });
  
  // Hide the edit button
  $('#rate' + rowId).siblings('button').hide();
}
  $(document).ready(function() {
  $(".select2").select2();
  });
</script>
<script>

var manageOrderTable;

$(document).ready(function() {
  $("#paymentPlace").change(function(){
    if($("#paymentPlace").val() == 2)
    {
      $(".gst").text("IGST 18%");
    }
    else
    {
      $(".gst").text("GST 18%");  
    }
});

  var divRequest = $(".div-request").text();

  // top nav bar 
  $("#navOrder").addClass('active');

  if(divRequest == 'add')  {
    // add order  
    // top nav child bar 
    $('#topNavAddOrder').addClass('active');  

    // order date picker
    $("#orderDate").datepicker();

    // create order form function
    $("#createOrderForm").unbind('submit').bind('submit', function() {
      var form = $(this);

      $('.form-group').removeClass('has-error').removeClass('has-success');
      $('.text-danger').remove();
        
      var orderDate = $("#orderDate").val();
      var clientName = $("#clientName").val();
      var clientContact = $("#clientContact").val();
      var paid = $("#paid").val();
      var discount = $("#discount").val();
      var paymentType = $("#paymentType").val();
      var paymentStatus = $("#paymentStatus").val();    

      // form validation 
      if(orderDate == "") {
        $("#orderDate").after('<p class="text-danger"> The Order Date field is required </p>');
        $('#orderDate').closest('.form-group').addClass('has-error');
      } else {
        $('#orderDate').closest('.form-group').addClass('has-success');
      } // /else

      if(clientName == "") {
        $("#clientName").after('<p class="text-danger"> The Client Name field is required </p>');
        $('#clientName').closest('.form-group').addClass('has-error');
      } else {
        $('#clientName').closest('.form-group').addClass('has-success');
      } // /else

      if(clientContact == "") {
        $("#clientContact").after('<p class="text-danger"> The Contact field is required </p>');
        $('#clientContact').closest('.form-group').addClass('has-error');
      } else {
        $('#clientContact').closest('.form-group').addClass('has-success');
      } // /else

      if(paid == "") {
        $("#paid").after('<p class="text-danger"> The Paid field is required </p>');
        $('#paid').closest('.form-group').addClass('has-error');
      } else {
        $('#paid').closest('.form-group').addClass('has-success');
      } // /else

      if(discount == "") {
        $("#discount").after('<p class="text-danger"> The Discount field is required </p>');
        $('#discount').closest('.form-group').addClass('has-error');
      } else {
        $('#discount').closest('.form-group').addClass('has-success');
      } // /else

      if(paymentType == "") {
        $("#paymentType").after('<p class="text-danger"> The Payment Type field is required </p>');
        $('#paymentType').closest('.form-group').addClass('has-error');
      } else {
        $('#paymentType').closest('.form-group').addClass('has-success');
      } // /else

      if(paymentStatus == "") {
        $("#paymentStatus").after('<p class="text-danger"> The Payment Status field is required </p>');
        $('#paymentStatus').closest('.form-group').addClass('has-error');
      } else {
        $('#paymentStatus').closest('.form-group').addClass('has-success');
      } // /else


      // array validation
      var productName = document.getElementsByName('productName[]');        
      var validateProduct;
      for (var x = 0; x < productName.length; x++) {            
        var productNameId = productName[x].id;        
        if(productName[x].value == ''){               
          $("#"+productNameId+"").after('<p class="text-danger"> Product Name Field is required!! </p>');
          $("#"+productNameId+"").closest('.form-group').addClass('has-error');                     
        } else {        
          $("#"+productNameId+"").closest('.form-group').addClass('has-success');                       
        }          
      } // for

      for (var x = 0; x < productName.length; x++) {                  
        if(productName[x].value){                       
          validateProduct = true;
        } else {        
          validateProduct = false;
        }          
      } // for              
      
      var quantity = document.getElementsByName('quantity[]');        
      var validateQuantity;
      for (var x = 0; x < quantity.length; x++) {       
        var quantityId = quantity[x].id;
        if(quantity[x].value == ''){        
          $("#"+quantityId+"").after('<p class="text-danger"> Product Name Field is required!! </p>');
          $("#"+quantityId+"").closest('.form-group').addClass('has-error');                        
        } else {        
          $("#"+quantityId+"").closest('.form-group').addClass('has-success');                                
        } 
      }  // for

      for (var x = 0; x < quantity.length; x++) {                   
        if(quantity[x].value){                        
          validateQuantity = true;
        } else {        
          validateQuantity = false;
        }          
      } // for        
      

      if(orderDate && clientName && clientContact && paid && discount && paymentType && paymentStatus) {
        if(validateProduct == true && validateQuantity == true) {
          // create order button
          // $("#createOrderBtn").button('loading');

          $.ajax({
            url : form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),         
            dataType: 'json',
            success:function(response) {
              console.log(response);
              // reset button
              $("#createOrderBtn").button('reset');
              
              $(".text-danger").remove();
              $('.form-group').removeClass('has-error').removeClass('has-success');

              if(response.success == true) {
                
                // create order button
                $(".success-messages").html('<div class="alert alert-success">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
                ' <br /> <br /> <a type="button" onclick="printOrder('+response.order_id+')" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print </a>'+
                '<a href="orders.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Order </a>'+
                
               '</div>');
                
              $("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);

              // disabled te modal footer button
              $(".submitButtonFooter").addClass('div-hide');
              // remove the product row
              $(".removeProductRowBtn").addClass('div-hide');
                
              } else {
                alert(response.messages);               
              }
            } // /response
          }); // /ajax
        } // if array validate is true
      } // /if field validate is true
      

      return false;
    }); // /create order form function  
  
  } else if(divRequest == 'manord') {
    // top nav child bar 
    $('#topNavManageOrder').addClass('active');

    manageOrderTable = $("#manageOrderTable").DataTable({
      'ajax': 'php_action/fetchOrder.php',
      'order': []
    });   
          
  } else if(divRequest == 'editOrd') {
    $("#orderDate").datepicker();

    // edit order form function
    $("#editOrderForm").unbind('submit').bind('submit', function() {
      // alert('ok');
      var form = $(this);

      $('.form-group').removeClass('has-error').removeClass('has-success');
      $('.text-danger').remove();
        
      var orderDate = $("#orderDate").val();
      var clientName = $("#clientName").val();
      var clientContact = $("#clientContact").val();
      var paid = $("#paid").val();
      var discount = $("#discount").val();
      var paymentType = $("#paymentType").val();
      var paymentStatus = $("#paymentStatus").val();    

      // form validation 
      if(orderDate == "") {
        $("#orderDate").after('<p class="text-danger"> The Order Date field is required </p>');
        $('#orderDate').closest('.form-group').addClass('has-error');
      } else {
        $('#orderDate').closest('.form-group').addClass('has-success');
      } // /else

      if(clientName == "") {
        $("#clientName").after('<p class="text-danger"> The Client Name field is required </p>');
        $('#clientName').closest('.form-group').addClass('has-error');
      } else {
        $('#clientName').closest('.form-group').addClass('has-success');
      } // /else

      if(clientContact == "") {
        $("#clientContact").after('<p class="text-danger"> The Contact field is required </p>');
        $('#clientContact').closest('.form-group').addClass('has-error');
      } else {
        $('#clientContact').closest('.form-group').addClass('has-success');
      } // /else

      if(paid == "") {
        $("#paid").after('<p class="text-danger"> The Paid field is required </p>');
        $('#paid').closest('.form-group').addClass('has-error');
      } else {
        $('#paid').closest('.form-group').addClass('has-success');
      } // /else

      if(discount == "") {
        $("#discount").after('<p class="text-danger"> The Discount field is required </p>');
        $('#discount').closest('.form-group').addClass('has-error');
      } else {
        $('#discount').closest('.form-group').addClass('has-success');
      } // /else

      if(paymentType == "") {
        $("#paymentType").after('<p class="text-danger"> The Payment Type field is required </p>');
        $('#paymentType').closest('.form-group').addClass('has-error');
      } else {
        $('#paymentType').closest('.form-group').addClass('has-success');
      } // /else

      if(paymentStatus == "") {
        $("#paymentStatus").after('<p class="text-danger"> The Payment Status field is required </p>');
        $('#paymentStatus').closest('.form-group').addClass('has-error');
      } else {
        $('#paymentStatus').closest('.form-group').addClass('has-success');
      } // /else


      // array validation
      var productName = document.getElementsByName('productName[]');        
      var validateProduct;
      for (var x = 0; x < productName.length; x++) {            
        var productNameId = productName[x].id;        
        if(productName[x].value == ''){               
          $("#"+productNameId+"").after('<p class="text-danger"> Product Name Field is required!! </p>');
          $("#"+productNameId+"").closest('.form-group').addClass('has-error');                     
        } else {        
          $("#"+productNameId+"").closest('.form-group').addClass('has-success');                       
        }          
      } // for

      for (var x = 0; x < productName.length; x++) {                  
        if(productName[x].value){                       
          validateProduct = true;
        } else {        
          validateProduct = false;
        }          
      } // for              
      
      var quantity = document.getElementsByName('quantity[]');        
      var validateQuantity;
      for (var x = 0; x < quantity.length; x++) {       
        var quantityId = quantity[x].id;
        if(quantity[x].value == ''){        
          $("#"+quantityId+"").after('<p class="text-danger"> Product Name Field is required!! </p>');
          $("#"+quantityId+"").closest('.form-group').addClass('has-error');                        
        } else {        
          $("#"+quantityId+"").closest('.form-group').addClass('has-success');                                
        } 
      }  // for

      for (var x = 0; x < quantity.length; x++) {                   
        if(quantity[x].value){                        
          validateQuantity = true;
        } else {        
          validateQuantity = false;
        }          
      } // for        
      

      if(orderDate && clientName && clientContact && paid && discount && paymentType && paymentStatus) {
        if(validateProduct == true && validateQuantity == true) {
          // create order button
          // $("#createOrderBtn").button('loading');

          $.ajax({
            url : form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),         
            dataType: 'json',
            success:function(response) {
              console.log(response);
              // reset button
              $("#editOrderBtn").button('reset');
              
              $(".text-danger").remove();
              $('.form-group').removeClass('has-error').removeClass('has-success');

              if(response.success == true) {
                
                // create order button
                $(".success-messages").html('<div class="alert alert-success">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +                                                
               '</div>');
                
              $("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);

              // disabled te modal footer button
              $(".editButtonFooter").addClass('div-hide');
              // remove the product row
              $(".removeProductRowBtn").addClass('div-hide');
                
              } else {
                alert(response.messages);               
              }
            } // /response
          }); // /ajax
        } // if array validate is true
      } // /if field validate is true
      

      return false;
    }); // /edit order form function  
  }   

}); // /documernt


// print order function
function printOrder(orderId = null) {
  if(orderId) {   
      
    $.ajax({
      url: 'php_action/printOrder.php',
      type: 'post',
      data: {orderId: orderId},
      dataType: 'text',
      success:function(response) {
        
        var mywindow = window.open('', 'Rupee Invoice System', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Order Invoice</title>');        
        mywindow.document.write('</head><body>');
        mywindow.document.write(response);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.resizeTo(screen.width, screen.height);
setTimeout(function() {
    mywindow.print();
    mywindow.close();
}, 1250);

        //mywindow.print();
        //mywindow.close();
        
      }// /success function
    }); // /ajax function to fetch the printable order
  } // /if orderId
} // /print order function

function addRow() {
  $("#addRowBtn").button("loading");

  var tableLength = $("#productTable tbody tr").length;

  var tableRow;
  var arrayNumber;
  var count;

  if(tableLength > 0) {   
    tableRow = $("#productTable tbody tr:last").attr('id');
    arrayNumber = $("#productTable tbody tr:last").attr('class');
    count = tableRow.substring(3);  
    count = Number(count) + 1;
    arrayNumber = Number(arrayNumber) + 1;          
  } else {
    // no table row
    count = 1;
    arrayNumber = 0;
  }

  $.ajax({
    url: 'php_action/fetchProductData.php',
    type: 'post',
    dataType: 'json',
    success:function(response) {
      $("#addRowBtn").button("reset");      

      var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+                
        '<td>'+
          '<div class="form-group">'+

          '<select class="form-control select2_new" style="width:100% !important;" name="productName[]" id="productName'+count+'" onchange="getProductData('+count+')" >'+
            '<option value="">~~SELECT~~</option>';
            // console.log(response);
            $.each(response, function(index, value) {
              tr += '<option value="'+value[0]+'">'+value[1]+'</option>';             
            });
                          
          tr += '</select>'+
          '</div>'+
        '</td>'+
        '<td style="padding-left:20px;"">'+
          '<input type="text" name="rate[]"  style="width:70% !important;display: inline !important;" id="rate'+count+'" autocomplete="off" disabled="true" class="form-control" />'+
          '<input type="hidden" name="rateValue[]" id="rateValue'+count+'" autocomplete="off" class="form-control" />'+
          '<button type="button" class="btn btn-xs btn-primary" style="display: inline !important;" onclick="editRow('+count+')"><i class="fa fa-pencil"></i></button>'+
        '</td style="padding-left:20px;">'+
        '<td style="padding-left:20px;">'+
          '<div class="form-group">'+
          '<p id="available_quantity'+count+'"></p>'+
          '</div>'+
        '</td>'+
        '<td style="padding-left:20px;">'+
          '<div class="form-group">'+
          '<input type="number" name="quantity[]" id="quantity'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control" min="1" />'+
          '</div>'+
        '</td>'+
        '<td style="padding-left:20px;">'+
          '<input type="text" name="total[]" id="total'+count+'" autocomplete="off" class="form-control" disabled="true" />'+
          '<input type="hidden" name="totalValue[]" id="totalValue'+count+'" autocomplete="off" class="form-control" />'+
        '</td>'+
        
        '<td>'+
          '<button class="btn btn-danger removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="fa fa-trash"></i></i></button>'+
        '</td>'+

      '</tr>';

      if(tableLength > 0) {             
        $("#productTable tbody tr:last").after(tr);
        $("#productTable tbody tr:last").find('.select2_new').select2();
      } else {        
        $("#productTable tbody").append(tr);
       $("#productTable tbody").find('.select2_new').select2();
      }   

    } // /success
  }); // get the product data

} // /add row

function removeProductRow(row = null) {
  if(row) {
    $("#row"+row).remove();


    subAmount();
  } else {
    alert('error! Refresh the page again');
  }
}

// select on product data
function getProductData(row = null) {

  if(row) {
    var productId = $("#productName"+row).val();    
    
    if(productId == "") {
      $("#rate"+row).val("");

      $("#quantity"+row).val("");           
      $("#total"+row).val("");

      // remove check if product name is selected
      // var tableProductLength = $("#productTable tbody tr").length;     
      // for(x = 0; x < tableProductLength; x++) {
      //  var tr = $("#productTable tbody tr")[x];
      //  var count = $(tr).attr('id');
      //  count = count.substring(3);

      //  var productValue = $("#productName"+row).val()

      //  if($("#productName"+count).val() == "") {         
      //    $("#productName"+count).find("#changeProduct"+productId).removeClass('div-hide'); 
      //    console.log("#changeProduct"+count);
      //  }                     
      // } // /for

    } else {
      $.ajax({
        url: 'php_action/fetchSelectedProduct.php',
        type: 'post',
        data: {productId : productId},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          
          $("#rate"+row).val(response.rate);
          $("#rateValue"+row).val(response.rate);

          $("#quantity"+row).val(1);
          $("#available_quantity"+row).text(response.quantity);

          var total = Number(response.rate) * 1;
          total = total.toFixed(2);
          $("#total"+row).val(total);
          $("#totalValue"+row).val(total);
          
          
      
          subAmount();
        } // /success
      }); // /ajax function to fetch the product data 
    }
        
  } else {
    alert('no row! please refresh the page');
  }
} // /select on product data

// table total
function getTotal(row = null) {
  if(row) {
    var total = Number($("#rate"+row).val()) * Number($("#quantity"+row).val());
    total = total.toFixed(2);
    $("#total"+row).val(total);
    $("#totalValue"+row).val(total);
    
    subAmount();

  } else {
    alert('no row !! please refresh the page');
  }
}

function subAmount() {
  var tableProductLength = $("#productTable tbody tr").length;
  var totalSubAmount = 0;
  for(x = 0; x < tableProductLength; x++) {
    var tr = $("#productTable tbody tr")[x];
    var count = $(tr).attr('id');
    count = count.substring(3);

    totalSubAmount = Number(totalSubAmount) + Number($("#total"+count).val());
  } // /for

  totalSubAmount = totalSubAmount.toFixed(2);

  // sub total
  $("#subTotal").val(totalSubAmount);
  $("#subTotalValue").val(totalSubAmount);

  // vat
  var vat = (Number($("#subTotal").val())/100) * 18;
  vat = vat.toFixed(2);
  $("#vat").val(vat);
  $("#vatValue").val(vat);

  // total amount
  var totalAmount = (Number($("#subTotal").val()) + Number($("#vat").val()));
  totalAmount = totalAmount.toFixed(2);
  $("#totalAmount").val(totalAmount);
  $("#totalAmountValue").val(totalAmount);

  var discount = $("#discount").val();
  if(discount) {
    var grandTotal = Number($("#totalAmount").val()) - Number(discount);
    grandTotal = grandTotal.toFixed(2);
    $("#grandTotal").val(grandTotal);
    $("#grandTotalValue").val(grandTotal);
  } else {
    $("#grandTotal").val(totalAmount);
    $("#grandTotalValue").val(totalAmount);
  } // /else discount 

  var paidAmount = $("#paid").val();
  if(paidAmount) {
    paidAmount =  Number($("#grandTotal").val()) - Number(paidAmount);
    paidAmount = paidAmount.toFixed(2);
    $("#due").val(paidAmount);
    $("#dueValue").val(paidAmount);
  } else {  
    $("#due").val($("#grandTotal").val());
    $("#dueValue").val($("#grandTotal").val());
  } // else

} // /sub total amount

function discountFunc() {
  var discount = $("#discount").val();
  var totalAmount = Number($("#totalAmount").val());
  totalAmount = totalAmount.toFixed(2);

  var grandTotal;
  if(totalAmount) {   
    grandTotal = Number($("#totalAmount").val()) - Number($("#discount").val());
    grandTotal = grandTotal.toFixed(2);

    $("#grandTotal").val(grandTotal);
    $("#grandTotalValue").val(grandTotal);
  } else {
  }

  var paid = $("#paid").val();

  var dueAmount;  
  if(paid) {
    dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
    dueAmount = dueAmount.toFixed(2);

    $("#due").val(dueAmount);
    $("#dueValue").val(dueAmount);
  } else {
    $("#due").val($("#grandTotal").val());
    $("#dueValue").val($("#grandTotal").val());
  }

} // /discount function

function paidAmount() {
  var grandTotal = $("#grandTotal").val();

  if(grandTotal) {
    var dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
    dueAmount = dueAmount.toFixed(2);
    $("#due").val(dueAmount);
    $("#dueValue").val(dueAmount);
  } // /if
} // /paid amoutn function


function resetOrderForm() {
  // reset the input field
  $("#createOrderForm")[0].reset();
  // remove remove text danger
  $(".text-danger").remove();
  // remove form group error 
  $(".form-group").removeClass('has-success').removeClass('has-error');
} // /reset order form


// remove order from server
function removeOrder(orderId = null) {
  if(orderId) {
    $("#removeOrderBtn").unbind('click').bind('click', function() {
      $("#removeOrderBtn").button('loading');

      $.ajax({
        url: 'php_action/removeOrder.php',
        type: 'post',
        data: {orderId : orderId},
        dataType: 'json',
        success:function(response) {
          $("#removeOrderBtn").button('reset');

          if(response.success == true) {

            manageOrderTable.ajax.reload(null, false);
            // hide modal
            $("#removeOrderModal").modal('hide');
            // success messages
            $("#success-messages").html('<div class="alert alert-success">'+
              '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
              '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
            '</div>');

            // remove the mesages
            $(".alert-success").delay(500).show(10, function() {
              $(this).delay(3000).hide(10, function() {
                $(this).remove();
              });
            }); // /.alert            

          } else {
            // error messages
            $(".removeOrderMessages").html('<div class="alert alert-warning">'+
              '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
              '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
            '</div>');

            // remove the mesages
            $(".alert-success").delay(500).show(10, function() {
              $(this).delay(3000).hide(10, function() {
                $(this).remove();
              });
            }); // /.alert            
          } // /else

        } // /success
      });  // /ajax function to remove the order

    }); // /remove order button clicked
    

  } else {
    alert('error! refresh the page again');
  }
}
// /remove order from server

// Payment ORDER
function paymentOrder(orderId = null) {
  if(orderId) {

    $("#orderDate").datepicker();

    $.ajax({
      url: 'php_action/fetchOrderData.php',
      type: 'post',
      data: {orderId: orderId},
      dataType: 'json',
      success:function(response) {        

        // due 
        $("#due").val(response.order[10]);        

        // pay amount 
        $("#payAmount").val(response.order[10]);

        var paidAmount = response.order[9] 
        var dueAmount = response.order[10];             
        var grandTotal = response.order[8];

        // update payment
        $("#updatePaymentOrderBtn").unbind('click').bind('click', function() {
          var payAmount = $("#payAmount").val();
          var paymentType = $("#paymentType").val();
          var paymentStatus = $("#paymentStatus").val();

          if(payAmount == "") {
            $("#payAmount").after('<p class="text-danger">The Pay Amount field is required</p>');
            $("#payAmount").closest('.form-group').addClass('has-error');
          } else {
            $("#payAmount").closest('.form-group').addClass('has-success');
          }

          if(paymentType == "") {
            $("#paymentType").after('<p class="text-danger">The Pay Amount field is required</p>');
            $("#paymentType").closest('.form-group').addClass('has-error');
          } else {
            $("#paymentType").closest('.form-group').addClass('has-success');
          }

          if(paymentStatus == "") {
            $("#paymentStatus").after('<p class="text-danger">The Pay Amount field is required</p>');
            $("#paymentStatus").closest('.form-group').addClass('has-error');
          } else {
            $("#paymentStatus").closest('.form-group').addClass('has-success');
          }

          if(payAmount && paymentType && paymentStatus) {
            $("#updatePaymentOrderBtn").button('loading');
            $.ajax({
              url: 'php_action/editPayment.php',
              type: 'post',
              data: {
                orderId: orderId,
                payAmount: payAmount,
                paymentType: paymentType,
                paymentStatus: paymentStatus,
                paidAmount: paidAmount,
                grandTotal: grandTotal
              },
              dataType: 'json',
              success:function(response) {
                $("#updatePaymentOrderBtn").button('loading');

                // remove error
                $('.text-danger').remove();
                $('.form-group').removeClass('has-error').removeClass('has-success');

                $("#paymentOrderModal").modal('hide');

                $("#success-messages").html('<div class="alert alert-success">'+
                  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
                '</div>');

                // remove the mesages
                $(".alert-success").delay(500).show(10, function() {
                  $(this).delay(3000).hide(10, function() {
                    $(this).remove();
                  });
                }); // /.alert  

                // refresh the manage order table
                manageOrderTable.ajax.reload(null, false);

              } //

            });
          } // /if
            
          return false;
        }); // /update payment      

      } // /success
    }); // fetch order data
  } else {
    alert('Error ! Refresh the page again');
  }
}

</script>

<script type="text/javascript">
  


    $(document).ready(function(){

    $("#clientName").change(function(){
        var customer_id = $(this).val();
     // alert(customer_id)

        $.ajax({
            url: 'php_action/ajax_represent.php',
            type: 'post',
            data: {customer_id:customer_id},
            dataType: 'json', 
          
                        success:function(data){
              //alert();
          $("#mob_no").val(data.mob_no);
          $("#vname").val(data.vehicle_name);
          $("#vtype").val(data.vehicle_type).trigger('change');

                
            }

        });
    });

});
</script>


