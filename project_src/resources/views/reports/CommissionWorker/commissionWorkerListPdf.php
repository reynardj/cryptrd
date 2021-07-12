<style type="text/css">
    body{
        font-size: 10px;
    }
</style>
<table style="width:100%;">
    <tr>
        <td colspan="27"><?='Date Selection: ' . $_GET['start_date'] . ' - ' . $_GET['end_date']?></td>
    </tr>
    <tr>
        <td colspan="27"><?='Filtered By: ' . $_GET['grouping_by_text']?></td>
    </tr>
    <tr>
        <td colspan="27"><?='Worker Name: ' . $commission_worker_name?></td>
    </tr>
</table>
<table cellpadding="2" border="1" style="border: 1px solid black; border-collapse: collapse;">
    <thead>
    <tr>
        <?php
        $count_gross_total_index = 1;
        $gross_total_index = 0;
        $count_commission_base_value_index = 1;
        $commission_base_value_index = 0;
        $count_drv_omzet_prorated_index = 1;
        $drv_omzet_prorated_index = 0;
        $count_total_commission_index = 1;
        $total_commission_index = 0;
        $columns = array(
            'trx_id' => '<th>Trx ID</th>',
            'local_trx_id' => '<th>PO No.</th>',
            'user_name' => '<th>Customer</th>',
            'created_at' => '<th>Date & Time</th>',
            'category_name' => '<th>Category</th>',
            'package_name' => '<th>Package</th>',
            'item_nature' => '<th>Service / Retail</th>',
            'is_custom' => '<th>Custom Item</th>',
            'item_notes' => '<th>Item Notes</th>',
            'item_name' => '<th>Item</th>',
            'variant_name' => '<th>Variant</th>',
            'package_qty' => '<th>Package Qty</th>',
            'qty' => '<th>Qty</th>',
            'gross_total' => '<th>Gross Total</th>',
            'coupon_selling_price' => '<th>Coupon Selling Price</th>',
            'item_discount_value' => '<th>Discount on Item</th>',
            'trx_discount_value' => '<th>Discount on Transaction</th>',
            'loyalty_discount_value' => '<th>Member Discount</th>',
            'redeem_discount_value' => '<th>Redeem Item Discount</th>',
            'redeem_discount_trx' => '<th>Redeem Item Disc. Trx</th>',
            'coupon_discount_value' => '<th>Coupon Item Discount</th>',
            'coupon_discount_trx' => '<th>Coupon Item Disc. Trx</th>',
            'variant_cost' => '<th>Cost</th>',
            'commission_base_value' => '<th>Commission Base Value</th>',
            'drv_omzet_prorated' => '<th>Omzet</th>',
            'commission_type' => '<th>Commission Type</th>',
            'no_commission' => '<th>No Commission</th>',
            'commission_using_package_price' => '<th>Commission Using Package Price</th>',
            'commission_deducted_with_discount' => '<th>Commission Deducted with Disc.</th>',
            'commission_deducted_with_membership' => '<th>Commission Deducted with Membership</th>',
            'commission_deducted_with_redeem_item' => '<th>Commission Deducted with Redeem Item</th>',
            'commission_deducted_with_coupon' => '<th>Commission Deducted with Coupon</th>',
            'commission_deducted_with_cost' => '<th>Commission Deducted with Cost</th>',
            'commission_percentage' => '<th>Commission Item Percentage</th>',
            'commission_percentage_value' => '<th>Commision Item Percentage in Value</th>',
            'commission_value' => '<th>Commission Item Value</th>',
            'worker_commission_percentage' => '<th>Commission Worker Percentage</th>',
            'worker_commission_percentage_value' => '<th>Commission Worker Percentage Value</th>',
            'worker_commission_value' => '<th>Commission Worker Value</th>',
            'multi_commission_percentage' => '<th>Pro Rate</th>',
            'total_commission' => '<th>Total Commission</th>'
        );
        foreach ($columns as $key => $value) {
            if (in_array($key, $visible_column_array)) {
                echo $value;
                if ($key == 'gross_total') {
                    $count_gross_total_index = 0;
                }
                if ($count_gross_total_index == 1) {
                    $gross_total_index++;
                }
                if ($key == 'commission_base_value') {
                    $count_commission_base_value_index = 0;
                }
                if ($count_commission_base_value_index == 1) {
                    $commission_base_value_index++;
                }
                if ($key == 'drv_omzet_prorated') {
                    $count_drv_omzet_prorated_index = 0;
                }
                if ($count_drv_omzet_prorated_index == 1) {
                    $drv_omzet_prorated_index++;
                }
                if ($key == 'total_commission') {
                    $count_total_commission_index = 0;
                }
                if ($count_total_commission_index == 1) {
                    $total_commission_index++;
                }
            }
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $total_gross_total = 0;
    $total_commission_base_value = 0;
    $total_drv_omzet_prorated = 0;
    $total = 0;
    if (!empty($commission_worker_list)) {
        foreach($commission_worker_list as $row) {
            $total_gross_total += $row['gross_total'];
            $total_commission_base_value += $row['commission_base_value'];
            $total_drv_omzet_prorated += $row['drv_omzet_prorated'];
            $total += $row['total_commission'];
            ?>
            <tr>
                <?php
                $columns = array(
                    'trx_id' => '<td>' . $row['trx_id']. '</td>',
                    'local_trx_id' => '<td>' . $row['local_trx_id']. '</td>',
                    'user_name' => '<td>' . $row['user_name']. '</td>',
                    'created_at' => '<td>' . $row['created_at']. '</td>',
                    'category_name' => '<td>' . $row['category_name']. '</td>',
                    'package_name' => '<td>' . $row['package_name']. '</td>',
                    'item_nature' => '<td>' . $row['item_nature']. '</td>',
                    'is_custom' => '<td>' . $row['is_custom']. '</td>',
                    'item_notes' => '<td>' . $row['item_notes']. '</td>',
                    'item_name' => '<td>' . $row['item_name']. '</td>',
                    'variant_name' => '<td>' . $row['variant_name']. '</td>',
                    'package_qty' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['package_qty']) . '</td>',
                    'qty' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['qty']) . '</td>',
                    'gross_total' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['gross_total']) . '</td>',
                    'coupon_selling_price' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['coupon_selling_price']) . '</td>',
                    'item_discount_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['item_discount_value']) . '</td>',
                    'trx_discount_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['trx_discount_value']) . '</td>',
                    'loyalty_discount_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['loyalty_discount_value']) . '</td>',
                    'redeem_discount_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['redeem_discount_value']) . '</td>',
                    'redeem_discount_trx' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['redeem_discount_trx']) . '</td>',
                    'coupon_discount_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['coupon_discount_value']) . '</td>',
                    'coupon_discount_trx' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['coupon_discount_trx']) . '</td>',
                    'variant_cost' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['variant_cost']) . '</td>',
                    'commission_base_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['commission_base_value']) . '</td>',
                    'drv_omzet_prorated' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['drv_omzet_prorated']) . '</td>',
                    'commission_type' => '<td>' . $row['commission_type']. '</td>',
                    'no_commission' => '<td>' . $row['no_commission']. '</td>',
                    'commission_using_package_price' => '<td>' . $row['commission_using_package_price']. '</td>',
                    'commission_deducted_with_discount' => '<td>' . $row['commission_deducted_with_discount']. '</td>',
                    'commission_deducted_with_membership' => '<td>' . $row['commission_deducted_with_membership']. '</td>',
                    'commission_deducted_with_redeem_item' => '<td>' . $row['commission_deducted_with_redeem_item']. '</td>',
                    'commission_deducted_with_coupon' => '<td>' . $row['commission_deducted_with_coupon']. '</td>',
                    'commission_deducted_with_cost' => '<td>' . $row['commission_deducted_with_cost']. '</td>',
                    'commission_percentage' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['commission_percentage']) . '</td>',
                    'commission_percentage_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['commission_percentage_value']) . '</td>',
                    'commission_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['commission_value']) . '</td>',
                    'worker_commission_percentage' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['worker_commission_percentage']) . '</td>',
                    'worker_commission_percentage_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['worker_commission_percentage_value']) . '</td>',
                    'worker_commission_value' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['worker_commission_value']) . '</td>',
                    'multi_commission_percentage' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['multi_commission_percentage']) . '</td>',
                    'total_commission' => '<td>' . \App\Http\Helpers\NumberHelper::decimal_number_format($row['total_commission']) . '</td>'
                );
                foreach ($columns as $key => $value) {
                    if (in_array($key, $visible_column_array)) {
                        echo $value;
                    }
                }
                ?>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <?php
        if (in_array('gross_total', $visible_column_array)) {
            $commission_base_value_index -= 1;
            $drv_omzet_prorated_index -= 1;
            $total_commission_index -= 1;
            $commission_base_value_index -= $gross_total_index;
            $drv_omzet_prorated_index -= $gross_total_index;
            $total_commission_index -= $gross_total_index;
        }
        if (in_array('commission_base_value', $visible_column_array)) {
            $drv_omzet_prorated_index -= 1;
            $total_commission_index -= 1;
            $drv_omzet_prorated_index -= $commission_base_value_index;
            $total_commission_index -= $commission_base_value_index;
        }
        if (in_array('drv_omzet_prorated', $visible_column_array)) {
            $total_commission_index -= 1;
            $total_commission_index -= $drv_omzet_prorated_index;
        }
        ?>
        <?php if (in_array('gross_total', $visible_column_array)) { ?>
            <th colspan="<?=$gross_total_index?>" style="text-align:right">Total:</th>
            <th><?=\App\Http\Helpers\NumberHelper::decimal_number_format($total_gross_total)?></th>
        <?php } ?>
        <?php if (in_array('commission_base_value', $visible_column_array)) { ?>
            <th colspan="<?=$commission_base_value_index?>" style="text-align:right">Total:</th>
            <th><?=\App\Http\Helpers\NumberHelper::decimal_number_format($total_commission_base_value)?></th>
        <?php } ?>
        <?php if (in_array('drv_omzet_prorated', $visible_column_array)) { ?>
            <?php if (!in_array('commission_base_value', $visible_column_array)) { ?>
                <th colspan="<?=$drv_omzet_prorated_index?>" style="text-align:right">Total:</th>
            <?php } ?>
            <th><?=\App\Http\Helpers\NumberHelper::decimal_number_format($total_drv_omzet_prorated)?></th>
        <?php } ?>
        <?php if (in_array('total_commission', $visible_column_array)) { ?>
            <th colspan="<?=$total_commission_index?>" style="text-align:right">Total:</th>
            <th><?=\App\Http\Helpers\NumberHelper::decimal_number_format($total)?></th>
        <?php } else { ?>
            <th colspan="<?=$total_commission_index + 1?>"></th>
        <?php } ?>
    </tr>
    </tfoot>
</table>