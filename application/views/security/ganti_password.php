<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">FORM TAMBAH DATA</h3>
    </div>
    <div class="box-body">
      <!-- form start -->

      <?php 
      foreach ($editdata as $data):
      echo form_open('karyawan/update_password/'. $data->kar_id); ?>

        <div class="form-group">
          <label for="exampleInputEmail1">PASSWORD SAAT INI</label>
          <input type="text" class="form-control" name="old_password" value="<?php echo $data->kar_password ?>" readonly />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">PASSWORD BARU</label>
          <input type="text" class="form-control" name="kar_password" placeholder="Ketikan password baru anda !" required />
        </div>
        <a href="<?php echo base_url('security'); ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
        <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
      <?php endforeach ?>
      <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->