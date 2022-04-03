
    <!-- Main content -->
    <section class="content">
        
        <div class="row">          	
            <div class="col-xs-12">
                <div class="box">                
                    <div class="box-body table-responsive">                
                        <h3 class="box-title">
                            <a href="<?php echo base_url('laporan/detail_ct/'.$this->uri->segment('3')); ?>#" class="btn btn-md btn-success"><i class="fa fa-download "> </i> Print History CT </a>
                            <a href="<?php echo base_url('laporan/detail_cp/'.$this->uri->segment('3')); ?>#" class="btn btn-md btn-warning"><i class="fa fa-download "> </i> Print History CP </a>
                        </h3>
                        <table id="example2" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>KODE CUTI</th>
                                    <th>NAMA</th>
                                    <th>MULAI CUTI</th>
                                    <th>SELESAI CUTI</th>
                                    <th>LAMA CUTI</th>
                                    <th>SISA CUTI</th>
                                    <th>ALASAN</th>
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
                    </div>
                </div>
            </div>
        </div>    

    </section><!-- /.content -->
