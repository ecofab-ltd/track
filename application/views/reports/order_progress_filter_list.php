<?php foreach($orders AS $k => $v){ ?>
    <tr>
        <td class="text-center"><?php echo $v['brand'];?></td>
        <td class="text-center"><?php echo $v['order_code'];?></td>
        <td class="text-center"><?php echo $v['purchase_order'].'~'.$v['item'];?></td>
        <td class="text-center"><?php echo $v['style_name'];?></td>
        <td class="text-center"><?php echo $v['quality'];?></td>
        <td class="text-center"><?php echo $v['color'];?></td>
        <td class="text-center"><?php echo $v['total_qty'];?></td>
        <td class="text-center"><?php echo $v['ex_factory_date'];?></td>
        <td class="text-center"><?php echo $v['fabric_in_house_date'];?></td>
        <td class="text-center"><?php echo $v['accessories_in_house_date'];?></td>
        <td class="text-center"><?php echo $v['pp_approval_date'];?></td>
        <td class="text-center"><?php echo $v['cut_qty'];?></td>
        <td class="text-center"><?php echo $v['package_ready_qty'];?></td>
        <td class="text-center"><?php echo $v['line_input_qty'];?></td>
        <td class="text-center"><?php echo $v['line_output_qty'];?></td>
        <td class="text-center"><?php echo $v['wash_send_qty'];?></td>
        <td class="text-center"><?php echo $v['wash_receive_qty'];?></td>
        <td class="text-center"><?php echo $v['embroidery_send_qty'];?></td>
        <td class="text-center"><?php echo $v['embroidery_receive_qty'];?></td>
        <td class="text-center"><?php echo $v['print_send_qty'];?></td>
        <td class="text-center"><?php echo $v['print_receive_qty'];?></td>
        <td class="text-center"><?php echo $v['poly_qty'];?></td>
        <td class="text-center"><?php echo $v['carton_qty'];?></td>
        <td class="text-center"><?php echo $v['ship_qty'];?></td>
    </tr>
<?php } ?>

