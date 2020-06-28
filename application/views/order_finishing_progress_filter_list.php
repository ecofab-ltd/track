<?php foreach($orders AS $k => $v){ ?>
    <tr>
        <td>
            <?php echo $v['order_code'];?>
            <input type="hidden" class="form-control" name="order_code[]" id="order_code" value="<?php echo $v['order_code'];?>" readonly="readonly" autocomplete="off">
        </td>
        <td><?php echo $v['brand'];?></td>
        <td>
            <?php echo $v['total_quantity'];?>
        </td>
        <td>
            <?php echo $v['floor_quantity'];?>
        </td>
        <td>
            <?php echo $v['total_floor_line_input_qty'];?>
        </td>
        <td>
            <?php echo $v['total_floor_sew_qty'];?>
        </td>
        <td>
            <input type="number" class="form-control" name="wash_send[]" id="wash_send" autocomplete="off" value="<?php echo $v['total_wash_send_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="wash_rcv[]" id="wash_rcv" autocomplete="off" value="<?php echo $v['total_wash_receive_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="emb_send[]" id="emb_send" autocomplete="off" value="<?php echo $v['total_embroidery_send_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="emb_rcv[]" id="emb_rcv" autocomplete="off" value="<?php echo $v['total_embroidery_receive_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="print_send[]" id="print_send" autocomplete="off" value="<?php echo $v['total_print_send_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="print_rcv[]" id="print_rcv" autocomplete="off" value="<?php echo $v['total_print_receive_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="poly_qty[]" id="poly_qty" autocomplete="off" value="<?php echo $v['total_poly_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="carton_qty[]" id="carton_qty" autocomplete="off" value="<?php echo $v['total_carton_qty'];?>">
        </td>
        <td>
            <input type="number" class="form-control" name="ship_qty[]" id="ship_qty" autocomplete="off" value="<?php echo $v['total_ship_qty'];?>">
        </td>
    </tr>
<?php } ?>