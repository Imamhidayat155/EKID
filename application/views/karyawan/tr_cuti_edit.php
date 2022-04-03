<!-- Main content -->
<section class="content">
<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Form Edit Data</h1>
    </div>
    <div class="box-body">
        <!-- form start -->

        <?php foreach($editdata as $lihat ): 
        
        echo form_open('karyawan/update_trcuti/' . $lihat->pc_id);?>

        <div class="form-group">
            <label for="exampleInputEmail1">KODE CUTI</label>
            <input type="text" readonly class="form-control" name="pc_kode" value="<?php echo $lihat->pc_kode?>" />
            <input type="hidden" style="width:50%" class="form-control" name="created" data-date-format="yyyy-mm-dd"
                id="tanggal" value="<?php echo date('Y-m-d')?>" readonly />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">NAMA KARYAWAN</label>
            <select name="kar_id" class="form-control" required oninvalid="this.setCustomValidity('pilih data')"
                oninput="setCustomValidity('')">
                <?php
                            $sql=$this->db->query("SELECT * FROM m_karyawan WHERE kar_id='$lihat->kar_id'")->result();
                            foreach($sql as $var){
                            echo "<option value='$var->kar_id'>$var->kar_nik | $var->kar_nama</option>";
                            }
                            ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">GROUP</label>
            <input type="text" class="form-control" name="pc_grup_line" value="<?php echo $lihat->pc_grup_line?>" />
            
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Start Cuti</label>
            <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" style="width:50%" class="form-control" id="startdate" name="pc_tanggalfrom" value="<?php echo $lihat->pc_tanggalfrom?>"/>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Finish Cuti</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" style="width:50%" class="form-control" id="enddate" name="pc_tanggalto" value="<?php echo $lihat->pc_tanggalto?>"
                onchange="calcDiff()" disabled />
            </div>
        </div>

        <div class="form-group">
            <label for="name">Lama Cuti (Hari)</label>
            <input class="form-control" name="pc_lamacuti" id="lama_cuti" value="<?php echo $lihat->pc_lamacuti?>"" readonly required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">ALASAN CUTI</label>
            <input type="text" class="form-control" name="pc_keterangan" value="<?php echo $lihat->pc_keterangan?>" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">STATUS CUTI</label>
            <?php 
            $arrcombo=array(
            'Menunggu Konfirmasi'=>'Menunggu Konfirmasi',
            );
            echo form_dropdown('pc_status',$arrcombo,'','class=form-control readonly');
            ?>
        </div>

        <a href="<?php echo base_url(); ?>karyawan/tr_cuti/" class="btn btn-warning"><i class="fa fa-arrow-left"></i>Batal</a>
        <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
        <?php endforeach ?>

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