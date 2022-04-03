
    <!-- Main content -->
    <section class="content">
        
        <div class="row">          	
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive">
            
            <h3 class="box-title">
                <a href="<?php echo base_url(); ?>#" class="btn btn-md btn-warning btn-flat"><i class="fa fa-download"></i> Export Data</a>
            </h3>
                <table id="example1" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                    <th>NO</th>
                    <th>PIN</th>
                    <th>NAMA</th>
                    <!-- <th>PRINT</th> -->
                    <th>AKSI</th>
                </thead>
                <tbody>
                    <?php  
                    $no = 1;
                    foreach ($data as $lihat):
                    ?>
                    <tr>
                    <td><?php echo $no++ ?></td>
                        <td><?php echo $lihat->kar_nik?></td>
                        <td><?php echo $lihat->kar_nama?></td>
                    <!-- <td align="center">
                        <a href="#" onclick="window.open('<?php echo base_url('laporan/cetak_request/'.$lihat->kar_id)?>','myWindow','width=700,height=400')" class="btn btn-sm"><i class="fa fa-print"></i> </a>
                    </td> -->
                    <td align="center">
                        <div class="btn-group" role="group">                        
                            <a href="<?php echo base_url('manager/detail_history_approval/'.$lihat->kar_id)?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Detail</a>
                        </div>
                    </td>                  		
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
                
            </div><!-- /.box-body -->
            </div>
            </div>
        </div>
    

    </section><!-- /.content -->
