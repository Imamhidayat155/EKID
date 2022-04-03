
    <!-- Main content -->
    <section class="content">
        
        <div class="row">          	
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive">
            
            <!-- <h3 class="box-title">
                <a href="#" onclick="return confirm('Menu Ini masih dalam proses Develop !!')" class="btn btn-md btn-warning btn-flat"><i class="fa fa-download"></i> EXPORT DATA</a>
            </h3><br> -->
                <table id="example1" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                    <th>NO</th>
                    <th>PIN</th>
                    <th>NAMA</th>
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
                    <td><?php echo $row_jatah_CT->total - $row_potong_CT->total?></td>
                    <td align="center">
                        <div class="btn-group" role="group">                        
                            <a href="<?php echo base_url('leader_up/detail_rekap_sisa_cuti/'.$lihat->kar_id)?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Detail</a>
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
