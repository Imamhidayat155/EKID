   <!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
                <div class="box-header">
                  <h3 class="box-title">
				  <!--<a href="<?php echo base_url(); ?>admin/tambah_request" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>-->
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
                        <th>NO</th>
						<th>KODE</th>
						<th>ITEM</th>
						<th>WARNA</th>
						<th>QTY_REQUEST</th>
						<th>SIZE</th>
						<th>REQ_TANGGAL</th>
                    </thead>
                    <tbody>
                      	<?php  
                        $no = 1;
                        foreach ($data as $lihat):
                        ?>
                    	<tr>
                        <td><?php echo $no++ ?></td>
							<td><?php echo $lihat->reqhed_code?></td>
							<td><?php echo $lihat->item_nama?></td>
							<td><?php echo $lihat->warna_nama?></td>
							<td><?php echo $lihat->req_qty?></td>
							<td><?php echo $lihat->size_no?></td>
							<td><?php echo $lihat->req_tanggal?></td>
                    	</tr>
                    	<?php endforeach; ?>
                    </tbody>
                  </table>
                  
                </div><!-- /.box-body -->
                </div>
             </div>
          </div>
        

        </section><!-- /.content -->
