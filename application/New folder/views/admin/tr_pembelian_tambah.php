
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Form Tambah Data Barang Masuk</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php echo form_open('admin/insert_pembelian'); ?>
                 
				  <div class="form-group">
                    <label for="exampleInputEmail1">Tanggal</label>
                      <input type="text" style="width:30%" class="form-control" name="trin_tgl" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo date('Y-m-d')?>"/>
                  </div>
				  
				   <div class="form-group">
                    <label for="exampleInputEmail1">No SJ</label>
                      <input type="text" class="form-control" name="trin_sj" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="">Nama Produk</label>
					<select name="pr_id" class="form-control select2" required>
						<option value=''>--PILIH--</option>
						<?php $sql=$this->db->query("select * from m_product")->result();
						foreach($sql as $var){
						  echo "<option value='$var->pr_id'>$var->pr_partnumber | $var->pr_deskripsi</option>";
						}
						?>
					</select>
                  </div>
				  <div class="form-group">
                    <label for="">Supplier</label>
					<select name="sup_id" class="form-control select2" required>
						<option value=''>--PILIH--</option>
						<?php $sql=$this->db->query("select * from m_supplier")->result();
						foreach($sql as $var){
						  echo "<option value='$var->sup_id'>$var->sup_nama</option>";
						}
						?>
					</select>
                  </div>
				   <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah Barang Masuk</label>
                      <input type="number" class="form-control" name="trin_qty" placeholder=""/>
                  </div>
                 
                  <a href="<?php echo base_url(); ?>admin/pembelian" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Batal</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                <?php echo form_close(); ?>
                
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
       