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
            <label for="exampleInputEmail1">NAMA KARYAWAN</label>
                <select class="form-control" name="kar_nik" readonly>
                    <?php
                        $kar_nik=$this->session->userdata('nik');
                        $sql=$this->db->query("SELECT * FROM m_karyawan WHERE kar_nik=$kar_nik")->result();
                        foreach($sql as $var){
                        echo "<option value='$var->kar_nik'>$var->kar_nik | $var->kar_nama</option>";
                        }
                        ?>
                </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">DEPARTMENT</label>
            <select class="form-control" name="dep_id" disabled>
                <?php
                $dep_id=$this->session->userdata('dep_id');
                $sql=$this->db->query("SELECT * FROM m_departement WHERE dep_id=$dep_id")->result();
                foreach($sql as $var){
                echo "<option value='$var->dep_id'>$var->dep_nama</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">TANGGAL</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" style="width:50%" class="form-control" id="tanggal_keluar"  name="tanggal"  value="<?php echo $lihat->tanggal?>" />
            </div>
        </div>

        <div class="bootstrap-timepicker">
            <div class="form-group">
                <label>WAKTU START:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" style="width:50%" class="form-control timepicker" name="waktu_start" value="<?php echo $lihat->waktu_start?>"required>            
                </div>
            </div>
        </div>

        <div class="bootstrap-timepicker">
            <div class="form-group">
                <label>WAKTU FINISH:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" style="width:50%" class="form-control timepicker" name="waktu_finish" value="<?php echo $lihat->waktu_finish?>" required>            
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">KEPERLUAN</label>
            <?php 
                $arrcombo=array(
                'pribadi'=>'Pribadi'
                );
                echo form_dropdown('keperluan',$arrcombo,'','class=form-control readonly');
                ?>
        </div>
        
        <div class="form-group">
            <label for="exampleInputEmail1">ALASAN</label>
            <input type="text" class="form-control" name="tujuan" autocomplete='off' value="<?php echo $lihat->tujuan?>" required/>
        </div>

        <a href="<?php echo base_url(); ?>karyawan/status_izin_keluar" class="btn btn-warning"><i class="fa fa-arrow-left"></i> BATAL</a>
        <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> SIMPAN</button>
        <?php endforeach ?>
        <?php echo form_close(); ?>

    </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- jQuery 2.2.3 -->
<!-- <script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script> -->

<script src ="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src ="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<link   href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"type="text/css"/>


</section><!-- /.content -->