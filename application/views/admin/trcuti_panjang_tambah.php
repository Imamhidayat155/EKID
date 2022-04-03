<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Form Tambah Data</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php echo form_open('admin/insert_trcuti_panjang');?>

      <div class="form-group">
        <label for="exampleInputEmail1">Kode Cuti</label>
        <input type="text" readonly class="form-control" name="pc_kode" value="<?php echo $auto?>" />
        <input type="hidden" style="width:50%" class="form-control" name="created" data-date-format="yyyy-mm-dd"
          id="tanggal" value="<?php echo date('Y-m-d')?>" readonly />
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail1">Nama Karyawan</label>
        <select name="kar_id" class="form-control select2">
          <option value="">--Pilih--</option>
            <?php
              $id=$this->session->userdata('id');
              $sql=$this->db->query("SELECT * FROM m_karyawan")->result();
              foreach($sql as $var){
              echo "<option value='$var->kar_id'>$var->kar_nama</option>";
              }
              ?>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Start Cuti</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" style="width:50%" class="form-control tanggal" name="pc_tanggalfrom" data-date-format="yyyy-mm-dd"
            value="<?php echo date('Y-m-d')?>" readonly />
        </div>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Finish Cuti</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" style="width:50%" class="form-control tanggal" name="pc_tanggalto" data-date-format="yyyy-mm-dd"
            value="<?php echo date('Y-m-d')?>" readonly />
        </div>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Lama Cuti</label>
        <input type="text" class="form-control" name="pc_lamacuti" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Alasan Cuti</label>
        <input type="text" class="form-control" name="pc_keterangan" placeholder="" />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Status Cuti</label>
        <?php 
              $arrcombo=array(
              'Menunggu Konfirmasi'=>'Menunggu Konfirmasi',
              );
              echo form_dropdown('pc_status',$arrcombo,'','class=form-control readonly');
              ?>
      </div>

      <a href="<?php echo base_url(); ?>admin/tr_cuti" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Batal</a>
      <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
      <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->


 <script>
    /*let keyword = document.getElementById('kar_nama');

    keyword.addEventListener('keyup', function(){
      
      //buat objek ajax
      let xhr = XMLHttpRequest();

      //cek kesiapan ajax
      xhr.onreadystatechange = function() {
        if(xhr.readystate == 4 && xhr.status == 200) {
          console.log('ok');
        }
      }

    });*/
  </script>

</section><!-- /.content -->