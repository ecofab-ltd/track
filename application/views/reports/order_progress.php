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
        <h1 class="h3 mb-0 text-gray-800">Order Progress</h1>
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
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Brand
                                    <select class="form-control" id="brand" name="brand" onchange="getStyles();">
                                        <option value="">Select Brand</option>
                                        <?php foreach ($brands AS $v_b){ ?>
                                        <option value="<?php echo $v_b['brand'];?>"><?php echo $v_b['brand'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Style
                                    <select class="form-control" id="style" name="style">
                                        <option value="">Select Style</option>
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

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <button class="btn btn-warning" style="color: #FFF;" id="btnExport123" onclick="ExportToExcel('dataTable_x')"><b>Export Excel</b></button>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dataTable_x" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Order Code</th>
                                    <th class="text-center">PO~Item</th>
                                    <th class="text-center">Style</th>
                                    <th class="text-center">Quality</th>
                                    <th class="text-center">Color</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">Ex-Fac</th>
                                    <th class="text-center">Fabric</th>
                                    <th class="text-center">Accessories</th>
                                    <th class="text-center">PP Approval</th>
                                    <th class="text-center">Cut Qty</th>
                                    <th class="text-center">Package Ready</th>
                                    <th class="text-center">Line Input</th>
                                    <th class="text-center">Line Output</th>
                                    <th class="text-center">Wash Send</th>
                                    <th class="text-center">Wash Rcv</th>
                                    <th class="text-center">Emb. Send</th>
                                    <th class="text-center">Emb. Rcv</th>
                                    <th class="text-center">Print Send</th>
                                    <th class="text-center">Print Rcv</th>
                                    <th class="text-center">Poly</th>
                                    <th class="text-center">Carton</th>
                                    <th class="text-center">Ship</th>
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
        var style = $("#style").val();
        var brands = $("#brand").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

//        brands = brands != null ? brands : [];

        $("#table_body").empty();

//        if(brands.length > 0){
            $("#loader").css("display", "block");

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Dashboard/getOrderProgressFilterList",
                type: "POST",
                data: {style: style, brands: brands, from_date: from_date, to_date: to_date},
                dataType: "html",
                success: function (data){
                    $("#table_body").append(data);
                    $("#loader").css("display", "none");
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

    function getStyles() {
        var brands = $("#brand").val();

//    brands = brands != null ? brands : [];

        if(brands != ''){
            $("#style").empty();
            $("#loader").css("display", "block");

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Dashboard/getStyles",
                type: "POST",
                data: {brands: brands},
                dataType: "html",
                success: function (data){
                    console.log(data);

                    $("#style").append(data);
                    $("#loader").css("display", "none");
                }
            });
        }else{
            alert('Please Select Brand!');
        }
    }

    function ExportToExcel(tableid) {
        var tab_text = "<table border='2px'><tr>";
        var textRange; var j = 0;
        tab = document.getElementById(tableid);//.getElementsByTagName('table'); // id of table
        if (tab==null) {
            return false;
        }
        if (tab.rows.length == 0) {
            return false;
        }

        for (j = 0 ; j < tab.rows.length ; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "download.xls");
        }
        else                 //other browser not tested on IE 11
        //sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            try {
                var blob = new Blob([tab_text], { type: "application/vnd.ms-excel" });
                window.URL = window.URL || window.webkitURL;
                link = window.URL.createObjectURL(blob);
                a = document.createElement("a");
                if (document.getElementById("caption")!=null) {
                    a.download=document.getElementById("caption").innerText;
                }
                else
                {
                    a.download = 'download';
                }

                a.href = link;

                document.body.appendChild(a);

                a.click();

                document.body.removeChild(a);
            } catch (e) {
            }


        return false;
        //return (sa);
    }
</script>
