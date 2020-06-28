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

    <form action="<?php echo base_url();?>Access/updateOrderInfo" method="post">
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
                                    Order Code <span style="color: red;">*</span>
                                    <input type="text" readonly="readonly" class="form-control" name="order_code" id="order_code" value="<?php echo $order_info[0]['order_code'];?>" required="required" />
                                    <input type="hidden" readonly="readonly" class="form-control" name="unit_id" id="unit_id" value="<?php echo $order_info[0]['unit_id'];?>" required="required" />
                                    <input type="hidden" readonly="readonly" class="form-control" name="upload_unit_id" id="upload_unit_id" value="<?php echo $order_info[0]['upload_unit_id'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Brand <span style="color: red;">*</span>
                                    <input type="text" readonly="readonly" class="form-control" name="brand" id="brand" value="<?php echo $order_info[0]['brand'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Purchase Order <span style="color: red;">*</span>
                                    <input type="text" class="form-control" name="purchase_order" id="purchase_order" value="<?php echo $order_info[0]['purchase_order'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Item/Destination <span style="color: red;">*</span>
                                    <input type="text" class="form-control" name="item" id="item" value="<?php echo $order_info[0]['item'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Quality <span style="color: red;">*</span>
                                    <input type="text" class="form-control" name="quality" id="quality" value="<?php echo $order_info[0]['quality'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Color <span style="color: red;">*</span>
                                    <input type="text" class="form-control" name="color" id="color" value="<?php echo $order_info[0]['color'];?>" required="required" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Style No <span style="color: red;">*</span>
                                    <input type="text" class="form-control" name="style_no" id="style_no" value="<?php echo $order_info[0]['style_no'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Style Name <span style="color: red;">*</span>
                                    <input type="text" class="form-control" name="style_name" id="style_name" value="<?php echo $order_info[0]['style_name'];?>" required="required" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>Description</span>
                                    <input type="text" class="form-control" name="description" id="description" value="<?php echo $order_info[0]['description'];?>" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Ex-Factory Date <span style="color: red;">*</span>
                                    <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" name="ex_factory_date" id="ex_factory_date"
                                           value="<?php echo $order_info[0]['ex_factory_date'];?>"
                                           <?php if($access_level != 0){ ?>readonly="readonly"<?php } ?> required="required" />
                                    <input type="hidden" class="form-control datepicker" placeholder="YYYY-mm-dd" name="previous_ex_factory_date" id="previous_ex_factory_date"
                                           value="<?php echo $order_info[0]['ex_factory_date'];?>" required="required" />
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
                                    <input type="date" class="form-control datepicker" name="fabric_in_house_date" id="fabric_in_house_date" value="<?php echo $order_info[0]['fabric_in_house_date'];?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>Accessories In House Date</span>
                                    <input type="date" class="form-control datepicker" name="accessories_in_house_date" id="accessories_in_house_date" value="<?php echo $order_info[0]['accessories_in_house_date'];?>" />
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>PP Approval Date</span>
                                    <input type="date" class="form-control datepicker" name="pp_approval_date" id="pp_approval_date" value="<?php echo $order_info[0]['pp_approval_date'];?>" />
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
                                                    <input type="text" class="form-control" name="size[]" id="size" value="<?php echo $v['size']?>" required="required">
                                                    <input type="hidden" class="form-control" name="id[]" id="id" value="<?php echo $v['id']?>" required="required">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="quantity[]" id="quantity" value="<?php echo $v['quantity']?>" onkeyup="totalQuantity();" required="required">
                                                    <input type="hidden" class="form-control" name="previous_quantity[]" id="previous_quantity" value="<?php echo $v['quantity']?>" required="required">
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
    </form>


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

function addNewRow() {
    var table_id = "size_table";

    // make a copy of an existing row. We choose the last row of table
    var rowToAdd = '<tr><td><input type="text" class="form-control" name="size[]" id="size"><input type="hidden" class="form-control" name="id[]" id="id"></td><td><input type="number" class="form-control qty" name="quantity[]" id="quantity" onkeyup="totalQuantity();" "></td><td><span class="btn btn-danger" onclick="deleteRow(this);">X</span></td></tr>';
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
