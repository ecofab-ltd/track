<?php foreach($orders AS $k => $v){ ?>
    <tr>
        <td><?php echo $v['order_code'];?></td>
        <td><?php echo $v['brand'];?></td>
        <td>
            <?php echo $v['total_quantity'];?>
        </td>
        <td>
            <table>
                    <?php
                        $res = $this->method_call->getOrderUnitLinePlan($v['order_code'], $v['floor_id']);

                        foreach ($res as $l){ ?>

                            <tr>
                                <td><?php echo $l['line_name'];?></td>
                                <td><?php echo $l['line_quantity'];?></td>
                                <td>
                                    <input type="text" class="form-control" name="line_output[]" id="line_output" placeholder="Line Output" autocomplete="off">
                                </td>
                            </tr>

                        <?php
                            }
                        ?>
            </table>
        </td>
        <td>
            <input type="text" class="form-control" name="washed_qty[]" id="washed_qty" placeholder="Washed Qty" autocomplete="off">
        </td>
        <td>
            <input type="text" class="form-control" name="carton_qty[]" id="carton_qty" placeholder="Carton Qty" autocomplete="off">
        </td>
    </tr>
<?php } ?>

