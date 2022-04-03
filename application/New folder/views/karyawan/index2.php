<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->config->item('nama_app')?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $this->config->item('link_url')?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">EKID</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo $this->config->item('app')?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <!-- Header navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
  <div style="margin-top:13px;margin-left:10px;float:left;color:white;font-size:16px">
          <script type="text/javascript">
                  var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                  var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu'];
                  var date = new Date();
                  var day = date.getDate();
                  var month = date.getMonth();
                  var thisDay = date.getDay(),
                  thisDay = myDays[thisDay];
                  var yy = date.getYear();
                  var year = (yy < 1000) ? yy + 1900 : yy;
                  document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
            </script>             
      </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              Selamat datang, 
			  <span class="hidden-xs"><?php echo $this->session->userdata('nama')?></span>
              
            </a>
            <ul class="dropdown-menu">
            <!-- User image -->
              <li class="user-header">
                <!--<img src="<?php echo $this->config->item('link_url')?>fotoprofile/<?php echo $this->session->userdata('foto')?>" class="img-circle" alt="User Image">-->
				<img src="<?php echo $this->config->item('link_url')?>assets/foto/User.png" class="img-circle" alt="Second slide">
				
                  <p><?php echo $this->session->userdata('nama')?></p>
				<!-- <p><small><a href="<?php echo base_url()?>admin/ganti_foto/<?php echo $this->session->userdata('id')?>" style="color:white">Ganti Foto</a></small></p>-->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url()?>karyawan/detail_karyawan" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url()?>login/logout_karyawan/<?php echo $this->session->userdata('id')?>" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!--<img src="<?php echo $this->config->item('link_url')?>fotoprofile/<?php echo $this->session->userdata('foto')?>" class="img-circle" alt="User Image">-->
		  <img src="<?php echo $this->config->item('link_url')?>assets/foto/User.png" class="img-circle" alt="Second slide">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('akses')?></p>
          
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo base_url()?>karyawan/detail_karyawan/<?php echo $lihat->kar_id ?>">
            <i class="fa fa-mobile"></i> <span>PROFILE</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url()?>karyawan/tambah_transaksi">
            <i class="fa fa-dashboard"></i> <span>REQUEST UNIFORM</span>
          </a>
        </li>
      <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>REQUEST_DETAIL</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li class="active"><a href="<?php echo base_url()?>admin/request"><i class="fa fa-plus"></i>UNIFORM REQUISITION</a></li>-->
            <li class="active"><a href="<?php echo base_url()?>karyawan/tambah_transaksi"><i class="fa fa-plus"></i>FORM REQUESTION</a></li>
            <li class="active"><a href="<?php echo base_url()?>karyawan/tambah_transaksi_sepatu"><i class="fa fa-plus"></i>SHOES FORM REQUESTION</a></li>
            <li class="active"><a href="<?php echo base_url()?>karyawan/request"><i class="fa fa-navicon"></i>DETAIL_REQUESTION</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-calendar"></i> <span>PENGAJUAN CUTI</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-envelope"></i> <span>E-PAYSLIP</span>
          </a>
        </li>
		    <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>REQUEST_HEADER</span>
          </a>
        </li> -->
	      <li>
            <a href="<?php echo base_url()?>login/logout_karyawan/<?php echo $this->session->userdata('id')?>">
            <i class="fa fa-sign-out"></i> <span>LOGOUT</span>
          </a>
        </li>
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
	
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $this->config->item('app')." :: ".$title?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>karyawan/tambah_transaksi"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $title?></li>
      </ol>
    </section>

  <?php $this->load->view('karyawan/'.$page);?>
  
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.1
    </div>
    <strong>&copy; 2019. IT SECTION <a href="#"><?php echo $this->config->item('pt')?></a>.</strong> 
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
$(document).ready(function() {
	$('#example').DataTable( {
		"scrollY":        "400px",
		"scrollX": true,
		"scrollCollapse": true,
		"paging":         true
	} );
} );
$(document).ready(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
  $(function(){
	$('#tanggal').datepicker({
		autoclose:true,
		format:'yyyy-mm-dd'
	});
  });
  $(function(){
	$('#tanggal1').datepicker({
		autoclose:true,
		format:'yyyy-mm-dd'
	});
  });
  $(function(){
	$('#tahun').datepicker({
		changeYear:true,
		changeMonth:false,
        showButtonPanel: true,
		yearRange: "2005:2020"
	});
  });
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->config->item('link_url')?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->item('link_url')?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $this->config->item('link_url')?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->item('link_url')?>assets/dist/js/demo.js"></script>
</body>
</html>
