<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cutting Progress</h1>
<!--        <a href="--><?php //echo base_url()?><!--Access/orderUpload" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Upload Order</a>-->
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <div style="padding-top:10px">
                <h6 style="color:red">
                    <?php
                    $exc = $this->session->userdata('exception');
                    if (isset($exc)) {
                        echo $exc;
                        $this->session->unset_userdata('exception');
                    }
                    ?>
                </h6>

                <h6 style="color:green">
                    <?php
                    $msg = $this->session->userdata('message');
                    if (isset($msg)) {
                        echo $msg;
                        $this->session->unset_userdata('message');
                    }
                    ?>
                </h6>
            </div>
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                            <div class="form-group row">
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    Order Code
                                    <select class="form-control" id="order_code" name="order_code">
                                        <option value="">Select Order Code</option>
                                        <?php foreach ($orders AS $v_o){ ?>
                                            <option value="<?php echo $v_o['order_code'];?>"><?php echo $v_o['order_code'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Brand
                                    <select class="form-control" id="brand" name="brand" multiple="multiple">
                                        <?php foreach ($brands AS $v_b){ ?>
                                        <option value="<?php echo "'".$v_b['brand']."'";?>"><?php echo $v_b['brand'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>Ship Date From</span>
                                    <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" name="date" id="from_date" required />

                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>Ship Date To</span>
                                    <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" id="to_date" name="to_date" />
                                </div>
                                <div class="col-sm-1">
                                    <br />
                                    <button class="btn btn-primary btn-user btn-block" onclick="getOrderList()">
                                        Search
                                    </button>
                                </div>
                                <div class="col-md-1" id="loader" style="display: none;">
                                    <div class="loader"></div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <form action="<?php echo base_url();?>Access/orderCutProgressSave" method="post">
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div id="submit_form" style="display: none;">
                    <div class="form-group row">
                        <div class="col-sm-2 mb-3 mb-sm-0">
                            <span>Operation Date</span>
                            <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" name="operation_date" id="operation_date" value="<?php echo date('Y-m-d');?>" required="required" />

                        </div>
                        <div class="col-sm-1">
                            <br />
                            <button class="btn btn-primary btn-user btn-block">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dataTable_x" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="text-center">Order Code</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Order</th>
                                    <th class="text-center">Cut</th>
                                    <th class="text-center">Package</th>
                                    <th class="text-center">Size Set</th>
                                    <th class="text-center">Trial Cut</th>
                                    <th class="text-center">Bulk Cut</th>
                                    <th class="text-center">Package Ready</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                <tr>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


<script type="text/javascript">
    $('select').select2();

    $(document).on('click','#select_all',function () {
        $('.checkThis').not(this).prop('checked', this.checked);
    });

    $(document).ready(function(){

    });

    function selectAllOptions(){
        $("#brand").attr("data-select", "true").find("option").prop("selected", true);
    }

    function deselectAllOptions(){
        $("#brand").attr("data-select", "false").find("option").prop("selected", false);
    }

    function getOrderList(){
        var order_code = $("#order_code").val();
        var brands = $("#brand").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

        brands = brands != null ? brands : [];

        $("#table_body").empty();

//        if(brands.length > 0){
            $("#loader").css("display", "block");

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Access/getOrderCutProgressFilterList",
                type: "POST",
                data: {order_code: order_code, brands: brands, from_date: from_date, to_date: to_date},
                dataType: "html",
                success: function (data){
                    $("#table_body").append(data);
                    $("#loader").css("display", "none");
                    $("#submit_form").css("display", "block");
                }
            });
//        }else{
//            alert('Please Select Brand!');
//        }
    }
    
    function addNewRow(table_no) {
        var table_id = "table_"+table_no;

        // make a copy of an existing row. We choose the last row of table
        var rowToAdd = $("#"+table_id+" tr:last").clone().find('#line_qty').val('').end();
//        var rowToAdd = $("#"+table_id+" tr:last").clone();

        //add it to table
        $("#"+table_id+"").append(rowToAdd);
    }
    
    function removeThisRow(row, table_no) {
        var table_id = "table_"+table_no;

        var table = document.getElementById(table_id);
        var rowCount = table.rows.length;

        if(rowCount != 1){
            var i = row.parentNode.parentNode.rowIndex;
            document.getElementById(table_id).deleteRow(i);
        }else{
            alert("Sorry! You cannot remove all rows!");
        }
    }

    function getPoPlanQty(table_no) {

        var table_id = "table_"+table_no;
        var floor_qty = $("#floor_qty_"+table_no).text();

        console.log(floor_qty);

        var calculated_total_sum = 0;

        $("#"+table_id+" .line_qty").each(function () {
            var get_textbox_value = $(this).val();

            console.log(get_textbox_value);

            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }
        });
//            $("#total_sum_value").html(calculated_total_sum);

        if(calculated_total_sum > floor_qty){
            alert("Floor Plan Quantity is Crossed: "+calculated_total_sum+ " !");
            $("#"+table_id+" .line_qty").val('');
        }

    }

    function checkCutQtyLimit(row) {
        var cut_qty = $("#cut_qty"+row).val();
        cut_qty = (cut_qty != '' ? cut_qty : 0) * 1;

        var order_qty = $("#order_qty"+row).val();
        order_qty = (order_qty != '' ? order_qty : 0) * 1;

        var size_set_qty = $("#size_set_qty"+row).val();
        size_set_qty = (size_set_qty != '' ? size_set_qty : 0) * 1;

        var trial_qty_cut_qty = $("#trial_qty_cut_qty"+row).val();
        trial_qty_cut_qty = (trial_qty_cut_qty != '' ? trial_qty_cut_qty : 0) * 1;

        var bulk_cut_qty = $("#bulk_cut_qty"+row).val();
        bulk_cut_qty = (bulk_cut_qty != '' ? bulk_cut_qty : 0) * 1;

        var total_cut_qty = (size_set_qty+trial_qty_cut_qty+bulk_cut_qty) + cut_qty;

        var total_allowance_to_cut = order_qty + (order_qty * 0.10);

        if(total_allowance_to_cut < total_cut_qty){
            alert("You are Allowed to Cut More Than 10% of Order Qty! Your Limit is "+total_allowance_to_cut);

            $("#size_set_qty"+row).val('');
            $("#trial_qty_cut_qty"+row).val('');
            $("#bulk_cut_qty"+row).val('');

        }

    }

    function checkPackageAndCutQtyLimit(row) {
        var cut_qty = $("#cut_qty"+row).val();
        cut_qty = (cut_qty != '' ? cut_qty : 0) * 1;

        var order_qty = $("#order_qty"+row).val();
        order_qty = (order_qty != '' ? order_qty : 0) * 1;

        var size_set_qty = $("#size_set_qty"+row).val();
        size_set_qty = (size_set_qty != '' ? size_set_qty : 0) * 1;

        var trial_qty_cut_qty = $("#trial_qty_cut_qty"+row).val();
        trial_qty_cut_qty = (trial_qty_cut_qty != '' ? trial_qty_cut_qty : 0) * 1;

        var bulk_cut_qty = $("#bulk_cut_qty"+row).val();
        bulk_cut_qty = (bulk_cut_qty != '' ? bulk_cut_qty : 0) * 1;

        var total_package_ready_qty = $("#total_package_ready_qty"+row).val();
        total_package_ready_qty = (total_package_ready_qty != '' ? total_package_ready_qty : 0) * 1;

        var package_ready_qty = $("#package_ready_qty"+row).val();
        package_ready_qty = (package_ready_qty != '' ? package_ready_qty : 0) * 1;

        var total_cut_qty = (size_set_qty+trial_qty_cut_qty+bulk_cut_qty) + cut_qty;
        var gross_totall_package_ready = total_package_ready_qty + package_ready_qty;

        if(total_cut_qty < gross_totall_package_ready){
            alert("Package Ready Cannot be More than Cut Qty!");

            $("#package_ready_qty"+row).val('');
        }
    }

</script>
