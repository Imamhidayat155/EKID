<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">                        
                    </div>
                </div><!-- /.box-header -->
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('notif');?>"></div>
                <div class="box-body table-responsive">
                
                    <table id="example" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>PIN</th>
                                <th>NAMA KARYAWAN</th>
                                <th>SECTION</th>
                                <th>SISA CUTI</th>
                                <th>AKSI</th>

                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($data as $lihat):
                                    $row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                                    $row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->kar_nik?></td>
                                <td><?php echo $lihat->kar_nama?></td>
                                <td><?php echo $lihat->dep_nama?></td>
                                <td><?php echo $row_jatah_CT->total - $row_potong_CT->total?></td>

                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <?php if($lihat->pc_status!='Disetujui'){ ?>
                                        <!-- <a href="<?php echo base_url(); ?>admin/cancel_trcuti/<?php echo $lihat->pc_id ?>"

                                            class="btn btn-sm btn-success tombol-approve"><i class="fa fa-check-circle"></i> DETAIL</a> -->

                                        <a href="<?php echo base_url(); ?>admin/detail_rekap_cuti_karyawan_cancel_cuti/<?php echo $lihat->kar_id ?>"

                                            class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> DETAIL</a>
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