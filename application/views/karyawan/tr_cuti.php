'<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                
                    <table id="example2" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE CUTI</th>
                                <th>NAMA KARYAWAN</th>
                                <th>GROUP</th>
                                <th>MULAI CUTI</th>
                                <th>SELESAI CUTI</th>
                                <th>LAMA CUTI</th>
                                <th>JENIS CUTI</th>
                                <th>ALASAN CUTI</th>
                                <!-- <th style="color: blue;">Approved By Leader Up</th> -->
                                <th>STATUS CUTI</th>
                                <th>AKSI</th>
                        </thead>
                        <tbody>
                            <?php  
                $no = 1;
                foreach ($data as $lihat):
                    //getmCuti=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$lihat->kar_id'")->row();
                ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->pc_kode?></td>
                                <td><?php echo $lihat->kar_nama ?></td>
                                <td><?php echo $lihat->pc_grup_line ?></td>
                                <td><?php echo $lihat->pc_tanggalfrom?></td>
                                <td><?php echo $lihat->pc_tanggalto?></td>
                                <td><?php echo $lihat->pc_lamacuti?> Hari</td>
                                <td><?php echo $lihat->cuti_kode?></td>
                                <td><?php echo $lihat->pc_keterangan?></td>
                                <!-- <td><?php echo $lihat->actioned_by?></td> -->
                                <td><b style="color: #FFA500;"><?php echo $lihat->status_nama?></b></td>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo base_url(); ?>karyawan/edit_trcuti/<?php echo $lihat->pc_id ?>"
                                            class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i> Edit</a>

                                        <a href="<?php echo base_url(); ?>karyawan/hapus_header/<?php echo $lihat->pc_id ?>"
                                            onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')"
                                            class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a>
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


</section><!-- /.content -->'