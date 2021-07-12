<div class="email" style="max-width: 500px;">
    <div style="color:black; text-align:left;">
        Dear <?=$business_name?>,
        <br><br>
        Berikut daftar customer dan treatment customer yang sudah perlu untuk diingatkan kembali.
        <br><br>
        <table cellpadding="2" border="1" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Nomor Telepon</th>
                <th>Treatment</th>
                <th>Reminder Period</th>
                <th>Expected Treatment Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?=$user->user_name?></td>
                    <td><?=$user->user_birth_date?></td>
                    <td><?=!empty($user->primary_phone) ? $user->primary_phone->phone_number : '' ?></td>
                    <td><?=$item_name?></td>
                    <td><?=$reminder_duration . ' ' . $reminder_duration_unit?></td>
                    <td><?=$user->expected_treatment_date?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <br><br>
        Salam,
        <br>
        Get Diskon Team
        <?php include_once 'emailFooter.php'?>
    </div>
</div>