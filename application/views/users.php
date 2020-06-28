<!-- Page Heading -->
<div class="row">
    <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
        <div class="col-md-10">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>
        <div class="col-md-2">
            <a href="<?php echo base_url()?>Access/addNewUser" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> New User</a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card border-0 shadow-lg">
        <div class="card-body">
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable_x" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Password</th>
                        <th class="text-center">User Type</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Floor</th>
                        <th class="text-center">Brands</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="table_body">

                <?php
                $sl=1;
                foreach($users AS $v){ ?>
                    <tr>
                        <td class="text-center"><?php echo $sl;?></td>
                        <td class="text-center"><?php echo $v['username'];?></td>
                        <td class="text-center"><?php echo $v['password'];?></td>
                        <td class="text-center">
                            <?php
                                if($v['access_level'] == 0){
                                    echo 'Administrator';
                                }
                                if($v['access_level'] == 1){
                                    echo 'Unit Planner';
                                }
                                if($v['access_level'] == 2){
                                    echo 'SD';
                                }
                                if($v['access_level'] == 3){
                                    echo 'Floor Planner';
                                }
                                if($v['access_level'] == 4){
                                    echo 'Cutting MIS';
                                }
                                if($v['access_level'] == 5){
                                    echo 'Floor MIS';
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if($v['unit_id'] > 0){
                                    $res_unit = $this->method_call->getUnit($v['unit_id']);
                                    echo $res_unit[0]['name'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if($v['floor_id'] > 0){
                                    $res_floor = $this->method_call->getFloor($v['floor_id']);
                                    echo $res_floor[0]['name'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                $brands = $this->method_call->getAuthorizedBrands($v['id']);

                                foreach ($brands as $b){
                                    echo $b['brand'].'<br />';
                                }
                            ?>
                        </td>
                        <td class="text-center"><?php echo (($v['status'] == 1) ? 'Active' : (($v['status'] == 0) ? 'Inactive' : ''));?></td>
                        <td class="text-center">
                            <?php
                                if($v['status'] == 1){ ?>
                                    <a href="<?php echo base_url();?>Access/changeUserStatus/<?php echo $v['id']?>/0" class="btn btn-danger">
                                        <i class="fas fa-arrow-circle-down fa-sm text-white-50"></i> Inactive
                                    </a>
                                <?php }

                                if($v['status'] == 0){ ?>
                                    <a href="<?php echo base_url();?>Access/changeUserStatus/<?php echo $v['id']?>/1" class="btn btn-success">
                                        <i class="fas fa-arrow-circle-up fa-sm text-white-50"></i> Active
                                    </a>
                                <?php }
                            ?>
                            <a href="<?php echo base_url();?>Access/editUser/<?php echo $v['id']?>/<?php echo $v['access_level']?>" class="btn btn-primary">
                                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php
                $sl++;
                }
                ?>

                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
//    $('select').select2();

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
            url: "<?php echo base_url();?>access/getOrderList",
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
