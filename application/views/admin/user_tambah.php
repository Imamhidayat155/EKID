<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"> TAMBAH DATA</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <form method="post" action="<?php echo base_url() ?>admin/insert_user" enctype="multipart/form-data">

        <div class="form-group">
          <label for="exampleInputEmail1">NAMA_USER</label>
          <input type="text" class="form-control" name="user_nama" placeholder="" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">PIN_USER</label>
          <input type="text" class="form-control" name="user_pin" placeholder="" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">USERNAME</label>
          <input type="text" class="form-control" name="user_username" placeholder="" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">PASSWORD</label>
          <input type="text" class="form-control" name="user_password" placeholder="" />
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
          <label for="">DEPARTEMENT</label>
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
          <input type="text" class="form-control" name="user_email" placeholder="" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">TANGGAL_MASUK</label>
          <input type="text" style="width:100%" class="form-control" name="user_tanggal_masuk" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo date('Y-m-d') ?>" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">JENIS_KELAMIN</label>
          <?php
          $arrcombo = array(
            'Laki-Laki' => 'Laki-Laki',
            'Perempuan' => 'Perempuan'
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
          <label for="exampleInputEmail1">FOTO</label>
          <input type="file" class="form-control" name="user_foto" placeholder="" />
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

        <a href="<?php echo base_url(); ?>admin/user" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
        <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
        <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->