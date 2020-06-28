<?php

$total_order_qty = 0;

foreach($orders AS $v){

    $total_order_qty += $v['total_quantity'];
?>
    <tr>
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
        <td><?php echo $v['fabric_in_house_date'];?></td>
        <td><?php echo $v['accessories_in_house_date'];?></td>
        <td><?php echo $v['pp_approval_date'];?></td>
        <td><?php echo $v['unit_name'];?></td>
        <td>
            <?php if($access_level == 0 || $access_level == 2){ ?>
                   <a href="<?php echo base_url()?>Access/editPoInfo/<?php echo $v['order_code'];?>" target="_blank" class="btn btn-warning">
                       EDIT
                   </a>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
    <tr style="font-size: 22px;">
        <td colspan="10" align="right">Total</td>
        <td>
            <?php echo $total_order_qty; ?>
        </td>
        <td colspan="2"></td>
    </tr>
