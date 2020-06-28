<?php
$username = $user_info[0]['username'];
$password = $user_info[0]['password'];
$access_level = $user_info[0]['access_level'];
$unit_id = $user_info[0]['unit_id'];
$floor_id = $user_info[0]['floor_id'];
$status = $user_info[0]['status'];
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
    <div class="col-md-10">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
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
                        <form class="user" action="<?php echo base_url();?>Access/updateUser" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control" id="access_level" disabled="disabled" required="required" onchange="getRequiredFields();">
                                        <option value="">User Type</option>
                                        <option value="0">Administrator</option>
                                        <option value="1">Planner</option>
                                        <option value="2">SD</option>
                                        <option value="3" selected="selected">Floor Planner</option>
                                    </select>
                                    <input type="hidden" class="form-control" name="access_level" value="<?php echo $access_level;?>">
                                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $user_id;?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" value="<?php echo $username;?>" placeholder="Username" autocomplete="off" required="required" onblur="isUserAlreadyExist()" readonly="readonly">
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="password" name="password" value="<?php echo $password;?>" placeholder="Password" autocomplete="off" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control" name="unit" id="unit" required="required" onchange="getUnitFloor();">
                                        <option value="">Select Unit</option>
                                        <?php foreach($units as $u){ ?>
                                            <option value="<?php echo $u['id'];?>"
                                                <?php echo ($u['id'] == $unit_id ? 'selected="selected"' : '');?>>
                                                <?php echo $u['name'];?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control" name="floor" id="floor" required="required">
                                        <option value="">Select Floor</option>
                                        <?php foreach($floors as $f){ ?>
                                            <option value="<?php echo $f['id'];?>"
                                                <?php echo ($f['id'] == $floor_id ? 'selected="selected"' : '');?>>
                                                <?php echo $f['name'];?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control" name="status" id="status" required="required">
                                        <option value="">Select Status</option>
                                        <option value="1" <?php echo ($status == 1 ? 'selected="selected"' : '');?>>Active</option>
                                        <option value="0" <?php echo ($status == 0 ? 'selected="selected"' : '');?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <br />
                                    <button class="btn btn-primary btn-user btn-block">
                                        Update
                                    </button>
                                </div>
                            </div>

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
            alert("Please Select USer Type!");
        }

    }

    function getUnitFloor() {
        var access_level = $("#access_level").val();
        var unit = $("#unit").val();

        if(unit != '' && access_level == 3){
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
