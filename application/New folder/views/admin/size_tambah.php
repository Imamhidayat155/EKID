
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">FORM TAMBAH DATA</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php echo form_open('admin/insert_size');?>
                   <div class="form-group">
                    <label for="exampleInputEmail1">KODE</label>
                      <input type="text" readonly class="form-control" name="size_kode" value="<?php echo $autonumb?>"/>
                  </div>
				  <div class="form-group">
                    <label for="">NAMA_ITEM</label>
					<select name="item_id" class="form-control select2" required>
						<option value=''>--PILIH--</option>
						<?php $sql=$this->db->query("select * from m_item")->result();
						foreach($sql as $var){
						  echo "<option value='$var->item_id'>$var->item_nama</option>";
						}
						?>
					</select>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">SIZE</label>
                      <input type="text" class="form-control" name="size_no" placeholder=""/>
                  </div>
                  <a href="<?php echo base_url(); ?>admin/size" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
                <?php echo form_close(); ?>
                
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        