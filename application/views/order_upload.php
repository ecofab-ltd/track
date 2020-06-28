<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12 d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800">Upload Order</h1>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url()?>Access/orderList" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-list fa-sm text-white-50"></i> Order List</a>
                <a href="<?php echo base_url()?>uploads/file_format.xls" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> File Format</a>
            </div>
            </div>
        </div>


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
                        <form class="user" action="<?php echo base_url();?>Access/uploadOrders" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-5 mb-3 mb-sm-0">
                                    <select class="form-control" id="brand" name="brand" required="required">
                                        <option value="">Select Brand</option>
                                        <?php foreach($brand as $v){ ?>
                                        <option value="<?php echo $v['brand'];?>"><?php echo $v['brand'];?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" name="unit_id" id="unit_id" value="<?php echo $unit_id;?>" readonly="readonly" required="required" />
                                </div>
                                <div class="col-sm-5 mb-3 mb-sm-0">
                                    <input type="file" class="form-control" id="file" name="file" required="required">
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-user btn-block">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
