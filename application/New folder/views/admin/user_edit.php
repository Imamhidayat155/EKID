
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"> FORM EDIT</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php  
                foreach ($editdata as $data):
                echo form_open('admin/update_user/'.$data->user_id); ?>
                  
				  <div class="form-group">
                    <label for="exampleInputEmail1">NAMA</label>
                      <input type="text" class="form-control" name="user_nama" value="<?php echo $data->user_nama?>"/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">USERNAME</label>
                      <input type="text" class="form-control" name="user_username" value="<?php echo $data->user_username?>"/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">PASSWORD</label>
                      <input type="text" class="form-control" name="user_password" value="<?php echo $data->user_password?>"/>
                  </div>			  
				  <div class="form-group">
                    <label for="exampleInputEmail1">HAK_AKSES</label>
						<?php 
						$arrcombo=array(
						'Admin'=>'Admin',
						'Super User'=>'Super User'
						);
						echo form_dropdown('user_aksessebagai',$arrcombo,$data->user_aksessebagai,'class=form-control');
						?>
				  </div>
				  
                  <a href="<?php echo base_url(); ?>admin/user" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
                <?php endforeach ?>
                <?php echo form_close(); ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        