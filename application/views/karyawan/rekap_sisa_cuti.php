
    <!-- Main content -->
    <section class="content">
        
        <div class="row">          	
        <div class="col-xs-12">
            <div class="box">
            
            <div class="box-body table-responsive">
            
            <h3 class="box-title">
            <button type="button" onclick="exportsisacuti()" class="btn btn-md btn-success"> <i class="fa fa-file-excel-o"></i> Export Sisa Cuti All</button>
            </h3>
                <table id="example" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                    <th>NO</th>
                    <th>PIN</th>
                    <th>NAMA</th>
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
                        <td><?php echo $row_jatah_CT->total - $row_potong_CT->total ?></td>
                    <td align="center">
                        <div class="btn-group" role="group">                        
                            <a href="<?php echo base_url('karyawan/detail_rekap_cuti_karyawan/'.$lihat->kar_id)?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Detail</a>
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
    
<script src ="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src ="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<link   href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"type="text/css"/>

<script>
function exportsisacuti(){
window.open('<?php echo base_url()?>karyawan/export_yearly');
}


</script>
    </section><!-- /.content -->
