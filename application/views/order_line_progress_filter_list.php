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
                    <td class="text-center"></td>
                    <td class="text-center">PLAN</td>
                    <td class="text-center">
                        INPUT
                    </td>
                    <td class="text-center">
                        OUTPUT
                    </td>
                </tr>
                <?php
                $res = $this->method_call->getOrderUnitLinePlanOutput($v['order_code'], $v['unit_id'], $v['floor_id']);

                foreach ($res as $l){ ?>

                    <tr>
                        <td><?php echo $l['line_name'];?></td>
                        <td><?php echo $l['line_quantity'];?></td>
                        <td>
                            <?php echo $l['line_input_qty'];?>
                        </td>
                        <td>
                            <?php echo $l['line_sew_output'];?>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            </table>
        </td>
        <td>
            <table>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">PLAN</td>
                        <td class="text-center">
                            INPUT
                        </td>
                        <td class="text-center">
                            OUTPUT
                        </td>
                    </tr>

                    <?php
                        $res2 = $this->method_call->getOrderUnitLinePlanOutputByOperationDate($v['order_code'], $v['unit_id'], $v['floor_id'], $operation_date);

                        foreach ($res2 as $l2){ ?>

                            <tr>
                                <td>
                                    <?php echo $l2['line_name'];?>
                                    <input type="hidden" class="form-control" name="line_id[]" id="line_id" placeholder="Line" readonly="readonly" autocomplete="off" value="<?php echo $l2['line_id'];?>">
                                    <input type="hidden" class="form-control" name="order_code[]" id="order_code" placeholder="Order Code" readonly="readonly" autocomplete="off" value="<?php echo $v['order_code'];?>">
                                </td>
                                <td><?php echo $l2['line_quantity'];?></td>
                                <td>
                                    <input type="text" class="form-control" name="line_input[]" id="line_input" placeholder="Line Input" autocomplete="off" value="<?php echo $l2['line_input_qty'];?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="line_output[]" id="line_output" placeholder="Line Output" autocomplete="off" value="<?php echo $l2['line_sew_output'];?>">
                                </td>
                            </tr>

                        <?php
                            }
                        ?>
            </table>
        </td>
    </tr>
<?php } ?>

