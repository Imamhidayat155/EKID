<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Form Tambah Data</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php echo form_open('clerk/insert_trcuti');?>

      <div class="form-group">
        <label for="exampleInputEmail1">KODE CUTI</label>
        <input type="text" readonly class="form-control" name="pc_kode" value="<?php echo $auto?>" />
        <input type="hidden" style="width:50%" class="form-control" name="created" data-date-format="yyyy-mm-dd"
          id="tanggal" value="<?php echo date('Y-m-d')?>" readonly />
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail1">NAMA KARYAWAN</label>
        <select name="kar_id" class="form-control select2">
            <?php
              $id=$this->session->userdata('id');
              $sql=$this->db->query("SELECT * FROM m_karyawan WHERE kar_id=$id")->result();
              foreach($sql as $var){
              echo "<option value='$var->kar_id'>$var->kar_nama</option>";
              }
              ?>
        </select>
      </div>

        <div class="form-group">
          <label for="exampleInputEmail1">JENIS CUTI</label>
          <select name="cuti_kode" class="form-control">
              <?php
                $id=$this->session->userdata('id');
                $sql=$this->db->query("SELECT * FROM m_cuti")->result();
                foreach($sql as $var){
                echo "<option value='$var->cuti_kode'>$var->cuti_namacuti</option>";
                }
                ?>
          </select>
        </div>
      <div class="form-group">
      <input type="hidden" class="form-control" name="akses_id" value="<?php echo $this->session->userdata('akses') ?>" />
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">START CUTI</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" style="width:50%" class="form-control" id="startdate" name="pc_tanggalfrom"/>
        </div>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">FINISH CUTI</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" style="width:50%" class="form-control" id="enddate" name="pc_tanggalto" onchange="calcDiff()" disabled />
        </div>
      </div>

      <div class="form-group">
        <label for="name">LAMA CUTI (Hari)</label>
        <input class="form-control" name="pc_lamacuti" id="lama_cuti" readonly required>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">ALASAN CUTI</label>
        <input type="text" class="form-control" name="pc_keterangan" placeholder="" />
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail1">STATUS CUTI</label>
        <?php 
              $arrcombo=array(
              '2'=>'Menunggu Konfirmasi',
              );
              echo form_dropdown('pc_status',$arrcombo,'','class=form-control readonly');
              ?>
      </div>

      <a href="<?php echo base_url(); ?>admin/tr_cuti" class="btn btn-warning"><i class="fa fa-arrow-left"></i> BATAL</a>
      <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> SIMPAN</button>
      <?php echo form_close(); ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->


<!-- jQuery 2.2.3 -->
<!-- <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script> -->

<script src ="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src ="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<link   href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"type="text/css"/>

<script>

$(document).ready(function() {

    $("#startdate").datepicker({
        format: "yyyy-mm-dd",
        language: "id",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
    }).on('changeDate', function (selected) {
        $('#enddate').attr('disabled', false); //_____DISABLE #enddate SEBELUM #startdate dipilih
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
    });

    $("#enddate").datepicker({
        format: "yyyy-mm-dd",
        language: "id",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
    }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#startdate').datepicker('setEndDate', maxDate);
    });


});

function calcDiff(){
    var date1 = $('#startdate').datepicker("getDate");
    var date2 = $('#enddate').datepicker("getDate");
    var diff = date2 - date1;
    
    $("#lama_cuti").val(Math.floor(diff/(86400000)) + 1);
    
}
  
</script>

</section><!-- /.content -->