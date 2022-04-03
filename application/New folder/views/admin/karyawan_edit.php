
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">FORM EDIT DATA</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php  
                foreach ($editdata as $data):
                echo form_open('admin/update_karyawan/'.$data->kar_id); ?>
                  
				          <div class="form-group">
                    <label for="exampleInputEmail1">NIK_KARYAWAN</label>
                      <input type="text" class="form-control" name="kar_nik" value="<?php echo $data->kar_nik?>"/>
                  </div>
				          <div class="form-group">
                      <label for="exampleInputEmail1">NAMA_KARYAWAN</label>
                      <input type="text" class="form-control" name="kar_nama" value="<?php echo $data->kar_nama?>"/>
                  </div>
				          <div class="form-group">
                      <label for="exampleInputEmail1">EMAIL</label>
                      <input type="text" class="form-control" name="kar_email" value="<?php echo $data->kar_email?>"/>
                  </div>
				          <div class="form-group">
                    <label for="exampleInputEmail1">TANGGAL_MASUK</label>
                      <input type="text" class="form-control" name="kar_gabung" value="<?php echo $data->kar_gabung?>"/>
                  </div>
				          <div class="form-group">
                    <label for="exampleInputEmail1">SECTION</label>
                      <input type="text" class="form-control" name="kar_section" value="<?php echo $data->kar_section?>"/>
                  </div>
				          <div class="form-group">
                    <label for="exampleInputEmail1">POSISI</label>
                      <input type="text" class="form-control" name="kar_posisi" value="<?php echo $data->kar_posisi?>"/>
                  </div>
				          <div class="form-group">
                    <label for="exampleInputEmail1">JENIS_KELAMIN</label>
                    <?php 
                    $arrcombo=array(
                    'Laki-Laki'=>'Laki-Laki',
                    'Perempuan'=>'Perempuan'					
                    );
                    echo form_dropdown('kar_jeniskelamin',$arrcombo,$data->kr_kelamin,'class=form-control');
                    ?>
                  </div>
				          <div class="form-group">
                    <label for="exampleInputEmail1">PLANT</label>
                      <input type="text" class="form-control" name="kar_plant" value="<?php echo $data->kar_plant?>"/>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">No Telp</label>
                      <input type="text" class="form-control" name="kar_notelp" value="<?php echo $data->kar_notelp?>"/>
                  </div>

                  <a href="<?php echo base_url(); ?>admin/karyawan" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
                <?php endforeach ?>
                <?php echo form_close(); ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        