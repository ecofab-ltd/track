<?php foreach($orders AS $k => $v){ ?>
    <tr>
        <td><?php echo $v['order_code'];?></td>
        <td><?php echo $v['brand'];?></td>
        <td><?php echo $v['ex_factory_date'];?></td>
        <td>
            <span id="order_qty_<?php echo $k;?>"><?php echo $v['total_quantity'];?></span>
        </td>
        <td>
            <?php echo $v['unit_name'];?>
        </td>
        <td>
            <table>
                    <?php
                        $res = $this->method_call->getOrderUnitFloorPlan($v['order_code']);

                        foreach ($res as $f){ ?>

                            <tr>
                                <td><?php echo $f['floor_name'];?></td>
                                <td><?php echo $f['floor_quantity'];?></td>
                            </tr>

                        <?php
                            }
                        ?>
            </table>
        </td>
        <td>
            <table id="table_<?php echo $k;?>">
                <tr>
                    <td>
                        <select class="form-control" name="floor[]" id="floor">
                            <option value="">Select Floor</option>
                            <?php foreach($floors as $v_1){?>
                                <option value="<?php echo $v_1['id'];?>"><?php echo $v_1['name'];?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" readonly="readonly" autocomplete="off" class="form-control" name="order_code[]" id="order_code" value="<?php echo $v['order_code'];?>">
                    </td>
                    <td>
                        <input type="number" class="form-control floor_qty" autocomplete="off" name="floor_qty[]" id="floor_qty" placeholder="Quantity" onblur="getPoPlanQty(<?php echo $k;?>);">
                    </td>
                    <td>
                        <span class="btn btn-warning" onclick="addNewRow(<?php echo $k;?>);"><i class="fa fa-plus"></i></span>
                        <span class="btn btn-danger" onclick="removeThisRow(this, <?php echo $k;?>);"><i class="fa fa-minus"></i></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php } ?>

