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
        <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800">Edit Order</h1>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="form-group row">
                            <div class="col-sm-1">
                                <br />
                                <button class="btn btn-primary btn-user btn-block" onclick="getOrderList()">
                                    UPDATE
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Order Code</span>
                                <input type="text" readonly="readonly" class="form-control" name="order_code" id="order_code" value="<?php echo $order_info[0]['order_code'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                Brand <span style="color: red;">*</span>
                                <input type="text" readonly="readonly" class="form-control" name="brand" id="brand" value="<?php echo $order_info[0]['brand'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Purchase Order</span>
                                <input type="text" class="form-control" name="purchase_order" id="purchase_order" value="<?php echo $order_info[0]['purchase_order'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Item/Destination</span>
                                <input type="text" class="form-control" name="item" id="item" value="<?php echo $order_info[0]['item'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Quality</span>
                                <input type="text" class="form-control" name="quality" id="quality" value="<?php echo $order_info[0]['quality'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Color</span>
                                <input type="text" class="form-control" name="color" id="color" value="<?php echo $order_info[0]['color'];?>" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Style No</span>
                                <input type="text" class="form-control" name="style_no" id="style_no" value="<?php echo $order_info[0]['style_no'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Style Name</span>
                                <input type="text" class="form-control" name="style_name" id="style_name" value="<?php echo $order_info[0]['style_name'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Description</span>
                                <input type="text" class="form-control" name="description" id="description" value="<?php echo $order_info[0]['description'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Ex-Factory Date</span>
                                <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" name="date" id="from_date"
                                       value="<?php echo $order_info[0]['ex_factory_date'];?>"
                                       <?php if($access_level != 0){ ?>readonly="readonly"<?php } ?> required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <?php
                                    $total_qty = 0;
                                    foreach ($order_info as $q){
                                        $total_qty += $q['quantity'];
                                    }
                                ?>
                                <span>Total Quantity</span>
                                <input type="text" class="form-control" readonly="readonly" name="total_qty" id="total_qty" value="<?php echo $total_qty;?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Fabric In House Date</span>
                                <input type="date" class="form-control datepicker" name="fabric_in_house_date" id="fabric_in_house_date" value="<?php echo $order_info[0]['fabric_in_house_date'];?>" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>Accessories In House Date</span>
                                <input type="date" class="form-control datepicker" name="accessories_in_house_date" id="accessories_in_house_date" value="<?php echo $order_info[0]['accessories_in_house_date'];?>" required />
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <span>PP Approval Date</span>
                                <input type="date" class="form-control datepicker" name="pp_approval_date" id="pp_approval_date" value="<?php echo $order_info[0]['pp_approval_date'];?>" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->

                <!-- DataTales Example -->
                <div class="col-sm-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x:auto;">
                                <table class="table table-bordered" id="size_table" width="80%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>
                                                <span class="btn btn-success" onclick="addNewRow()">+</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    <?php foreach($order_info AS $k => $v){?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="size[]" id="size" value="<?php echo $v['size']?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control qty" name="quantity[]" id="quantity" value="<?php echo $v['quantity']?>" onkeyup="totalQuantity();">
                                                <input type="hidden" class="form-control" name="previous_quantity[]" id="previous_quantity" value="<?php echo $v['quantity']?>">
                                            </td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<script type="text/javascript">
    $('select').select2();

$(document).ready(function () {
    $('input[class$=datepicker]').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});

$(function(){
    $('.datepicker').datepicker({
        inline: true,
        //nextText: '&rarr;',
        //prevText: '&larr;',
        showOtherMonths: true,
        //dateFormat: 'dd MM yy',
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        //showOn: "button",
        //buttonImage: "img/calendar-blue.png",
        //buttonImageOnly: true,
    });
});

function selectAllOptions(){
    $("#brand").attr("data-select", "true").find("option").prop("selected", true);
}

function deselectAllOptions(){
    $("#brand").attr("data-select", "false").find("option").prop("selected", false);
}

function getStyles() {
    var brands = $("#brand").val();

//    brands = brands != null ? brands : [];

    if(brands != ''){
        $("#style").empty();
        $("#loader").css("display", "block");

        $.ajax({
            async: false,
            url: "<?php echo base_url();?>Access/getStyles",
            type: "POST",
            data: {brands: brands},
            dataType: "html",
            success: function (data){
                $("#style").append(data);
                $("#loader").css("display", "none");
            }
        });
    }else{
        alert('Please Select Brand!');
    }
}

function getOrderList() {
    var style = $("#style").val();
    var brands = $("#brand").val();
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();

//    brands = brands != null ? brands : [];

    $("#table_body").empty();

    if(brands != ''){
        $("#loader").css("display", "block");

        $.ajax({
            async: false,
            url: "<?php echo base_url();?>Access/getOrderList",
            type: "POST",
            data: {style: style, brands: brands, from_date: from_date, to_date: to_date},
            dataType: "html",
            success: function (data){
                $("#table_body").append(data);
                $("#loader").css("display", "none");
            }
        });
    }else{
        alert('Please Select Brand!');
    }

}

function addNewRow() {
    var table_id = "size_table";

    // make a copy of an existing row. We choose the last row of table
    var rowToAdd = '<tr><td><input type="text" class="form-control" name="size[]" id="size"></td><td><input type="number" class="form-control qty" name="quantity[]" id="quantity" onkeyup="totalQuantity();" "></td><td><span class="btn btn-danger" onclick="deleteRow(this);">X</span></td></tr>';
//    var rowToAdd = $("#"+table_id+" tr:last").clone();

    //add it to table
    $("#size_table").append(rowToAdd);
}


function deleteRow(row)
{
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById('size_table').deleteRow(i);

    totalQuantity();
}

function totalQuantity() {
    var sum = 0;
    $(".qty").each(function(){
        sum += +$(this).val();
    });
    $("#total_qty").val(Math.round(sum));
}

</script>
