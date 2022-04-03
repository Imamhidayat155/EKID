
        <!-- Main content -->
        <section class="content">
          
          	<div class="row">          	
          	<div class="col-xs-12">
          		<div class="box">
                <div class="box-body table-responsive">
                 <h3 class="box-title">
				  <a href="<?php echo base_url(); ?>laporan/export_stok" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-download"></i> Export Data</a>
				  <a href="#" onclick="window.open('<?php echo base_url(); ?>laporan/preview_stok')" class="btn btn-sm btn-success btn-flat"><i class="fa fa-eye"></i> Preview</a>
                  </h3>
                  <table id="example1" class="table table-bordered table-hover dataTable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Part Number & Nama Produk</th>
						<th>Qty Stock</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                      	<?php  
                        $no = 1;
                        foreach ($data as $lihat):
                        ?>
                    	<tr>
                        <td><?php echo $no++ ?></td>
                    		<td><?php echo ucwords($lihat->pr_partnumber)." | ".ucwords($lihat->pr_deskripsi)?></td>
                    		<td><?php echo ucwords($lihat->pr_stok)?></td>
                        <td align="center">
                          <div class="btn-group" role="group">
                            <a href="<?php echo base_url(); ?>admin/edit_produk/<?php echo $lihat->pr_id ?>" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i> Edit</a>
                            <a href="<?php echo base_url(); ?>admin/hapus_produk/<?php echo $lihat->pr_id ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a>
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
