<!-- Page Heading -->
<div class="row">
    <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
    <div class="col-md-10">
        <h1 class="h3 mb-0 text-gray-800">New User</h1>
    </div>
    <div class="col-md-2">
        <a href="<?php echo base_url()?>Access/userList" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-list fa-sm text-white-50"></i> User List</a>
    </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"></h1>
                        </div>
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
                        <form class="user" action="<?php echo base_url();?>Access/saveNewUser" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control" id="access_level" name="access_level" required="required" onchange="getRequiredFields();">
                                        <option value="">User Type</option>
                                        <option value="0">Administrator</option>
                                        <option value="1">Unit Planner</option>
                                        <option value="2">SD</option>
                                        <option value="3">Floor Planner</option>
                                        <option value="4">Cutting MIS</option>
                                        <option value="5">Floor MIS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row invisible" id="select_multiple_brands">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control" name="brand[]" id="brand" multiple="multiple" data-placeholder="Select Brands">
                                        <option value="">Select Brands</option>
                                        <?php foreach($brands as $b){ ?>
                                            <option value="<?php echo $b['id'];?>"><?php echo $b['brand'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="user_form"></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    function isUserAlreadyExist() {
        var username = $("#username").val();

        if(username != ''){
            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Access/isUserAlreadyExist",
                type: "POST",
                data: {username: username},
                dataType: "json",
                success: function (data){
                    if(data.length > 0){
                        alert(username+" Already Exist!");
                        location.reload();
                    }
                }
            });
        }

    }
    
    function getRequiredFields(){
        var access_level = $("#access_level").val();

        $("#user_form").empty();

        if(access_level == 2){
            $("#select_multiple_brands").removeClass( "invisible" );
        }else{
            $("#select_multiple_brands").addClass( "invisible" );
        }

        if(access_level != ''){
            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Access/getRequiredFields",
                type: "POST",
                data: {access_level: access_level},
                dataType: "html",
                success: function (data){
                    if(data != ''){
                        $("#user_form").append(data);
                    }
                }
            });
        }else{
            alert("Please Select User Type!");
        }

    }

    function getUnitFloor() {
        var access_level = $("#access_level").val();
        var unit = $("#unit").val();

        if(unit != ''){
            $("#floor").empty();

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Access/getUnitFloor",
                type: "POST",
                data: {unit: unit},
                dataType: "html",
                success: function (data){
                    if(data != ''){
                        $("#floor").append(data);
                    }
                }
            });
        }else{
            alert("Please Select Unit!");
        }
    }
</script>
