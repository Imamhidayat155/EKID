
	<!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
                <div class="box-header">
                  <h3 class="box-title">
				  <a href="<?php echo base_url(); ?>laporan/export_pemesanan" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-download"></i> Export Data</a>
				  <a href="#" onclick="window.open('<?php echo base_url(); ?>laporan/preview_pemesanan')" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Preview</a>
                  </h3>
                  <div class="box-tools">
                  	<!--
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                    -->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                
                  <table id="example1" class="table table-bordered table-hover dataTable">
                    <thead>
                      <tr>
                        <th>No</th>
						<th>Kode Pesanan</th>
						<th>Tgl Pesanan</th>
                        <th>Customer</th>
                        <th>Total Tagihan</th>
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
							<td><?php echo ucwords($lihat->mbr_nama)?></td>
							<td><?php echo number_format($lihat->trout_totalrp)?></td>     		
                    	</tr>
                    	<?php endforeach; ?>
                    </tbody>
                  </table>
                  
                </div><!-- /.box-body -->
                </div>
             </div>
          </div>
        

        </section><!-- /.content -->

    
