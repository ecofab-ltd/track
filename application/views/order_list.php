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
                <h1 class="h3 mb-0 text-gray-800">Order List</h1>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url()?>Access/selectUnitToUploadOrder" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Upload Order</a>
                <a href="<?php echo base_url()?>uploads/file_format.xls" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> File Format</a>
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
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    Select Brand <span style="color: red;">*</span>
                                    <select class="form-control" id="brand" name="brand" onchange="getStyles();">
                                        <option value="">Brand</option>
                                        <?php foreach ($brands AS $v_b){ ?>
                                            <option value="<?php echo $v_b['brand'];?>"><?php echo $v_b['brand'];?></option>
                                        <?php } ?>
                                    </select>
                                    <!--                                    <div class="row" style="margin-top: 5px;">-->
                                    <!--                                        <div class="col-sm-6">-->
                                    <!--                                            <span class="btn btn-success" style="cursor: pointer;" onclick="selectAllOptions();">Select All</span>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-sm-6">-->
                                    <!--                                            <span class="btn btn-danger" style="cursor: pointer;" onclick="deselectAllOptions();">Deselect All</span>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>Style</span>
                                    <select class="form-control" id="style" name="style">
                                        <option value="">Style</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>From Date</span>
                                    <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" name="date" id="from_date" required />

                                </div>
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <span>To Date</span>
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

                <!-- DataTales Example -->
                <button class="btn btn-warning" style="color: #FFF;" id="btnExport123" onclick="ExportToExcel('dataTable_x')"><b>Export Excel</b></button>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dataTable_x" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order Code</th>
                                        <th>Purchase Order</th>
                                        <th>Item</th>
                                        <th>Quality</th>
                                        <th>Color</th>
                                        <th>Style</th>
                                        <th>Style Name</th>
                                        <th>Description</th>
                                        <th>Brand</th>
                                        <th>ExFac</th>
                                        <th>Quantity</th>
                                        <th>Fabric</th>
                                        <th>Accessories</th>
                                        <th>PP Approval</th>
                                        <th>Unit</th>
                                        <th>Action</th>
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
