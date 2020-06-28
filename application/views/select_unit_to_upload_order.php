<!-- Page Heading -->
<div class="row">
    <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">Select Unit - Order Upload</h1>
        </div>
        <div class="col-md-4">
            <a href="<?php echo base_url()?>Access/orderList" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-list fa-sm text-white-50"></i> Order List</a>
            <a href="<?php echo base_url()?>uploads/file_format.xls" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> File Format</a>
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

            <div class="row">
                <?php foreach ($units as $u){ ?>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4" onclick="orderUpload(<?php echo $u['id'];?>)" style="cursor: pointer;">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2" style="text-align: center">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $u['name']?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
</div>




<script type="text/javascript">

    function orderUpload(unit_id){

        window.location.href = "<?php echo base_url()?>Access/orderUpload/"+unit_id;
    }

</script>
