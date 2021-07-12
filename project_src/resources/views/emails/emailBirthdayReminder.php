<div class="email" style="max-width: 500px;">
    <div style="color:black; text-align:left;">
        Dear <?=$business_name?>,
        <br><br>
        Ayo ucapkan selamat ulang tahun kepada pelanggan Anda yang berulang tahun di minggu ini.
        <br><br>
        <table cellpadding="2" border="1" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
            <tr>
                <th>Title</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Umur (Tahun)</th>
                <th>Nomor Telepon</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?=$user->user_gender == 1 ? 'Bapak' : ($user->user_gender == 2 ? 'Ibu' : '' ) ?></td>
                    <td><?=$user->user_name?></td>
                    <td><?=$user->user_birth_date?></td>
                    <td><?=$user->user_age?></td>
                    <td><?=!empty($user->primary_phone) ? $user->primary_phone->phone_number : '' ?></td>
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