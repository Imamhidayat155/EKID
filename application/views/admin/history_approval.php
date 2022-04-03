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
                                <th>No</th>
                                <th>Kode Cuti</th>
                                <th>NIK / Nama Karyawan</th>
                                <th>Mulai Cuti</th>
                                <th>Selesai Cuti</th>
                                <th>Lama Cuti</th>
                                <th>Sisa Cuti</th>
                                <th>Alasan Cuti</th>
                                <th>Status Cuti</th>
                                <?php if($this->session->userdata('akses')==6){ ?>
                                <th>Aksi</th>
                                <th>Print</th>
                                <?php } ?>

                        </thead>
                        <tbody>
                            <?php
                                function hitung_cuti($jatahcuti, $cuti_diambil){
                                    $sisa_cuti = $jatah_cuti - $cuti_diambil;
                                    return $sisa_cuti;
                                }
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

                                <?php if($lihat->pc_status=='Disetujui'){ ?>
                                    <td><?php echo $getmCuti->mc_jatahcuti-$getmCuti->mc_cutidiambil?></td>
                                <?php }else{ ?>
                                    <td><?php echo $lihat->ct_sisacuti?></td>
                                <?php } ?>

                                <td><?php echo $lihat->pc_keterangan?></td>
                                <td><?php echo $lihat->pc_status?></td>
                                <?php if($this->session->userdata('akses')==6){ ?>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <?php if($lihat->pc_status!='Disetujui'){ ?>
                                        <a href="<?php echo base_url(); ?>admin/approval_tambah/<?php echo $lihat->pc_id ?>"
                                            onclick="javascript: return confirm('Anda yakin akan meng Approve data ini ?')"
                                            class="btn btn-sm btn-success btn-flat"><i class="fa fa-check-circle"></i> Approve</a>

                                        <a href="<?php echo base_url(); ?>admin/hapus_trcuti/<?php echo $lihat->pc_id ?>"
                                            onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')"
                                            class="btn btn-sm btn-danger btn-flat"><i class="fa fa-times-circle"></i> Reject</a>
                                        <?php } ?>
                                    </div>
                                </td>
                                <?php if($lihat->pc_status=='Disetujui'){ ?>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <a href="#"
                                            onclick="window.open('<?php echo base_url(); ?>admin/cetak_trcuti/<?php echo $lihat->ct_id ?>')"
                                            class="btn btn-sm btn-info btn-flat"><i class="fa fa-print"></i>Print</a>
                                    </div>
                                </td>
                                <?php } else { ?>
                                <td></td>
                                <?php } ?>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>


</section><!-- /.content -->