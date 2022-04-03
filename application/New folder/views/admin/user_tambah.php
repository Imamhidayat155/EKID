
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"> TAMBAH DATA</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php //echo form_open('admin/insert_user');?>
				<form method="post" action="<?php echo base_url()?>admin/insert_user" enctype="multipart/form-data">
                  
				  <div class="form-group">
                    <label for="exampleInputEmail1">NAMA_USER</label>
                      <input type="text" class="form-control" name="user_nama" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">USERNAME</label>
                      <input type="text" class="form-control" name="user_username" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">PASSWORD</label>
                      <input type="text" class="form-control" name="user_password" placeholder=""/>
                  </div>	
				  <div class="form-group">
                    <label for="exampleInputEmail1">FOTO</label>
                      <input type="file" class="form-control" name="user_foto" placeholder=""/>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">HAK_AKSES</label>
						<?php 
						$arrcombo=array(
              'Admin'=>'Admin',
              'Super User'=>'Super User'
						);
						echo form_dropdown('user_aksessebagai',$arrcombo,'','class=form-control');
						?>
				  </div>
				  
                  <a href="<?php echo base_url(); ?>admin/user" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
                <?php echo form_close(); ?>
                
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        