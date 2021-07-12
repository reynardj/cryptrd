<style type="text/css">
    body{
        font-size: 10px;
    }
</style>
<table cellpadding="2" style="width: 100%;">
    <tr>
        <td><?='Date Selection: ' . $end_date?></td>
    </tr>
    <tr>
        <td><?='Filtered By: ' . $report_filter_text?></td>
    </tr>
</table>
<br>
<table cellpadding="2" style="width: 100%;">
    <thead>
    <tr>
        <th style="width: 100%; text-align: left;">GENERAL SALES - MEMBERSHIP SALES - COUPON SALES</th>
    </tr>
    </thead>
</table>
<table cellpadding="2" style="width: 100%;">
    <tbody>
    <tr>
        <td style="width: 25%;">Number of Transaction</td>
        <td style="text-align: left;">: <?=$pos_trx_count?></td>
    </tr>
    <tr>
        <td style="width: 25%;">Value of Transaction</td>
        <td style="text-align: left;">: <?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($pos_gross_sales)?> IDR</td>
    </tr>
    </tbody>
</table>
<br>
<table cellpadding="2" style="width: 100%;">
    <thead>
    <tr>
        <th style="width: 50%; text-align: left;">DEPOSIT</th>
        <th style="width: 50%; text-align: left;">ACCOUNT RECEIVABLE</th>
    </tr>
    </thead>
</table>
<table cellpadding="2" style="width: 100%;">
    <tbody>
    <tr>
        <td style="width: 25%;">Top Up Deposit</td>
        <td style="width: 25%;">: <?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($total_deposit_transaction_amount)?> IDR</td>
        <td style="width: 25%;">AR Payment</td>
        <td style="width: 25%;">: <?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($receivable_payment_trx_amount)?> IDR</td>
    </tr>
    <tr>
        <td style="width: 25%;">Payment with Deposit</td>
        <td style="width: 25%;">: <?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($total_deposit_deduction_transaction_amount)?> IDR</td>
        <td style="width: 25%;">Payment with AR</td>
        <td style="width: 25%;">: <?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($receivable_trx_amount)?> IDR</td>
    </tr>
    </tbody>
</table>
<br>
<table cellpadding="2" style="width: 100%;">
    <thead>
    <tr>
        <th style="width: 100%; text-align: left;">TOP 5 PERFORMING EMPLOYEE</th>
    </tr>
    </thead>
</table>
<table cellpadding="2" style="width: 100%;">
    <?php if (!empty($pos_number_of_trx_by_business_commission_workers)) { ?>
    <tbody>
        <?php
        $x = 1;
        foreach ($pos_number_of_trx_by_business_commission_workers as $pos_number_of_trx_by_business_commission_worker) {
            ?>
    <tr>
        <td style="width: 25%;"><?=$x . '. ' . $pos_number_of_trx_by_business_commission_worker->business_commission_worker_name ?></td>
        <td><?=': ' . $pos_number_of_trx_by_business_commission_worker->number_of_trx?> service(s) / product(s)</td>
    </tr>
        <?php
        $x++;
        }
        ?>
    </tbody>
    <?php } ?>
</table>
<br>
<table cellpadding="2" style="width: 100%;">
    <thead>
    <tr>
        <th style="width: 100%; text-align: left;">PAYMENT METHOD</th>
    </tr>
    </thead>
</table>
<table cellpadding="2" border="1" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th>Payment Method Name</th>
            <th>Number of Transaction</th>
            <th>Value</th>
            <th>Net Value After MDR</th>
        </tr>
    </thead>
    <?php
    $total_trx = 0;
    $total_payment_amount = 0;
    $total_payment_amount_after_mdr = 0;
    if (!empty($payment_method_summary)) {
        ?>
        <tbody>
        <?php
        foreach ($payment_method_summary as $payment_method) {
            $total_trx += $payment_method->number_of_trx;
            $total_payment_amount += $payment_method->total_payment_amount;
            $total_payment_amount_after_mdr += $payment_method->total_payment_amount_after_mdr;
            ?>
            <tr>
                <td><?=$payment_method->payment_method_name ?></td>
                <td><?=\App\Http\Helpers\NumberHelper::integer_number_format($payment_method->number_of_trx)?></td>
                <td><?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($payment_method->total_payment_amount)?> IDR</td>
                <td><?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($payment_method->total_payment_amount_after_mdr)?> IDR</td>
            </tr>
        <?php } ?>
            <tr>
                <td>Total</td>
                <td><?=\App\Http\Helpers\NumberHelper::integer_number_format($total_trx)?></td>
                <td><?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($total_payment_amount)?> IDR</td>
                <td><?=\App\Http\Helpers\NumberHelper::currency_decimal_number_format($total_payment_amount_after_mdr)?> IDR</td>
            </tr>
        </tbody>
    <?php } ?>
</table>
<br>
<table cellpadding="2" style="width: 100%;">
    <thead>
    <tr>
        <th style="width: 100%; text-align: left;">INVENTORY STOCK ON ALERT</th>
    </tr>
    </thead>
</table>
<table cellpadding="2" border="1" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <?php if ($report_filter == 'business') { ?>
                <th>Storage Location</th>
            <?php } ?>
            <th>Item/Material Name</th>
            <th>Current Stock</th>
        </tr>
    </thead>
    <?php if (!empty($inv_stock_on_alerts)) { ?>
        <tbody>
        <?php
        $x = 1;
        foreach ($inv_stock_on_alerts as $inv_stock_on_alert) {
            ?>
            <tr>
                <td><?=$inv_stock_on_alert->location_name?></td>
                <td><?=$inv_stock_on_alert->item_name ?></td>
                <td><?=\App\Http\Helpers\NumberHelper::integer_number_format($inv_stock_on_alert->qty)?></td>
            </tr>
            <?php
            $x++;
        }
        ?>
        </tbody>
    <?php } ?>
</table>