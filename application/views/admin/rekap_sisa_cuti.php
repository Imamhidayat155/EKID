
    <!-- Main content -->
    <section class="content">
        
        <div class="row">          	
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive">
            
            <h3 class="box-title">
            <button type="button" onclick="exportSisaCutiCT()" class="btn btn-md btn-success"> <i class="fa fa-file-excel-o"></i> Export Sisa Cuti CT</button> 	
            <button type="button" onclick="exportSisaCutiCP()" class="btn btn-md btn-warning"> <i class="fa fa-file-excel-o"></i> Export Sisa Cuti CP</button> 	
            <!-- <button type="button" onclick="exportDetailCutiCT()" class="btn btn-md btn-success"> <i class="fa fa-file-excel-o"></i> Export Detail Cuti CT</button> 
            <button type="button" onclick="exportDetailCutiCP()" class="btn btn-md btn-warning"> <i class="fa fa-file-excel-o"></i> Export Detail Cuti CP</button>  -->
            </h3>
                <table id="example" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                    <th>NO</th>
                    <th>PIN</th>
                    <th>NAMA</th>
                    <th>SECTION</th>
                    <th>SISA CT</th>
                    <th>SISA CP</th>
                    <th>AKSI</th>
                </thead>
                <tbody>
                    <?php  
                    $no = 1;
                    foreach ($data as $lihat):
                        $row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                        $row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                        $row_jatah_CP = $this->db->get_where('v_jatah_CP_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                        $row_potong_CP = $this->db->get_where('v_potong_CP_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $lihat->kar_nik?></td>
                        <td><?php echo $lihat->kar_nama?></td>
                        <td><?php echo $lihat->dep_nama?></td>
                        <td><?php echo $row_jatah_CT->total - $row_potong_CT->total?></td>
                        <td><?php echo $row_jatah_CP->total - $row_potong_CP->total?></td>
                        <td align="center">
                            <div class="btn-group" role="group">
                            
                            <a href="<?php echo base_url('admin/detail_rekap_sisa_cuti/'.$lihat->kar_id); ?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Detail</a>
                            <!-- <a href="<?php echo base_url(); ?>admin/hapus_header/<?php echo $lihat->reqhed_code ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a> -->
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

<script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jQuery/jquery-1.6.4.min.js"></script>
<script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jQuery/jquery-1.8.24.min.js"></script>
<link   href="<?php echo $this->config->item('link_url') ?>assets/plugins/jQueryUI/jquery-ui.css" rel="Stylesheet"type="text/css"/>

<script>
function exportSisaCutiCT(){
window.open('<?php echo base_url()?>admin/export_yearly');
}
function exportSisaCutiCP(){
window.open('<?php echo base_url()?>admin/export_yearly_cp');
}
function exportDetailCutiCT(){
window.open('<?php echo base_url()?>admin/export_detail_cuti_ct');
}
function exportDetailCutiCP(){
window.open('<?php echo base_url()?>admin/export_detail_cuti_cp');
}


</script>

    </section>
