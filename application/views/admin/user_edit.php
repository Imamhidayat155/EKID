          <!-- Main content -->
          <section class="content">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"> FORM EDIT</h3>
              </div>
              <div class="box-body">
                <!-- form start -->
                <?php
                foreach ($editdata as $data) :
                  echo form_open('admin/update_user/' . $data->kar_id); ?>

                  <div class="form-group">
                    <label for="exampleInputEmail1">NAMA_USER</label>
                    <input type="text" class="form-control" name="kar_nama" value="<?php echo $data->kar_nama ?>" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">PIN_USER</label>
                    <input type="text" class="form-control" name="kar_nik" value="<?php echo $data->kar_nik ?>" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">USERNAME</label>
                    <input type="text" class="form-control" name="kar_username" value="<?php echo $data->kar_username ?>" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">PASSWORD</label>
                    <input type="text" class="form-control" name="kar_password" value="<?php echo $data->kar_password ?>" />
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
                      $sql2 = $this->db->query("SELECT * FROM m_departement WHERE dep_id!='$data->dep_id'")->result();
                      foreach ($sql2 as $var) {
                        echo "<option value='$var->dep_id'>$var->dep_nama</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">EMAIL</label>
                    <input type="text" class="form-control" name="kar_email" placeholder="" value="<?php echo $data->kar_email ?>" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">TANGGAL_MASUK</label>
                    <input type="text" style="width:100%" class="form-control" name="kar_tanggalmasuk" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo $data->kar_tanggalmasuk ?>" />
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
                    <select name="plant_id" class="form-control select2">
                      <?php $sql = $this->db->query("SELECT * FROM m_plant WHERE plant_id='$data->plant_id'")->result();
                      foreach ($sql as $var) {
                        echo "<option value='$var->plant_id'>$var->plant_nama</option>";
                      }
                      $sql2 = $this->db->query("SELECT * FROM m_plant WHERE plant_id!='$data->plant_id'")->result();
                      foreach ($sql2 as $var) {
                        echo "<option value='$var->plant_id'>$var->plant_nama</option>";
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
                  <a href="<?php echo base_url(); ?>admin/user" class="btn btn-warning"><i class="fa fa-arrow-left"></i>BATAL</a>
                  <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>SIMPAN</button>
                <?php endforeach ?>
                <?php echo form_close(); ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </section><!-- /.content -->