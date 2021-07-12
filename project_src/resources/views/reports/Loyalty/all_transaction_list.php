<style type="text/css">
    body{
        font-size: 10px;
    }
</style>
<table style="width:100%;">
    <tr>
        <td colspan="8"><?='Date Selection: ' . $_GET['start_date'] . ' - ' . $_GET['end_date']?></td>
    </tr>
    <tr>
        <td colspan="8"><?='Filtered By: ' . $_GET['grouping_by_text']?></td>
    </tr>
    <tr>
        <td colspan="8">
            Number of Records: <?=$number_of_transaction?>
        </td>
    </tr>
    <tr>
        <td>Activation: <?=$number_of_activation_trx?></td>
        <td>Sales: <?=$number_of_sales_trx?></td>
        <td>Redeem: <?=$number_of_redeem_trx?></td>
        <td>Migration: <?=$number_of_migration_trx?></td>
        <td>Blast: <?=$number_of_blast_trx?></td>
        <td>Deposit: <?=$number_of_wallet_trx?></td>
        <td>Void: <?=$number_of_void_trx?></td>
        <td>Expired: <?=$number_of_expired_trx?></td>
    </tr>
</table>
<table cellpadding="2" border="1" style="border: 1px solid black; border-collapse: collapse;">
    <thead>
    <tr>
        <th>Transaction ID</th>
        <th>PO No.</th>
        <th style="width:50px;">Date & Time</th>
        <th style="width:40px;">Trx Value</th>
        <th>Point Value</th>
        <th style="width:50px;">Dsc Lv Before Trx</th>
        <th style="width:50px;">Dsc Lv After Trx</th>
        <th>Coupon ID</th>
        <th>Deposit</th>
        <th>User ID</th>
        <th>User Phone/Email/Reference</th>
        <th style="width:50px;">User Name</th>
        <th>Trx Type</th>
        <th style="width:90px;">Reference Trx ID</th>
        <th>Cashier Email</th>
        <th style="width:50px;">Outlet Name</th>
        <th>Transaction Source</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($report_data)) { ?>
        <?php foreach($report_data as $row) { ?>
            <tr>
                <td><?=$row['trx_id']?></td>
                <td><?=$row['pos_trx_code']?></td>
                <td><?=$row['created_at']?></td>
                <td><?=number_format($row['trx_amount'], 0, ',', '.')?></td>
                <td><?=number_format($row['trx_reward_value'], 0, ',', '.')?></td>
                <td><?=$row['discount_level_before_trx']?></td>
                <td><?=$row['discount_level_after_trx']?></td>
                <td></td>
                <td><?=$row['deposit_amount']?></td>
                <td><?=$row['user_code']?></td>
                <td><?=$row['user_identifier_string']?></td>
                <td><?=$row['user_name']?></td>
                <td><?=$row['trx_type']?></td>
                <td><?=$row['void_trx_id']?></td>
                <td><?=$row['business_user_email']?></td>
                <td><?=$row['outlet_name']?></td>
                <td><?=$row['trx_source']?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>