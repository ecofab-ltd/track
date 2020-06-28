<?php foreach($orders AS $v){ ?>
    <tr>
        <td><input type="checkbox" class="checkThis" name="select_order[]" id="select_order" style="width: 20px; height: 20px;" value="<?php echo $v['order_code'];?>"></td>
        <td><?php echo $v['order_code'];?></td>
        <td><?php echo $v['purchase_order'];?></td>
        <td><?php echo $v['item'];?></td>
        <td><?php echo $v['quality'];?></td>
        <td><?php echo $v['color'];?></td>
        <td><?php echo $v['style_no'];?></td>
        <td><?php echo $v['style_name'];?></td>
        <td><?php echo $v['description'];?></td>
        <td><?php echo $v['brand'];?></td>
        <td><?php echo $v['ex_factory_date'];?></td>
        <td><?php echo $v['total_quantity'];?></td>
        <td>
            <?php echo $v['unit_name'];?>
        </td>
    </tr>
<?php } ?>

