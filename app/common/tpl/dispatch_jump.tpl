{__NOLAYOUT__}<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Redirect</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="__ROOT__/favicon.ico" type="image/x-icon">
        <link type="text/css" rel="stylesheet" href="__STATIC__/assets/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="__STATIC__/assets/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="__STATIC__/assets/css/ace.min.css">
        <style type="text/css">
            *{box-sizing:border-box;margin:0;padding:0;font-family:Lantinghei SC,Open Sans,Arial,Hiragino Sans GB,Microsoft YaHei,"微软雅黑",STHeiti,WenQuanYi Micro Hei,SimSun,sans-serif;-webkit-font-smoothing:antialiased}
            body{padding:70px 0;background:#edf1f4;font-weight:400;font-size:1pc;-webkit-text-size-adjust:none;color:#333}
            a{outline:0;color:#3498db;text-decoration:none;cursor:pointer}
            .system-message{margin:20px 15%;padding:40px 20px;background:#fff;box-shadow:1px 1px 1px hsla(0,0%,39%,.1);text-align:center}
            .system-message h1{margin:0;margin-bottom:9pt;color:#444;font-weight:400;font-size:40px}
            .system-message .jump,.system-message .image{margin:20px 0;padding:0;padding:10px 0;font-weight:400}
            .system-message .jump{font-size:14px; color:#666;}
            .system-message .jump a{color:#333}
            .system-message p{font-size:9pt;line-height:20px}
            .success {color:#69bf4e}
            .error {color:#F73809}
            .info {color:#FFD700}
            .copyright p{width:100%;color:#919191;text-align:center;font-size:10px}
            .system-message .btn-grey{border-color:#bbb;color:#bbb}
            .clearfix:after{clear:both;display:block;visibility:hidden;height:0;content:"."}
        </style>
    </head>
    <body>
        <div class="system-message">
           <?php if($code == 1):?>
            <div class="success"><i class="icon-ok icon-3x icon-only"></i> </div>
            <?php elseif($code == 0):?>
            <div class="error"> <i class="icon-warning-sign icon-3x icon-only"></i></div>
            <?php else:?>
            <div class="info"><i class="icon-exclamation-sign icon-3x icon-only"></i> </div>
            <?php endif;?>
            <h3><?php echo($msg);?></h3>
            <p class="jump">
                The page will jump in <span id="wait"><?php echo($wait);?></span> s <a id="href" href="<?php echo($url);?>"></a>
            </p>
            <p class="clearfix">
                <a href="javascript:history.go(-1);" class="btn">Back</a>&nbsp;&nbsp;
                <a href="<?php echo($url);?>" class="btn btn-primary">Jump Now</a>
            </p>
        </div>
        <script type="text/javascript">
            (function () {
                var wait = document.getElementById('wait'),
                        href = document.getElementById('href').href;
                var interval = setInterval(function () {
                    var time = --wait.innerHTML;
                    if (time <= 0) {
                        location.href = href;
                        clearInterval(interval);
                    }
                }, 1000);
            })();
        </script>
    </body>
</html>
