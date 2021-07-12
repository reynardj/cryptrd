<?php if (empty($points->reward_amount)) { ?>
    <div class="email" style="max-width: 500px;">
        <div style="color:black; text-align:left;">
            <br>Hai <strong>sobat Get Diskon</strong>,
            <br>Selamat! Kamu telah melakukan aktivasi <strong><?=$business_membership->membership_name?></strong> di
            <strong><?=$brand_name?></strong>.
            <br>Segera lakukan registrasi melalui link berikut ini dan dapatkan berbagai promo menarik.
            <?php include_once 'clickHereToRegister.php'?>
            <?php include_once 'copyLink.php'?>
            Jika butuh bantuan, kamu dapat menghubungi kami melalui email: <a href="mailto:info@getdiskon.com">info@getdiskon.com</a>
            <?php include_once 'userEmailFooter.php'?>
        </div>
    </div>
<?php } else if (!empty($points->reward_amount)) { ?>
    <div class="email" style="max-width: 500px;">
        <div style="color:black; text-align:left;">
            <br>Hai <strong>sobat Get Diskon</strong>, <br>Selamat! Kamu telah melakukan aktivasi
            <strong><?=$business_membership->membership_name?></strong> di <strong><?=$brand_name?></strong>. Kamu
            mendapatkan reward:
            <br><br>
            <div style="text-align:center; font-weight:bold; font-size:20px;">
                <?=$points->reward_amount . ' ' . $points->reward_name?>
            </div>
            <br>Segera lakukan registrasi melalui link berikut ini dan dapatkan berbagai promo menarik.
            <?php include_once 'clickHereToRegister.php'?>
            <?php include_once 'copyLink.php'?>
            Jika butuh bantuan, kamu dapat menghubungi kami melalui email: <a href="mailto:info@getdiskon.com">info@getdiskon.com</a>
            <?php include_once 'userEmailFooter.php'?>
        </div>
    </div>
<?php } ?>