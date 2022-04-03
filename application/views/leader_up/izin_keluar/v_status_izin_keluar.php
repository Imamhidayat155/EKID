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
                                <th>NAMA KARYAWAN</th>
                                <th>PIN</th>
                                <th>SECTION</th>
                                <th>WAKTU KELUAR</th>
                                <th>WAKTU KEMBALI</th>
                                <th>TUJUAN</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                        </thead>
                        <tbody>
                            <?php  
                $no = 1;
                foreach ($data as $lihat):
                ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->kar_nama ?></td>
                                <td><?php echo $lihat->kar_nik ?></td>
                                <td><?php echo $lihat->dep_nama?></td>
                                <td><?php echo $lihat->waktu_start?></td>
                                <td><?php echo $lihat->waktu_finish?></td>
                                <td><?php echo $lihat->tujuan?></td>
                                <td><small class="label bg-orange"><b style="color: white;"><?php if($lihat->status == 1){echo "Menunggu Konfirmasi";} ?></b></small></td>
                                <td align="center">
                                    <div class="btn btn-default" role="group">
                                        <a href="<?php echo base_url(); ?>leader_up/edit_izin_keluar/<?php echo $lihat->id ?>"
                                            class="btn btn-sm btn-primary "><i class="fa fa-edit"></i> Edit</a>

                                        <a href="<?php echo base_url(); ?>leader_up/hapus_izin_keluar/<?php echo $lihat->id ?>"
                                            onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')"
                                            class="btn btn-sm btn-danger "><i class="fa fa-trash"></i> Hapus</a>
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