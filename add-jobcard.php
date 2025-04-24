<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>
<link rel="stylesheet" href="custom/js/order.js">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php include('./constant/connect.php'); ?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Home /</a></li>
  <li>Job Card</li>
  <li class="active">Add Job Card</li>
</ol>

<h4><i class='glyphicon glyphicon-circle-arrow-right'></i> Add Job Card</h4>

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
        <div class="card">
          <div class="card-body">
            <div class="input-states">
              <form class="form-horizontal" method="POST" action="php_action/createJobcard.php" id="createJobcardForm">
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Job Card No</label>
                    <div class="col-sm-4">
                      <?php
                      $sql = "SELECT COUNT(*) as cnt FROM job_card";
                      $row = $connect->query($sql)->fetch_assoc();
                      $new = sprintf('JC%05d', intval($row['cnt'])+1);
                      ?>
                      <input type="text" class="form-control" value="<?php echo $new; ?>" readonly />
                    </div>

                    <label class="col-sm-2 control-label">Date/Time In</label>
                    <div class="col-sm-4">
                      <input type="datetime-local" class="form-control" name="orderDate" required />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Client Name</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" name="clientName" id="clientName">
                        <option value="">~~SELECT~~</option>
                        <?php
                        $sql = "SELECT * FROM tbl_client WHERE delete_status = 0";
                        $result = $connect->query($sql);
                        while($row = $result->fetch_array()) {
                          echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                      </select>
                    </div>

                    <label class="col-sm-2 control-label">Client Contact</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="clientContact" id="mob_no" required />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Vehicle Type</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" name="vtype" id="vtype">
                        <option value="">~~SELECT~~</option>
                        <option value="twowheeler">Two Wheeler</option>
                        <option value="threewheeler">Three Wheeler</option>
                        <option value="fourwheeler">Four Wheeler</option>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">Vehicle Number</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="vname"  id="vname" required />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Mechanic Name</label>
                    <div class="col-sm-4">
                      <input type="text" name="mname" class="form-control" required />
                    </div>
                    <label class="col-sm-2 control-label">Supervisor Name</label>
                    <div class="col-sm-4">
                      <input type="text" name="sname" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Date/Time Out</label>
                    <div class="col-sm-4">
                      <input type="datetime-local" class="form-control" name="deliverydate" />
                    </div>
                    <label class="col-sm-2 control-label">Pick-up & Drop</label>
                    <div class="col-sm-4">
                      <input type="checkbox" name="pickup_drop" /> Yes
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Pick-up Person</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="pickup_person" />
                    </div>
                    <label class="col-sm-2 control-label">Floor Mat</label>
                    <div class="col-sm-2">
                      <input type="checkbox" name="floor_mat" />
                    </div>
                    <label class="col-sm-2 control-label">Cut Mat</label>
                    <div class="col-sm-2">
                      <input type="checkbox" name="cut_mat" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Items in Car</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="items_in_car"></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Odometer</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="odometer" />
                    </div>
                    <label class="col-sm-2 control-label">Fuel Level</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="fuel" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Dents / Scratches Map</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="dents_map"></textarea>
                    </div>
                  </div>
                </div>

                <!-- Pricing Section -->
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Sub Total</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="subTotalValue" />
                    </div>
                    <label class="col-sm-2 control-label">GST</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="vatValue" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Total</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="totalAmountValue" />
                    </div>
                    <label class="col-sm-2 control-label">Discount</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="discount" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Grand Total</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="grandTotalValue" />
                    </div>
                    <label class="col-sm-2 control-label">Paid</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="paid" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Due</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dueValue" />
                    </div>
                    <label class="col-sm-2 control-label">GSTN</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="gstn" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Payment Type</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="paymentType">
                        <option value="">~~SELECT~~</option>
                        <option value="1">Cheque</option>
                        <option value="2">Cash</option>
                        <option value="3">Credit Card</option>
                        <option value="4">PhonePe</option>
                        <option value="5">Google Pay</option>
                        <option value="6">Amazon Pay</option>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">Payment Status</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="paymentStatus">
                        <option value="">~~SELECT~~</option>
                        <option value="1">Full Payment</option>
                        <option value="2">Advance Payment</option>
                        <option value="3">No Payment</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">Payment Place</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="paymentPlace">
                        <option value="">~~SELECT~~</option>
                        <option value="1">In India</option>
                        <option value="2">Out Of India</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group submitButtonFooter">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('./constant/layout/footer.php');?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $(".select2").select2();

    $("#clientName").change(function() {
      var customer_id = $(this).val();
      $.ajax({
        url: 'php_action/ajax_represent.php',
        type: 'post',
        data: { customer_id: customer_id },
        dataType: 'json',
        success: function(data) {
          $("#mob_no").val(data.mob_no);
          $("#vname").val(data.vehicle_name);
          $("#vtype").val(data.vehicle_type).trigger('change');
        }
      });
    });
  });
</script>
