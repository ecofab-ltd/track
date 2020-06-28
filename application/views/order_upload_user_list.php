<!-- Page Heading -->
<div class="row">
    <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
        <div class="col-md-10">
            <h1 class="h3 mb-0 text-gray-800">Users - Order Upload</h1>
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
                        <th class="text-center">User</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="table_body">

                <?php
                $sl=1;
                foreach($module_control_info AS $v){ ?>
                    <tr>
                        <td class="text-center"><?php echo $v['username'];?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url()?>Access/releaseUserFromOrderUpload/<?php echo $unit_id;?>" onclick="return confirm('Sure to release the user forcedly?');" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Force Release</a>
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
