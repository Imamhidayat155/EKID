  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | ENKEI <?php echo $this->config->item('app')?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/assets_new/images/faviconn.jpeg" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- Select2 -->
    <!-- <link rel="stylesheet" href="http://ecuti.enkei.co.id/assets/plugins/select2/select2.min.css"> -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/select2/select2.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo $this->config->item('link_url') ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    
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
          <span class="logo-lg"><?php echo $this->config->item('app') ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
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
                  <span class="hidden-xs"><?php echo $this->session->userdata('user') ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo $this->config->item('link_url') ?>fotoprofile/<?php echo $this->session->userdata('foto') ?>" class="img-circle" alt="User Image">

                    <p><?php echo $this->session->userdata('nama') ?></p>
                    <p><small><a href="<?php echo base_url() ?>admin/ganti_foto/<?php echo $this->session->userdata('id') ?>" style="color:white">Ganti Foto</a></small></p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url() ?>admin/profile" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url() ?>login/logout_user/<?php echo $this->session->userdata('id') ?>" class="btn btn-default btn-flat">Logout</a>
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
              <img src="<?php echo $this->config->item('link_url') ?>fotoprofile/<?php echo $this->session->userdata('foto') ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $this->session->userdata('user') ?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo base_url() ?>admin">
                <i class="fa fa-home"></i> <span>HOME</span>
              </a>
            </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-database"></i> <span>MASTER_DATA</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="active"><a href="<?php echo base_url() ?>admin/user"><i class="fa fa-user"></i>Data User</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/karyawan"><i class="fa fa-group"></i>Data Karyawan</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/plant"><i class="fa fa-building"></i>Data Plant</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/jabatan"><i class="fa fa-building"></i>Data Jabatan</a></li>
                  <!-- <li class="active"><a href="<?php echo base_url() ?>admin/standar_cuti"><i class="fa fa-circle"></i>STANDARD_CUTI</a></li> -->
                  <!-- <li class="active"><a href="<?php echo base_url() ?>admin/karyawan"><i class="fa fa-money"></i>HARGA_CUTI</a></li> -->
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-folder-open"></i> <span>TRANSAKSI_CUTI</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="active"><a href="<?php echo base_url() ?>admin/tambah_cuti_tahunan"><i class="fa fa-pencil-square"></i>Tambah Cuti Tahunan</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/tambah_cuti_panjang"><i class="fa fa-pencil-square"></i>Tambah Cuti Panjang</a></li>
                  <!-- <li class="active"><a href="<?php echo base_url() ?>#"><i class="fa fa-money"></i>CUTI_DIUANGKAN</a></li> -->
                </ul>
              </li>
              <hr style="height:1px; margin-top: 5px; margin-bottom: 5px; border-top: 3px double #8c8c8c;">
              <?php 
                    $id=$this->session->userdata('id');
                    $row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $id))->row(); //jatah cuti tahunan
                    $row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $id))->row(); //CT yg sudah dipakai
                    $row_jatah_CP = $this->db->get_where('v_jatah_CP_perkaryawan', array('kar_id' => $id))->row(); //jatah cuti tahunan
                    $row_potong_CP = $this->db->get_where('v_potong_CP_perkaryawan', array('kar_id' => $id))->row(); //CP yg sudah dipakai

                    $alert_ct = $row_jatah_CT->total - $row_potong_CT->total; 
                    $alert_cp = $row_jatah_CP->total - $row_potong_CP->total;
                      if($alert_ct <= 4 && $alert_cp <= 0) { ?>
              <li>
                  <a href="#" onclick="return confirm('Cuti Anda Sudah Habis (Hanya Tersisa Cuti Bersama), Untuk Cuti Bersama belum bisa dipakai !')">
                    <i class="fa fa-pencil-square" style="color: yellow;"></i> <span style="color: yellow;">PERMOHONAN CUTI</span>
                  </a>
                  <!-- <a href="#" onclick="return confirm('Cuti Tahun 2022 belum bisa dipakai, sedang proses closing cuti 2021 !')">
                    <i class="fa fa-pencil-square" style="color: yellow;"></i> <span style="color: yellow;">PERMOHONAN CUTI</span>
                  </a> -->
                </li>
              <?php }else{?>
              <li>
                <a href="<?php echo base_url() ?>admin/tambah_trcuti">
                  <i class="fa fa-pencil" style="color: yellow;"></i> <span style="color: yellow;">PERMOHONAN CUTI</span>
                </a>
                <!-- <a href="#" onclick="return confirm('Cuti Tahun 2022 belum bisa dipakai, sedang proses closing cuti 2021 !')">
                  <i class="fa fa-pencil-square" style="color: yellow;"></i> <span style="color: yellow;">PERMOHONAN CUTI</span>
                </a> -->
              </li>
              <?php } ?>
              <li>
                <a href="<?php echo base_url('admin/tambah_potong_cuti_karyawan') ?>">
                  <i class="fa fa-exclamation" style="color: red;"></i> <span>CREATE CUTI MASSAL</span>
                </a>
              </li>
              <li>
                <a href="<?php echo base_url('admin/status_cuti_massal') ?>">
                  <i class="fa fa-exclamation" style="color: red;"></i> <span>STATUS CUTI MASSAL</span>
                </a>
              </li>
              <li>
                <a href="<?php echo base_url() ?>admin/tr_cuti">
                  <i class="fa fa-check"></i> <span>STATUS CUTI</span>
                </a>
              </li>
              <li>
              <a href="<?php echo base_url() ?>admin/history_pengambilan_cuti">
                <i class="fa fa-file-archive-o"></i> <span>HISTORY PENGAMBILAN CUTI</span>
              </a>
            </li>
            <hr style="height:1px; margin-top: 5px; margin-bottom: 5px; border-top: 3px double #8c8c8c;">
            <!-- <li>
              <a href="<?php echo base_url() ?>admin/tambah_trcuti_panjang">
                <i class="fa fa-pencil"></i> <span>PERMOHONAN CUTI PANJANG</span>
              </a>
            </li> -->
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-pencil-square" style="color: yellow;"></i> <span style="color: yellow;">APPROVAL</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="active"><a href="<?php echo base_url() ?>admin/approval"><i class="fa fa-check-circle"></i>Approval Cuti</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/history_approval"><i class="fa fa-archive"></i>History Approval</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-archive" style="color: #ffa500;"></i> <span>REPORT</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="active"><a href="<?php echo base_url('admin/report_cuti_daily') ?>"><i class="fa fa-file-archive-o"></i>Report Cuti Daily</a></li>
                  <li class="active"><a href="<?php echo base_url('admin/report_cuti_belum_approve_leader') ?>"><i class="fa fa-user"></i>Cuti Belum Approve Leader</a></li>
                  <li class="active"><a href="<?php echo base_url('admin/report_cuti_belum_approve_sh') ?>"><i class="fa fa-user"></i>Cuti Belum Approve SH</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/rekap_sisa_cuti"><i class="fa fa-file-archive-o"></i>Report Sisa Cuti</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/report_detail_cuti"><i class="fa fa-file-archive-o"></i>Report Detail Cuti</a></li>
                  <li class="active"><a href="<?php echo base_url() ?>admin/report_izin_keluar"><i class="fa fa-file-archive-o"></i>Report Izin Keluar</a></li>
                </ul>
              </li>
              <hr style="height:1px; margin-top: 5px; margin-bottom: 5px; border-top: 3px double #8c8c8c;">
            <li>
              <a href="<?php echo base_url('admin/cancel_cuti')?>">
                <i class="fa fa-exclamation-circle" style="color: red;"></i> <span">CANCEL CUTI</span>
              </a>
            </li>
            <!-- <li>
              <a href="<?php echo base_url('admin/ganti_password/'. $this->session->userdata('id'))?>">
                <i class="fa fa-key"></i> <span>CHANGE PASSWORD</span>
              </a>
            </li> -->
            <li>
              <a href="<?php echo base_url() ?>login/logout_user/<?php echo $this->session->userdata('id') ?>">
                <i class="fa fa-power-off"></i> <span>LOGOUT</span>
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
            <?php echo " >> " . $title ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $title ?></li>
          </ol>
        </section>

        <?php $this->load->view('admin/' . $page); ?>

      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.4
        </div>
        <strong>&copy; 2022 - IT Section -  <a href="#"><?php echo $this->config->item('app') ?></a>.</strong>
      </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="<?php echo $this->config->item('link_url') ?>assets/dist/js/sweetalert2.all.min.js"></script>
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

      });
      $(document).ready(function() {
        $('#example').DataTable({
          "scrollY": "400px",
          "scrollX": true,
          "scrollCollapse": true,
          "paging": true
        });
      });
      $(document).ready(function() {
        $("#example1").DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
      $(function() {
        $('.tanggal').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
      });
      $(function() {
        $('#tanggal').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
      });
      $(function() {
        $('#tanggal1').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
      });
      $(function() {
        $('#tahun').datepicker({
          changeYear: true,
          changeMonth: false,
          showButtonPanel: true,
          yearRange: "2005:2020"
        });
      });

      $('.tombol-approve').on('click',function (e){
        e.preventDefault();
        const href = $(this).attr('href'); //Ambil atrribut href pada tombol hapus yg sedang d click

        Swal.fire({
        title: 'Apakah anda yakin',
        text: "Meng Approve data cuti ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Approve Cuti !'
        }).then((result) => {
        if (result.value) {
            document.location.href = href; //Jalankan variabel href dengan document.location.href
        }
        })
      })

      $('.tombol-reject').on('click',function (e){
        e.preventDefault();
        const href = $(this).attr('href'); //Ambil atrribut href pada tombol hapus yg sedang d click

        Swal.fire({
        title: 'Apakah anda yakin',
        text: "Mereject data cuti ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reject Cuti !'
        }).then((result) => {
        if (result.value) {
            document.location.href = href; //Jalankan variabel href dengan document.location.href
        }
        })
      })

      $('.tombol-cancel').on('click',function (e){
        e.preventDefault();
        const href = $(this).attr('href'); //Ambil atrribut href pada tombol hapus yg sedang d click

        Swal.fire({
        title: 'Apakah anda yakin',
        text: "Meng Cancel data cuti ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Cancel Cuti !',
        cancelButtonText: 'Batal !'
        }).then((result) => {
        if (result.value) {
            document.location.href = href; //Jalankan variabel href dengan document.location.href
        }
        })
      })

      $('.tombol-info-cuti-tahun-lalu').on('click',function (e){
        e.preventDefault();
        const href = $(this).attr('href'); //Ambil atrribut href pada tombol hapus yg sedang d click

        Swal.fire({
        title: 'INFO !',
        text: "Untuk Sisa CT tahun lalu actual nya sudah d tambahkan ke Cuti Tahunan.",
        icon: 'warning',
        // showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
        // cancelButtonText: 'Kembali'
        })
      })
      $('.tombol-info-cuti-bersama').on('click',function (e){
        e.preventDefault();
        const href = $(this).attr('href'); //Ambil atrribut href pada tombol hapus yg sedang d click

        Swal.fire({
        title: 'INFO !',
        text: "Untuk Cuti Bersama actual nya sudah d tambahkan ke Cuti Tahunan.",
        icon: 'warning',
        // showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
        // cancelButtonText: 'Kembali'
        })
      })
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="<?php echo $this->config->item('link_url') ?>assets/dist/js/pages/dashboard.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $this->config->item('link_url') ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/select2/select2.full.min.js"></script>
    <!-- <script src="http://ecuti.enkei.co.id/assets/plugins/select2/select2.full.min.js"></script> -->

    


  </body>

  </html>