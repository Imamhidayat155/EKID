
    <!-- Main content -->
    <section class="content">
        
        <div class="row">          	
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive">
            
            <h3 class="box-title">
                <a href="<?php echo base_url('laporan/cetak_request/'.$this->session->userdata('id')); ?>" class="btn btn-md btn-warning btn-flat"><i class="fa fa-download"></i> PRINT DATA</a>
            </h3><br>
                <table id="example2" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>KODE CUTI</th>
                        <th>NAMA KARYAWAN</th>
                        <th>MULAI CUTI</th>
                        <th>SELESAI CUTI</th>
                        <th>LAMA CUTI</th>
                        <th>SISA CUTI</th>
                        <th>ALASAN CUTI</th>
                        <th>STATUS CUTI</th>
                        <th>ACTIONED BY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $no = 1;
                        foreach ($data as $lihat):
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                            <td><?php echo $lihat->pc_kode?></td>
                            <td><?php echo $lihat->kar_nama?></td>
                            <td><?php echo $lihat->pc_tanggalfrom?></td>
                            <td><?php echo $lihat->pc_tanggalto?></td>
                            <td><?php echo $lihat->pc_lamacuti?> Hari</td>
                            <td><?php echo $lihat->pc_sisacuti?></td>
                            <td><?php echo $lihat->pc_keterangan?></td>
                            <td><b><?php echo $lihat->status_nama?></b></td>
                            <td><b><?php echo $lihat->pc_approvedby?></b></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
                
            </div><!-- /.box-body -->
            </div>
            </div>
        </div>
    

    </section><!-- /.content -->
