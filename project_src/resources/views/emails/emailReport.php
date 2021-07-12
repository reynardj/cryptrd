<div class="email" style="max-width: 500px;">
    <div style="color:black; text-align:left;">
        Dear Bapak / Ibu,
        <br><br>
        Berikut terlampir Laporan <strong>GD Business - <?=$report_type?></strong> selama
        <?=$report_name == \App\Http\Controllers\Controller::DAILY_TRX_EMAIL_REPORT ? '' : $start_date . ' - '?><?=$end_date?>.
        <?php include_once 'emailFooter.php'?>
    </div>
</div>