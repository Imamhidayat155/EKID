<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">FORM TAMBAH DATA</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php echo form_open('admin/insert_standar_cuti'); ?>
      <div class="form-group">
        <label for="exampleInputEmail1">KODE_CUTI</label>
        <input type="text" class="form-control" name="cuti_kode" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">NAMA_CUTI</label>
        <input type="text" class="form-control" name="cuti_namacuti" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">JUMLAH_CUTI</label>
        <input type="text" class="form-control" name="cuti_jumlahcuti" placeholder="" />
      </div>
      <a href="<?php echo base_url(); ?>admin/standar_cuti" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
      <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
      <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->