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
        echo form_open('admin/update_karyawan/' . $data->kar_id); ?>

        <div class="form-group">
          <label for="exampleInputEmail1">NAMA_USER</label>
          <input type="text" class="form-control" name="kar_nama" value="<?php echo $data->kar_nama ?>" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">PIN_USER</label>
          <input type="text" class="form-control" name="kar_nik" value="<?php echo $data->kar_nik ?>" />
        </div>
        <div class="form-group">
          <label for="">JABATAN</label>
          <select name="jab_id" class="form-control select2" required>
            <?php $sql = $this->db->query("SELECT * FROM m_jabatan WHERE jab_id='$data->jab_id'")->result();
            foreach ($sql as $var) {
              echo "<option value='$var->jab_id'>$var->jab_nama</option>";
            }
            $sql2 = $this->db->query("SELECT * FROM m_jabatan WHERE jab_id!='$data->jab_id'")->result();
            foreach ($sql2 as $var) {
              echo "<option value='$var->jab_id'>$var->jab_nama</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">DEPARTEMENT</label>
          <select name="dep_id" class="form-control select2" required>
            <?php $sql = $this->db->query("SELECT * FROM m_departement WHERE dep_id='$data->dep_id'")->result();
            foreach ($sql as $var) {
              echo "<option value='$var->dep_id'>$var->dep_nama</option>";
            }
           $sql1 = $this->db->query("SELECT * FROM m_departement WHERE dep_id!='$data->dep_id'")->result();
            foreach ($sql1 as $var) {
              echo "<option value='$var->dep_id'>$var->dep_nama</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">EMAIL</label>
          <input type="text" class="form-control" name="kar_email" value="<?= $data->kar_email ?>" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">TANGGAL_MASUK</label>
          <input type="text" style="width:100%" class="form-control" name="kar_tanggalmasuk" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo $data->kar_tanggalmasuk ?>" />
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">TANGGAL_KELUAR</label>
          <input type="text" style="width:100%" class="form-control" name="kar_tanggalkeluar" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo $data->kar_tanggalkeluar ?>" />
        </div>
        <!-- <div class="form-group">
        <label for="exampleInputEmail1">TANGGAL_KELUAR</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" style="width:100%" class="form-control" id="tanggal" data-date-format="yyyy-mm-dd" name="kar_tanggalkeluar" value="<?php echo $data->kar_tanggalkeluar ?>"/>
        </div> -->
      </div>
        <div class="form-group">
          <label for="exampleInputEmail1">JENIS_KELAMIN</label>
          <?php
          $arrcombo = array(
            'L' => 'Laki-Laki',
            'P' => 'Perempuan'
          );
          echo form_dropdown('kar_jeniskelamin', $arrcombo,$data->kar_jeniskelamin, 'class=form-control');
          ?>
        </div>
        <div class="form-group">
          <label for="">PLANT</label>
          <select name="plant_id" class="form-control select2" required>
            <?php $sql = $this->db->query("SELECT * FROM m_plant WHERE plant_id='$data->plant_id'")->result();
            foreach ($sql as $var) {
              echo "<option value='$var->plant_id'>$var->plant_nama</option>";
            }
            $sql1 = $this->db->query("SELECT * FROM m_plant WHERE plant_id!='$data->plant_id'")->result();
            foreach ($sql1 as $var) {
              echo "<option value='$var->plant_id'>$var->plant_nama</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">TEAM</label>
          <select name="team_id" class="form-control select2" required>
            <?php $sql = $this->db->query("SELECT * FROM m_team WHERE team_id='$data->team_id'")->result();
            foreach ($sql as $var) {
              echo "<option value='$var->team_id'>$var->team_nama</option>";
            }
            $sql1 = $this->db->query("SELECT * FROM m_team WHERE team_id !='$data->team_id'")->result();
            foreach ($sql1 as $var) {
              echo "<option value='$var->team_id'>$var->team_nama</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">HAK_AKSES</label>
          <select name="akses_id" class="form-control select2" required>
            <?php $sql = $this->db->query("SELECT * FROM m_user_akses WHERE akses_id='$data->akses_id'")->result();
            foreach ($sql as $var) {
              echo "<option value='$var->akses_id'>$var->akses_nama</option>";
            }
            $sql2 = $this->db->query("SELECT * FROM m_user_akses WHERE akses_id!='$data->akses_id'")->result();
            foreach ($sql2 as $var) {
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
      <?php endforeach ?>
      <?php echo form_close(); ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->