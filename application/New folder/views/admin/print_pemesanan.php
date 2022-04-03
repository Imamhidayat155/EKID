
        <!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
                <div class="box-body table-responsive">
                
                  <table id="example1" class="table table-bordered table-hover dataTable">
                    <thead>
                      <tr>
                        <th>No</th>
						<th>Kode</th>
						<th>Tanggal</th>
                        <th>Jenis</th>
                        <th>No Polisi</th>
                        <th>KM</th>
                        <th>Customer</th>
                        <th>Total Qty</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                      	<?php  
                        $no = 1;
                        foreach ($data as $lihat):
                        ?>
                    	<tr>
                        <td><?php echo $no++ ?></td>
							<td><?php echo $lihat->trout_kode?></td>
                    		<td><?php echo $lihat->trout_date?></td>
							<td><?php echo $lihat->trout_jenis?></td>
							<td><?php echo $lihat->trout_nopol?></td>
							<td><?php echo $lihat->trout_km?></td>
							<td><?php echo $lihat->mbr_nama?></td>
							<td><?php echo $lihat->trout_totalqty?></td>
							<td><?php echo number_format($lihat->trout_totalrp)?></td>
                        <td align="center">
                          <div class="btn-group" role="group">
							<a href="#" onclick="window.open('<?php echo base_url(); ?>admin/cetak_kwitansi/<?php echo $lihat->trout_id ?>')" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-print"></i> Cetak Faktur</a>
                            
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
