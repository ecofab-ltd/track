<!-- Page Heading -->
<div class="row">
    <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
    <div class="col-md-10">
        <h1 class="h3 mb-0 text-gray-800">New Brand</h1>
    </div>
    <div class="col-md-2">
        <a href="<?php echo base_url()?>Access/brandList" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-list fa-sm text-white-50"></i> Brand List</a>
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
                        <form class="user" action="<?php echo base_url();?>Access/saveNewBrand" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    Brand Name <span style="color: red;">*</span>
                                    <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand Name" autocomplete="off" autofocus="autofocus" required="required" onblur="isBrandAlreadyExist()">
                                </div>
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    Status <span style="color: red;">*</span>
                                    <select class="form-control" name="status" id="status" required="required">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <br />
                                    <button class="btn btn-primary btn-user btn-block">
                                        Save
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
    function isBrandAlreadyExist() {
        var brand = $("#brand").val();

        if(brand != ''){
            $.ajax({
                async: false,
                url: "<?php echo base_url();?>Access/isBrandAlreadyExist",
                type: "POST",
                data: {brand: brand},
                dataType: "json",
                success: function (data){
                    if(data.length > 0){
                        alert(brand+" Already Exist!");
                        location.reload();
                    }
                }
            });
        }

    }
</script>
