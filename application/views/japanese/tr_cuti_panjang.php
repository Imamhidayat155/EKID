<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
                <div class="box-body table-responsive">
                
                    <table id="example" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th>NO</th>
                                <th>KODE CUTI</th>
                                <th>NAMA KARYAWAN</th>
                                <th>MULAI CUTI</th>
                                <th>TAMBAH CUTI</th>
                                <th>LAMA CUTI</th>
                                <th>SISA CUTI</th>
                                <th>ALASAN CUTI</th>
                                <th>STATUS CUTI</th>
                                <th>AKSI</th>
                        </thead>
                        <tbody>
                            <?php  
                $no = 1;
                foreach ($data as $lihat):
                    $getmCuti=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE kar_id='$lihat->kar_nik'")->row();
                ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->pc_kode?></td>
                                <td><?php echo ucwords($lihat->kar_nik)." | ".ucwords($lihat->kar_nama)?></td>
                                <td><?php echo $lihat->pc_tanggalfrom?></td>
                                <td><?php echo $lihat->pc_tanggalto?></td>
                                <td><?php echo $lihat->pc_lamacuti?></td>

                                <?php if($lihat->pc_status=='Menunggu Konfirmasi'){ ?>
                                <td><?php echo $getmCuti->mc_jatahcuti-$getmCuti->mc_cutidiambil?></td>
                                <?php }else{ ?>
                                <td><?php echo $lihat->ct_sisacuti?></td>
                                <?php } ?>

                                <td><?php echo $lihat->pc_keterangan?></td>
                                <td><?php echo $lihat->pc_status?></td>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <?php if($lihat->pc_status!='Disetujui'){ ?>
                                        <a href="<?php echo base_url(); ?>admin/edit_trcuti_panjang/<?php echo $lihat->pc_id ?>"
                                            class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="<?php echo base_url(); ?>admin/hapus_trcuti/<?php echo $lihat->pc_id ?>"
                                            onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')"
                                            class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a>
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