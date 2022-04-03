<!-- Main content -->
<section class="content">

<div class="row">
    <div class="col-xs-12">
    <div class="box"><br>
    <div class="box-header">
        <a href="<?php echo base_url('admin/upload_jatah_cuti'); ?>"  class="btn btn-md btn-warning btn-flat"><i class="fa fa-upload"></i> UPLOAD</a>

        <a href="#" onclick="window.open('<?php echo base_url('upload_karyawan/UploadJatahCuti.xlsx') ?>')" class="btn  btn-md btn-success btn-flat" style="background: ; color: ;"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> DOWNLOAD_TEMPLATE</a>
    </div>
    <form method="post" action="<?php echo base_url('admin/simpan_cuti_tahunan_multiple')?>">
        <div class="box-body table-responsive">
        <h4><b>Silahkan Isi jumlah cuti yang akan ditambahkan (Per Karyawan)</b></h4>
        <table id="example1" class="table table-bordered table-hover dataTable"> <br>
            <thead>
            <tr>
                <th>NO</th>
                <th>PIN_KARYAWAN</th>
                <th>NAMA_KARYAWAN</th>
                <th>SECTION</th>
                <th>TANGGAL_MASUK</th>
                <th>JUMLAH_TAMBAH</th>
                <th>TAHUN_PERIODE</th>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $today = date('Y-m-d', strtotime('2020-01-20'));
            // $today = date('Y-m-d');
            foreach ($data as $lihat) :
                $tgl_masuk = date('Y-m-d', strtotime($lihat->kar_tanggalmasuk));
                $jumlah = $this->model_admin->dateDifference($tgl_masuk, $today, '%y%m');

                if($jumlah > 12) $jumlah = 12; //nilai maksimal jatah cuti
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $lihat->kar_nik ?></td>
                    <td><?php echo $lihat->kar_nama ?></td>
                    <td><?php echo $lihat->dep_nama ?></td>
                    <td><?php echo $lihat->kar_tanggalmasuk ?></td>
                    <td>
                        <input type="number" name="jumlah[]" value="<?php echo intval($jumlah)?>">
                        <input type="hidden" name="cuti_id" value="1">
                        <input type="hidden" name="kar_id[]" value="<?php echo $lihat->kar_id ?>">
                        <input type="hidden" name="tahun" value="<?php echo date('Y') ?>">
                    </td>
                    <td><?php echo date('Y') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="col-md-12" align="center">
            <button type="submit" name="" class="btn btn-success" onclick="return confirm('Yakin menyimpan data ini?')"><i class="fa fa-save"></i>SIMPAN</button>
        </div>
    </form>
    </div><!-- /.box-body -->
    </div>
    </div>
</div>


</section><!-- /.content -->