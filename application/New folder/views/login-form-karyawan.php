<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
<link rel="icon" href="http://localhost/2017/10/sika/app/hide.ico" type="image/x-icon" />
    <title><?php echo $this->config->item('app')?> :: Login Form</title>

    <!-- pemanggilan direktory file bootstrap.css -->
    <link href="<?php echo $this->config->item('link_url')?>assets/assets2/css/bootstrap.css" rel="stylesheet">
    <!-- pemanggilan direktory file css font-->
    <link href="<?php echo $this->config->item('link_url')?>assets/assets2/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- pemanggilan direktori file css custom template -->
    <link href="<?php echo $this->config->item('link_url')?>assets/assets2/css/style.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('link_url')?>assets/assets2/css/style-responsive.css" rel="stylesheet">

  </head>

  <body>

	  <div id="login-page">
	  	<div class="container">	  	
			<h1 align="center" style="color:red">UNIFORM REQUESTION SYSTEM</h1>
							<?php $flash=$this->session->flashdata('info');
							if($flash!=null){?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<h4 align="center">INFO : <?php echo $flash;?><h4>
								</div>
							<?php }else{} ?>
    		  <form class="form-login" method="post" action="<?php echo $this->config->item('link_url')?>login/aksi_login_karyawan">
		        <h2 class="form-login-heading"> <span class="glyphicon glyphicon-lock"></span> LOGIN USER </h2>
                <center><h5> <span class="glyphicon glyphicon-qrcode"></span> <?php echo $this->config->item('nama_app')?> <span class="glyphicon glyphicon-qrcode"></span></h5></center>
		        <div class="login-wrap">
		            <input name="nik" id="nik" type="input" class="form-control" autocomplete="off" placeholder="PIN" required  autofocus>
                    <br />
                    <!--<input name="password" id="password" type="password" class="form-control" autocomplete="off" placeholder="Password" required>-->
                    <br />
                    <br />
                    <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
		           
          	  	
                         <hr>
		            <div class="login-social-link centered">

					<strong>&copy; 2019. IT Division <a href="#"><?php echo $this->config->item('pt')?></a>.</strong>

		            </div>

		            <div class="registration">
		                <a class="" href="#" onclick="window.open('<?php echo $this->config->item('link_foot')?>')">
		                    <?php echo $this->config->item('copyright')?>
		                </a>
		            </div>
		
		        </div>
			
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo $this->config->item('link_url')?>assets/assets2/js/jquery.js"></script>
    <script src="<?php echo $this->config->item('link_url')?>assets/assets2/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo $this->config->item('link_url')?>assets/assets2/js/jquery.backstretch.min.js"></script>
    <!-- Pemanggilan Background Login Form-->
    <script>
        $.backstretch("<?php echo $this->config->item('link_url')?>assets/foto/ptenkei.png");
    </script>


  </body>
</html>
