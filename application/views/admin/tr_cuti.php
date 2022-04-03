'<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                
                    <table id="example1" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE CUTI</th>
                                <th>NAMA KARYAWAN</th>
                                <th>MULAI CUTI</th>
                                <th>SELESAI CUTI</th>
                                <th>LAMA CUTI</th>
                                <th>ALASAN CUTI</th>
                                <th>STATUS CUTI</th>
                                <th>AKSI</th>

                        </thead>
                        <tbody>
                            <?php  
                $no = 1;
                foreach ($data as $lihat):
                    //$getmCuti=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE kar_id='$lihat->kar_id'")->row();
                ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->pc_kode?></td>
                                <td><?php echo $lihat->kar_nama?></td>
                                <td><?php echo $lihat->pc_tanggalfrom?></td>
                                <td><?php echo $lihat->pc_tanggalto?></td>
                                <td><?php echo $lihat->pc_lamacuti?> Hari</td>
                                <td><?php echo $lihat->pc_keterangan?></td>
                                <td><?php echo $lihat->status_nama?></td>

                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo base_url(); ?>admin/edit_trcuti/<?php echo $lihat->pc_id ?>"
                                            class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i> Edit</a>

                                        <a href="<?php echo base_url(); ?>admin/hapus_trcuti/<?php echo $lihat->pc_id ?>"
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