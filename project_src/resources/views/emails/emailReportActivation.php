<div class="email" style="max-width: 500px;">
    <div style="color:black; text-align:left;">
        Selamat!<br>
        Email Anda telah diberikan wewenang oleh <strong><?=$business_user_name?></strong> untuk mendapatkan laporan
        <strong>GD Business - <?=$report_type?></strong>.
        Silakan lakukan aktivasi email Anda melalui link di bawah ini:
        <br><br>
        <div style="text-align:center; max-width:200px; width:50%; margin-left:25%; padding:10px;">
            <br>
            <a href="<?=$link?>">
                <strong>CLICK HERE</strong>
            </a>
            <br>
        </div>
        <?php include_once 'copyLink.php'?>
        <?php include_once 'emailFooter.php'?>
    </div>
</div>