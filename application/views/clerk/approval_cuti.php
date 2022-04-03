<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                
                    <table id="example" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE CUTI</th>
                                <th>NAMA KARYAWAN</th>
                                <th>MULAI CUTI</th>
                                <th>SELESAI CUTI</th>
                                <th>LAMA CUTI</th>
                                <th>SISA CUTI</th>
                                <th>ALASAN CUTI</th>
                                <th>AKSI</th>

                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($data as $lihat):
                                    $getmCuti=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$lihat->kar_id'")->row();
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->pc_kode?></td>
                                <td><?php echo $lihat->kar_nama?></td>
                                <td><?php echo $lihat->pc_tanggalfrom?></td>
                                <td><?php echo $lihat->pc_tanggalto?></td>
                                <td><?php echo $lihat->pc_lamacuti?> Hari</td>

                                <?php if($lihat->pc_status == 1){ ?>
                                    <td><?php echo $getmCuti->jatah_cuti - $getmCuti->cuti_diambil?></td>
                                <?php }else{ ?>
                                    <td><?php echo $lihat->pc_sisacuti?></td>
                                <?php } ?>

                                <td><?php echo $lihat->pc_keterangan?></td>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <?php if($lihat->pc_status!='Disetujui'){ ?>
                                        <a href="<?php echo base_url(); ?>leader_up/approve_trcuti/<?php echo $lihat->pc_id ?>"
                                            class="btn btn-sm btn-success tombol-approve"><i class="fa fa-check-circle"></i> Approve</a>

                                        <a href="<?php echo base_url(); ?>leader_up/reject_trcuti/<?php echo $lihat->pc_id ?>"
                                            class="btn btn-sm btn-danger btn-flat tombol-reject"><i class="fa fa-times-circle"></i> Reject</a>
                                        <?php } ?>
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
