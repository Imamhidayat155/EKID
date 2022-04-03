<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Izin Keluar</span>
              <span class="info-box-number"><?php echo $total_izin_keluar; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Izin Keluar hari ini</span>
              <span class="info-box-number"><?php echo $total_izin_keluar_today ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Events</span>
                    <span class="info-box-number">0</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                        <span class="progress-description">
                            70% Increase in 30 Days
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-success">
        
            <div class="box-header with-border">
                <p class="box-title label label-success"><b>Sudah Approve | <?php echo date("H:i"); ?></b> </p>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                <table id="example_security" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>PIN</th>
                    <th>Section</th>
                    <th>Jam Keluar</th>
                    <th>Jam Kembali</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        foreach ($data_approved as $lihat):
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $lihat->kar_nama?></td>
                        <td><?php echo $lihat->kar_nik?></td>
                        <td><?php echo $lihat->dep_nama?></td>
                        <td><?php echo $lihat->waktu_start?></td>
                        <td><?php echo $lihat->waktu_finish?></td>
                        <td><?php echo $lihat->tujuan?></td>
                        <td><span class="label label-success"><?php if($lihat->status == 2){echo "Approved";}  ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
        </div>

        <div class="box box-warning">
        
            <div class="box-header with-border">
                <p class="box-title label label-warning"><b>Belum Approve | <?php echo date("H:i"); ?></b> </p>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                <table id="example_security2" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>PIN</th>
                        <th>Section</th>
                        <th>Jam Keluar</th>
                        <th>Jam Kembali</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        foreach ($data_belum_approved as $lihat):
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $lihat->kar_nama?></td>
                        <td><?php echo $lihat->kar_nik?></td>
                        <td><?php echo $lihat->dep_nama?></td>
                        <td><?php echo $lihat->waktu_start?></td>
                        <td><?php echo $lihat->waktu_finish?></td>
                        <td><?php echo $lihat->tujuan?></td>
                        <td><span class="label label-warning"><?php if($lihat->status == 1){echo "Belum Approved";}  ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
        </div>

            <!-- /.box -->
        <div class="box box-danger">
        
            <div class="box-header with-border">
                <p class="box-title label label-danger"><b>Tidak Approve | <?php echo date("H:i"); ?></b> </p>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                <table id="example_security2" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>PIN</th>
                        <th>Section</th>
                        <th>Jam Keluar</th>
                        <th>Jam Kembali</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        foreach ($data_not_approved as $lihat):
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $lihat->kar_nama?></td>
                        <td><?php echo $lihat->kar_nik?></td>
                        <td><?php echo $lihat->dep_nama?></td>
                        <td><?php echo $lihat->waktu_start?></td>
                        <td><?php echo $lihat->waktu_finish?></td>
                        <td><?php echo $lihat->tujuan?></td>
                        <td><span class="label label-danger"><?php if($lihat->status == 3){echo "Tidak Approved";}  ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
        </div>
            <!-- /.box -->
    </div>
</section>
