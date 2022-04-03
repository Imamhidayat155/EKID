
        <!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
				
                <div class="box-body table-responsive">
                
                <h3 class="box-title">
        <a href="<?php echo base_url(); ?>laporan/export_request" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-download"></i> Export Data</a>
        
                  </h3>
                  <table id="example1" class="table table-bordered table-hover dataTable">
                    <thead>
                      <tr>
                        <th>NO</th>
						<th>KODE</th>
                        <th>NAMA</th>
                        <th>POINT_DIGUNAKAN</th>
						<th>TANGGAL</th>
                        <th>PRINT</th>
                        <th>AKSI</th>
                    </thead>
                    <tbody>
                      	<?php  
                        $no = 1;
                        foreach ($data as $lihat):
                        ?>
                    	<tr>
                        <td><?php echo $no++ ?></td>
							<td><?php echo $lihat->reqhed_code?></td>
							<td><?php echo $lihat->kar_nama?></td>
							<td><?php echo $lihat->reqhed_totalpoint?></td>
							<td><?php echo $lihat->reqhed_tanggal?></td>
                        <td align="center">
						 <a href="#" onclick="window.open('<?php echo base_url('laporan/cetak_request/'.$lihat->reqhed_code)?>','myWindow','width=700,height=400')" class="btn btn-sm"><i class="fa fa-print"></i> </a>
						</td>
                        <td align="center">
                          <div class="btn-group" role="group">
							
                            <a href="<?php echo base_url(); ?>admin/request/<?php echo $lihat->reqhed_code?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Detail</a>
                            <a href="<?php echo base_url(); ?>admin/hapus_header/<?php echo $lihat->reqhed_code ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a>
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
