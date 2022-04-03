
          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Ganti Foto Profile</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php  
                foreach ($editdata as $data):?>
				<form action="<?php echo base_url()?>admin/update_fotoprofile/<?php echo $data->user_id?>" method="post" enctype="multipart/form-data">

				  <div class="form-group">
				  <label for="exampleInputEmail1">Foto Admin</label>
                      <input type="file" class="form-control" name="file_name" value=""/>
                  </div>
				  
                  <a href="<?php echo base_url(); ?>admin/user" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Batal</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                <?php endforeach ?>
                <?php echo form_close(); ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->
        