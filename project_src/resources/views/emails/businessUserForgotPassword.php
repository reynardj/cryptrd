<div class="email" style="max-width: 500px;">
    <div style="color:black; text-align:left;">
        Dear <strong><?=$recipient_name?></strong>,
        <br><br>
        Kami menerima permohonan atur ulang kata sandi dari akun <?=$system_name?> anda.
        Silakan mengubah kata sandi akun <?=$system_name?> anda melalui link di bawah ini:
        <br><br>
        <div style="text-align:center; max-width:200px; width:50%; margin-left:25%; padding:10px;">
            <a style="color:black; text-decoration:none;" href="<?=$link?>">
                <strong style="font-size: medium;">
                    CLICK HERE
                </strong>
            </a>
        </div>
        <?php include_once 'copyLink.php'?>
        <br><br>
        Jika Anda tidak mengajukan permohonan ini, Anda bisa abaikan saja email ini.
        <br><br>
        Email ini diajukan pada <?=$now?>
        <?php include_once 'emailFooter.php'?>
    </div>
</div>