<?php include('./constant/layout/head.php');?>
<!--  Author Name- Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website - solutiontechservices.com -->

<?php include('./constant/layout/header.php');?>

<?php //include('./constant/layout/sidebar.php');?>  
<style>
    input[type="date"] {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 15px;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
        padding: 20px 25px;
    }

    .form-group label {
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .form-group label i {
        margin-right: 8px;
        color: #007bff;
    }

    .form-control {
        border-radius: 6px;
        font-size: 14px;
    }

    .btn i {
        margin-right: 6px;
    }

    #formErrorMessages {
        font-weight: bold;
    }

    .btn-primary {
        padding: 10px 20px;
    }

    .btn-success {
        padding: 10px 20px;
    }
    .bg-dark-blue {
        background-color: #4682B4; /* Dark blue shade */
        color: #fff;
    }
</style>

 
        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Datewise Report Management</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Datewise Report</li>
                    </ol>
                </div>
            </div>
            
            
            <!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->

<div class="container-fluid">
                
                
                
                
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-dark-blue text-white">
                <h4 class="mb-0">Generate Datewise Report</h4>
            </div>
            <div class="card-body">
                <form action="php_action/getOrderReport.php" method="post" id="getOrderReportForm">
                    <div class="form-group row m-t-40">
                    <label for="startDate" class="col-sm-3 col-form-label"><i class="fa fa-calendar"></i> Start Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="startDate" name="startDate" />
                        </div>
                    </div>

                    <div class="form-group row">
                    <label for="endDate" class="col-sm-3 col-form-label"><i class="fa fa-calendar-check-o"></i> End Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="endDate" name="endDate" />
                        </div>
                    </div>

                    <div class="form-group text-center mt-4">
    <button type="submit" id="generateReportBtn" class="btn btn-primary">
        <i class="fa fa-file-text"></i> Generate Report
    </button>
    <button type="button" id="exportExcelBtn" class="btn btn-success ml-3">
        <i class="fa fa-file-excel-o"></i> Export to Excel
    </button>
</div>

                </form>
                <div id="formErrorMessages" class="alert alert-danger mt-3" style="display: none;"></div>

            </div>
        </div>
    </div>
</div>
</div>
                
    <script>
       $(document).ready(function () {
    $("#getOrderReportForm").on("submit", function (e) {
        e.preventDefault();

        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        const errorDiv = $("#formErrorMessages");

        if (!startDate || !endDate) {
            errorDiv.text("Both Start Date and End Date are required.");
            errorDiv.show();
            return;
        } 

        errorDiv.hide();

        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                const win = window.open("", "Print Report", "height=600,width=800");
                win.document.write("<html><head><title>Report</title></head><body>");
                win.document.write(response);
                win.document.write("</body></html>");
                win.document.close();
                win.focus();
                win.print();
                win.close();
            }
        });
    });
});

    </script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const exportBtn = document.getElementById("exportExcelBtn");
    let errorDiv = $("#formErrorMessages");

    exportBtn.addEventListener("click", function () {

        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        if (!startDate || !endDate) {
    errorDiv.text("Both Start Date and End Date are required.");
    errorDiv.show();
    return;
}
errorDiv.hide();


        // Redirect to export script with query parameters
        window.location.href = 'php_action/exportOrderReportExcel.php?startDate=' + encodeURIComponent(startDate) + '&endDate=' + encodeURIComponent(endDate);
    });
});
</script>


<!--  Author Name: Solution Tech Services 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : solutiontechservices.com -->
<?php include('./constant/layout/footer.php');?>


