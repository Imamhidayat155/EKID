<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">FORM TAMBAH DATA</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php echo form_open('admin/insert_jabatan'); ?>
      <div class="form-group">
        <label for="exampleInputEmail1">KODE_JABATAN</label>
        <input type="text" class="form-control" name="jab_kode" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">NAMA_JABATAN</label>
        <input type="text" class="form-control" name="jab_nama" placeholder="" />
      </div>
      <a href="<?php echo base_url(); ?>admin/jabatan" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
      <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
      <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->