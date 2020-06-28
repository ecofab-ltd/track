<?php foreach($orders AS $k => $v){ ?>
    <tr>
        <td><?php echo $v['order_code'];?></td>
        <td><?php echo $v['brand'];?></td>
        <td>
            <?php echo $v['total_quantity'];?>
        </td>
        <td>
            <table>
                <tr>
                    <td><?php echo $v['floor_name'];?></td>
                    <td>
                        <span id="floor_qty_<?php echo $k;?>"><?php echo $v['floor_quantity'];?></span>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                    <?php
                        $res = $this->method_call->getOrderUnitLinePlan($v['order_code'], $v['unit_id'], $v['floor_id']);

                        if(sizeof($res) > 0){
                        foreach ($res as $l){ ?>

                            <tr>
                                <td><?php echo $l['line_name'];?></td>
                                <td><?php echo $l['line_quantity'];?></td>
                            </tr>

                        <?php
                            }
                        }
                        ?>
            </table>
        </td>
        <td>
            <table id="table_<?php echo $k;?>">
                <tr>
                    <td>
                        <select class="form-control" name="line[]" id="line">
                            <option value="">Select Line</option>
                            <?php foreach($lines as $v_1){?>
                                <option value="<?php echo $v_1['id'];?>"><?php echo $v_1['name'];?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" readonly="readonly" autocomplete="off" class="form-control" name="order_code[]" id="order_code" value="<?php echo $v['order_code'];?>">
                    </td>
                    <td>
                        <input type="number" class="form-control line_qty" autocomplete="off" name="line_qty[]" id="line_qty" placeholder="Quantity" onblur="getPoPlanQty(<?php echo $k;?>);">
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

