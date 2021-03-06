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
        <h1 class="h3 mb-0 text-gray-800">Unit Assign</h1>
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
                                    Select Brand <span style="color: red;">*</span>
                                    <select class="form-control" id="brand" name="brand" multiple="multiple">
                                        <?php foreach ($brands AS $v_b){ ?>
                                        <option value="<?php echo "'".$v_b['brand']."'";?>"><?php echo $v_b['brand'];?></option>
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
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    <span>From Date</span>
                                    <input type="date" class="form-control datepicker" placeholder="YYYY-mm-dd" name="date" id="from_date" required />

                                </div>
                                <div class="col-sm-3 mb-3 mb-sm-0">
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

            <form action="<?php echo  base_url()?>Access/orderAssignUnitSave" method="post">
            <div class="row" style="margin-top: -60px;">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                Select Unit <span style="color: red;">*</span>
                                <select class="form-control" id="unit" name="unit" required="required">
                                    <option value="">Select Unit</option>
                                    <?php foreach ($units AS $v_u){ ?>
                                        <option value="<?php echo $v_u['id'];?>"><?php echo $v_u['name'];?></option>
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
                            <div class="col-sm-1">
                                <br />
                                <button class="btn btn-success btn-user btn-block">
                                    Save
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
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-bordered" id="dataTable_x" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" class="" name="select_all" id="select_all" style="width: 20px; height: 20px;"></th>
                                    <th class="text-center">Order Code</th>
                                    <th class="text-center">Purchase Order</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Quality</th>
                                    <th class="text-center">Color</th>
                                    <th class="text-center">Style</th>
                                    <th class="text-center">Style Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">ExFac</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit</th>
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
            </form>
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

    function getOrderList() {
        var brands = $("#brand").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

        brands = brands != null ? brands : [];

        $("#table_body").empty();

        if(brands.length > 0){
            $("#loader").css("display", "block");

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Access/getOrderUnitAssignFilterList",
                type: "POST",
                data: {brands: brands, from_date: from_date, to_date: to_date},
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

</script>
