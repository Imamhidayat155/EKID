<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Form Tambah Data</h3>
    </div>
    <div class="box-body">
      <!-- form start -->
      <?php echo form_open('karyawan/insert_potong_cuti_karyawan_multiple');?>
      <div class="form-group">
        <label for="exampleInputEmail1">NAMA KARYAWAN</label>
        <select class="form-control select2" multiple="multiple" multiple name="kar_id[]">
                      <?php
                      $plant_id=$this->session->userdata('plant_id'); 
                      $sql=$this->db->query("SELECT * FROM m_karyawan WHERE plant_id=$plant_id")->result();
                      foreach($sql as $col){
                          echo "<option value='$col->kar_id'>$col->kar_nama</option>";
                      }
                      ?>
                    </select>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">JENIS CUTI</label>
        <select name="cuti_kode" class="form-control" required >
          <?php 
          $sql=$this->db->query("SELECT * FROM m_cuti WHERE cuti_id=1 ")->result();
          foreach($sql as $col){
          echo "<option value='$col->cuti_kode'>$col->cuti_namacuti</option>";
          }
          ?>
          </select>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">KODE CUTI  (Muncul setelah pilih karyawan & jenis cuti)</label>
        <input type="text" class="form-control" placeholder="Auto generate system" id="pc_kode" readonly required />
        <input type="hidden" style="width:50%" class="form-control" name="created" data-date-format="yyyy-mm-dd"
          id="tanggal" value="<?php echo date('Y-m-d')?>" readonly />
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
          <input type="text" style="width:50%" class="form-control" id="startdate" name="pc_tanggalfrom" required autocomplete='off'/>
        </div>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">FINISH CUTI</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" style="width:50%" class="form-control" id="enddate" name="pc_tanggalto" onchange="calcDiff()" disabled required autocomplete='off'/>
        </div>
      </div>

      <div class="form-group">
        <label for="name">LAMA CUTI (Hari)</label>
        <input class="form-control" name="pc_lamacuti" id="lama_cuti" readonly required>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">ALASAN CUTI</label>
        <input type="text" class="form-control" name="pc_keterangan" required autocomplete='off'/>
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail1">STATUS CUTI</label>
        <select name="pc_status" class="form-control" required readonly autocomplete='off'>
          <?php 
          $sql=$this->db->query("SELECT * FROM m_status WHERE status_id=2 ")->result();
          foreach($sql as $col){
          echo "<option value='$col->status_kode'>$col->status_nama</option>";
          }
          ?>
          </select>
      </div>

      <a href="<?php echo base_url(); ?>karyawan" class="btn btn-warning"><i class="fa fa-arrow-left"></i> BATAL</a>
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
  
function getCutiCode()
{
  document.getElementById('pc_kode').placeholder='Loading...';
  
	var kar_id=document.getElementById('kar_id').value; //alert(a)
	var cuti_kode=document.getElementById('cuti_kode').value; //alert(a)
	$.ajax({
		type	:"POST",
		url		:"<?php echo base_url()?>karyawan/getCutiCode/"+kar_id+"/"+cuti_kode,
		success :function(data){ //alert(data)
				document.getElementById('pc_kode').value=data;
			}
	});
}
</script>

</section><!-- /.content -->