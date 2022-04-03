        <!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
                <div class="box-header">
                  <h3 class="box-title">
				  <a href="<?php echo base_url(); ?>admin/tambah_pembelian" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
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
						<th>Tanggal</th>
						<th>No SJ</th>
                        <th>Nama Barang</th>
						<th>Jumlah Barang</th>
						<th>Supplier</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                      	<?php  
                        $no = 1;
                        foreach ($data as $lihat):
                        ?>
                    	<tr>
                        <td><?php echo $no++ ?></td>
                    		<td><?php echo ($lihat->trin_tgl)?></td>
							<td><?php echo $lihat->trin_sj?></td>
							<td><?php echo $lihat->pr_deskripsi?></td>
							<td><?php echo $lihat->trin_qty?></td>
							<td><?php echo $lihat->sup_nama?></td>
                        <td align="center">
                          <div class="btn-group" role="group">
                            <!--<a href="<?php echo base_url(); ?>admin/edit_pembelian/<?php echo $lihat->trin_id ?>" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i> Edit</a>-->
                            <a href="<?php echo base_url(); ?>admin/hapus_pembelian/<?php echo $lihat->trin_id ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a>
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
