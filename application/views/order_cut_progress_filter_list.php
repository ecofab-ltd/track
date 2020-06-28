<?php foreach($orders AS $k => $v){ ?>
    <tr>
        <td>
            <?php echo $v['order_code'];?>
            <input type="hidden" class="form-control" readonly="readonly" name="order_code[]" id="order_code" placeholder="Order Code" autocomplete="off" value="<?php echo $v['order_code'];?>">
        </td>
        <td><?php echo $v['brand'];?></td>
        <td>
            <?php echo $v['total_quantity'];?>
            <input type="hidden" class="form-control" readonly="readonly" name="order_qty[]" id="order_qty<?php echo $k;?>" autocomplete="off" value="<?php echo $v['total_quantity'];?>">
        </td>
        <td>
            <?php echo $v['cut_qty'];?>
            <input type="hidden" class="form-control" readonly="readonly" name="cut_qty[]" id="cut_qty<?php echo $k;?>" autocomplete="off" value="<?php echo $v['cut_qty'];?>">
        </td>
        <td>
            <?php echo $v['package_ready_qty'];?>
            <input type="hidden" class="form-control" readonly="readonly" name="total_package_ready_qty[]" id="total_package_ready_qty<?php echo $k;?>" autocomplete="off" value="<?php echo $v['package_ready_qty'];?>">
        </td>
        <td>
            <input type="text" class="form-control" name="size_set_cut_qty[]" id="size_set_qty<?php echo $k;?>" placeholder="Size Set Qty" autocomplete="off" onblur="checkCutQtyLimit(<?php echo $k;?>);">
        </td>
        <td>
            <input type="text" class="form-control" name="trial_qty_cut_qty[]" id="trial_qty_cut_qty<?php echo $k;?>" placeholder="Trial Cut Qty" autocomplete="off" onblur="checkCutQtyLimit(<?php echo $k;?>);">
        </td>
        <td>
            <input type="text" class="form-control" name="bulk_cut_qty[]" id="bulk_cut_qty<?php echo $k;?>" placeholder="Bulk Cut Qty" autocomplete="off" onblur="checkCutQtyLimit(<?php echo $k;?>);">
        </td>
        <td>
            <input type="text" class="form-control" name="package_ready_qty[]" id="package_ready_qty<?php echo $k;?>" placeholder="Package Ready Qty" autocomplete="off" onblur="checkPackageAndCutQtyLimit(<?php echo $k;?>);">
        </td>
    </tr>
<?php } ?>