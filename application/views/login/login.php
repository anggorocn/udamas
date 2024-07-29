<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

// $reqUser= "198305022011011001";
// $reqPasswd= "Sri Murdaningtyas12081959";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.png">

    <title>Login Page</title>
    <base href="<?= base_url(); ?>" />
    <link href="assets/bootstrap-3.3.7/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <script src="assets/bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>
    <link rel="stylesheet" href="css/gaya.css" type="text/css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 area-login">
                <div class="logo"><img src="images/logo.png"></div>
                <div class="inner">
                    <div class="header">
                        
                        <div class="nama-aplikasi">
                            <h1>Login area</h1>
                            Masukkan username & password
                            untuk mengakses halaman kepegawaian anda
                        </div>    
                        <div class="clearfix"></div>
                    </div>
                    <form class="form-signin" method="post" action="login/login">
                        <div class="form-group">
                            <input name="reqUser" type="text" placeholder="Username..." value="<?=$reqUser?>" />
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <input name="reqPasswd" type="password" placeholder="Password..." value="<?=$reqPasswd?>" />
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group text-right">
                            <a href="https://bkpsdm.jombangkab.go.id/layanan/udamas-jombang-407" target="_blank">Bantuan?</a>
                        </div>

                        <div class="clearfix"></div>
                        <div style="color:#000; font-size:20px;"><?= $pesan ?></div>
                        <button class="login" type="submit">Login</button>
                        <br><br>
                        <div class="form-group text-right">
                            Sign in with BKN SSO<br>
                            <a href="#">
                                <img src="images/logo-bkn.png" height="39">
                            </a>
                        </div>
                        
                    </form>
                    
                </div>
            
            	<div class="footer">
                    <div class="pull-left">
                    BKDPP Jombang</div>
                    <div class="pull-right">
                        Copyright © 2023. All rights reserved.
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- /container -->

    <script src="assets/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/bootstrap-3.3.7/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="assets/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>

    <script language='JavaScript' type='text/javascript'>
        $('#reqCapcha').on('change', function() {
            var val = this.value;
            var capcha = $("#capcha").val();
            if (capcha !== val) {
                $.messager.alert('Info', "Wrong Capcha ", 'info');

            }
        });
        $(document).ready(function() {
            $('#reqCapcha').keyup(function() {
                this.value = this.value.toUpperCase();
            });

            refreshing_Captcha();
        });

       function refreshing_Captcha() {
           var d = new Date();
           $('#image_captcha').attr('src','');
           $.get('Login/capcha', function (base64) {
               $('#image_captcha').attr('src','data:image/png;base64,'+base64);
           })
         }
    </script>
    
</body>
</html>