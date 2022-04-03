<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">FORM EDIT DATA</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php
      foreach ($editdata as $data) :
        echo form_open('admin/update_standar_cuti/' . $data->har_cuti_id); ?>

        <div class="form-group">
          <label for="exampleInputEmail1">KODE_CUTI</label>
          <input type="text" class="form-control" name="cuti_kode" value="<?php echo $data->cuti_kode ?>" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">NAMA_CUTI</label>
          <input type="text" class="form-control" name="cuti_namacuti" value="<?php echo $data->cuti_namacuti ?>" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">JUMLAH_CUTI</label>
          <input type="text" class="form-control" name="cuti_jumlahcuti" value="<?php echo $data->cuti_jumlahcuti ?>" />
        </div>
        <a href="<?php echo base_url(); ?>admin/karyawan" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
        <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
      <?php endforeach ?>
      <?php echo form_close(); ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->