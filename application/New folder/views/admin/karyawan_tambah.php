
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">FORM TAMBAH DATA</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php echo form_open('admin/insert_karyawan');?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">NIK_KARYAWAN</label>
                      <input type="text" class="form-control" name="kar_nik" placeholder=""/>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">NAMA_KARYAWAN</label>
                      <input type="text" class="form-control" name="kar_nama" placeholder=""/>
                  </div>
				   <div class="form-group">
                    <label for="exampleInputEmail1">EMAIL</label>
                      <input type="text" class="form-control" name="kar_email" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">TANGGAL_MASUK</label>
                      <input type="text" style="width:100%" class="form-control" name="kar_gabung" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo date('Y-m-d')?>" />
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">SECTION</label>
                      <input type="text" class="form-control" name="kar_section" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">POSISI</label>
                      <input type="text" class="form-control" name="kar_posisi" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">JENIS_KELAMIN</label>
						<?php 
						$arrcombo=array(
						'Laki-Laki'=>'Laki-Laki',
						'Perempuan'=>'Perempuan'
						);
						echo form_dropdown('kar_jeniskelamin',$arrcombo,'','class=form-control');
						?>
				  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">PLANT</label>
                      <input type="text" class="form-control" name="kar_plant" placeholder=""/>
                  </div>
                  <a href="<?php echo base_url(); ?>admin/karyawan" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
                <?php echo form_close(); ?>
                
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        