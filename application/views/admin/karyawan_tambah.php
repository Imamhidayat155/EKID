<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">FORM TAMBAH DATA</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php echo form_open('admin/insert_karyawan'); ?>
      <div class="form-group">
        <label for="exampleInputEmail1">NAMA_USER</label>
        <input type="text" class="form-control" name="kar_nama" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">PIN_USER</label>
        <input type="text" class="form-control" name="kar_nik" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">USERNAME</label>
        <input type="text" class="form-control" name="kar_username" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">PASSWORD</label>
        <input type="text" class="form-control" name="kar_password" placeholder="" />
      </div>
      <div class="form-group">
        <label for="">JABATAN</label>
        <select name="jab_id" class="form-control select2" required>
          <option value="">--PILIH--</option>
          <?php $sql = $this->db->query("select * from m_jabatan")->result();
          foreach ($sql as $var) {
            echo "<option value='$var->jab_id'>$var->jab_nama</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="">SECTION</label>
        <select name="dep_id" class="form-control select2" required>
          <option value="">--PILIH--</option>
          <?php $sql = $this->db->query("select * from m_departement")->result();
          foreach ($sql as $var) {
            echo "<option value='$var->dep_id'>$var->dep_nama</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">EMAIL</label>
        <input type="text" class="form-control" name="kar_email" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">TANGGAL_MASUK</label>
        <input type="text" style="width:100%" class="form-control" name="kar_tanggalmasuk" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo date('Y-m-d') ?>" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">JENIS_KELAMIN</label>
        <?php
        $arrcombo = array(
          'L' => 'Laki-Laki',
          'P' => 'Perempuan'
        );
        echo form_dropdown('kar_jeniskelamin', $arrcombo, '', 'class=form-control');
        ?>
      </div>
      <div class="form-group">
        <label for="">PLANT</label>
        <select name="plant_id" class="form-control select2" required>
          <option value="">--PILIH--</option>
          <?php $sql = $this->db->query("select * from m_plant")->result();
          foreach ($sql as $var) {
            echo "<option value='$var->plant_id'>$var->plant_nama</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="">HAK_AKSES</label>
        <select name="akses_id" class="form-control select2" required>
          <option value="">--PILIH--</option>
          <?php $sql = $this->db->query("select * from m_user_akses")->result();
          foreach ($sql as $var) {
            echo "<option value='$var->akses_id'>$var->akses_nama</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">FOTO</label>
        <input type="file" class="form-control" name="kar_foto" placeholder="" />
      </div>
      
      <a href="<?php echo base_url(); ?>admin/karyawan" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
      <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
      <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->