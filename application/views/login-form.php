<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <title>Login | ENKEI <?php echo $this->config->item('app')?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/foto/faviconn.jpeg" />

    <!-- pemanggilan direktory file bootstrap.css -->
    <link href="<?php echo $this->config->item('link_url') ?>assets/assets2/css/bootstrap.css" rel="stylesheet">
    <!-- pemanggilan direktory file css font-->
    <link href="<?php echo $this->config->item('link_url') ?>assets/assets2/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- pemanggilan direktori file css custom template -->
    <link href="<?php echo $this->config->item('link_url') ?>assets/assets2/css/style.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('link_url') ?>assets/assets2/css/style-responsive.css" rel="stylesheet">

</head>


<body>

    <div id="login-page">
        <div class="container">
            <h1 align="center" style="color:red">e-CUTI SYSTEM</h1>
            <form class="form-login" method="post" action="<?= base_url('login/aksi_login') ?>">
                <h2 class="form-login-heading"> <span class="glyphicon glyphicon-lock"></span> LOGIN PAGE </h2>

                <?php $flash = $this->session->flashdata('info');
                //ambil dan tampilkan pesan error jika gagal login
                if ($flash != null) { ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <h3 align="center">INFO : <?php echo $flash; ?><h3>
                    </div>
                <?php } else {
                } ?>
                <center>
                    <h4><strong><?php echo $this->config->item('nama_app') ?></strong> </h4>
                </center>
                <div class="login-wrap">
                    <input name="username" id="username" type="input" class="form-control" autocomplete="off" placeholder="Handpunch PIN" required autofocus>
                    <br />
                    <input name="password" id="password" type="password" class="form-control" autocomplete="off" placeholder="Password" required>
                    <br />

                    <br />
                    <button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
                    <hr>
                    <div class="card-body px-5 py-4">
                        <div class="small text-center">
                            Copyright &copy; <?php echo $this->config->item('programmer')?><br>
                            IT Section | <?php echo $this->config->item('app')?> | 2020
                        </div>
                    </div>
                    <!-- <div class="card-body px-5 py-4">
                        <div class="row">
                            <div class="col-md-6 small">Development &copy; <?php echo $this->config->item('app')?> | 2021</div>
                        </div>
                    </div> -->
                </div>
            </form>
        </div>
    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <!-- <script src="<?php echo $this->config->item('link_url') ?>assets/assets2/js/jquery.js"></script> -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/assets2/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo $this->config->item('link_url') ?>assets/assets2/js/jquery.backstretch.min.js"></script>
    <!-- Pemanggilan Background Login Form-->
    <script>
        $.backstretch("<?php echo $this->config->item('link_url') ?>assets/foto/ptenkei.png");
    </script>


</body>

</html>