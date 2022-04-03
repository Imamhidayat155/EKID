<!-- Main content -->
<section class="content">
<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Form Edit Data</h1>
    </div>
    <div class="box-body">
        <!-- form start -->

        <?php foreach($data as $lihat ): 
        
        echo form_open('admin/update_trcuti_panjang/' . $lihat->pc_panjang_id);?>

        <div class="form-group">
            <label for="exampleInputEmail1">KODE CUTI</label>
            <input type="text" readonly class="form-control" name="pc_kode" value="<?php echo $lihat->pc_panjang_kode?>" />
            <input type="hidden" style="width:50%" class="form-control" name="created" data-date-format="yyyy-mm-dd"
                id="tanggal" value="<?php echo date('Y-m-d')?>" readonly />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">NAMA KARYAWAN</label>
            <input type="text" readonly class="form-control" name="kar_nama" value="<?php echo $lihat->kar_nama?>" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">START CUTI</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" style="width:50%" class="form-control tanggal" name="pc_panjang_tanggalfrom"
                    data-date-format="yyyy-mm-dd" value="<?php echo $lihat->pc_panjang_tanggalfrom?>" readonly  />
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">FINISH CUTI</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" style="width:50%" class="form-control tanggal" name="pc_panjang_tanggalto"
                    data-date-format="yyyy-mm-dd" value="<?php echo $lihat->pc_panjang_tanggalto?>" readonly />
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">LAMA CUTI</label>
            <input type="text" class="form-control" name="pc_panjang_lamacuti" value="<?php echo $lihat->pc_panjang_lamacuti?>" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">ALASAN CUTI</label>
            <input type="text" class="form-control" name="pc_panjang_keterangan" value="<?php echo $lihat->pc_panjang_keterangan?>" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">STATUS CUTI</label>
            <?php 
            $arrcombo=array(
            'Menunggu Konfirmasi'=>'Menunggu Konfirmasi',
            );
            echo form_dropdown('pc_panjang_status',$arrcombo,'','class=form-control readonly');
            ?>
        </div>

        <a href="<?php echo base_url(); ?>admin/tr_cuti_panjang" class="btn btn-warning"><i class="fa fa-arrow-left"></i>
            Batal</a>
        <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
        <?php endforeach ?>

        <?php echo form_close(); ?>

    </div><!-- /.box-body -->
</div><!-- /.box -->
</section><!-- /.content -->