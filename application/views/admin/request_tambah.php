
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Tambah Data</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php echo form_open('admin/insert_request');?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">KODE</label>
                      <input type="text" readonly class="form-control" name="reqhed_code" value="<?php echo $autonumb?>"/>
                  </div>
				  <div class="form-group">
                    <label for="">NAMA</label>
					<select name="item_id" class="form-control select2" required>
						<option value=''>--PILIH--</option>
						<?php $sql=$this->db->query("select * from m_item")->result();
						foreach($sql as $var){
						  echo "<option value='$var->item_id'>$var->item_kode | $var->item_nama</option>";
						}
						?>
					</select>
                  </div>
				  <div class="form-group">
                    <label for="">WARNA</label>
					<select name="warna_id" class="form-control select2" required>
						<option value=''>--PILIH--</option>
						<?php $sql=$this->db->query("select * from m_warna")->result();
						foreach($sql as $var){
						  echo "<option value='$var->warna_id'>$var->warna_nama</option>";
						}
						?>
					</select>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">QTY_REQUEST</label>
                      <input type="text" class="form-control" name="req_qty" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="">SIZE</label>
					<select name="size_id" class="form-control select2" >
						<option value=''>--PILIH--</option>
						<?php $sql=$this->db->query("select * from m_size")->result();
						foreach($sql as $var){
						  echo "<option value='$var->size_id'>$var->size_no</option>";
						}
						?>
					</select>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">TANGGAL</label>
                      <input type="text" style="width:100%" class="form-control" name="req_tanggal" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo date('Y-m-d')?>" />
                  </div>
                  <a href="<?php echo base_url(); ?>admin/request" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Batal</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                <?php echo form_close(); ?>
                
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        