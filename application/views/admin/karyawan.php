  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <a href="<?php echo base_url(); ?>admin/tambah_karyawan" class="btn btn-md btn-primary btn-flat"><i class="fa fa-plus"></i> TAMBAH DATA</a>

              <a href="<?php echo base_url('admin/upload'); ?>"  class="btn btn-md btn-warning btn-flat"><i class="fa fa-upload"></i> UPLOAD</a>

              <a href="#" onclick="window.open('<?php echo base_url('upload_karyawan/UploadKaryawan.xlsx') ?>')" class="btn  btn-md btn-success btn-flat" style="background: ; color: ;"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> DOWNLOAD_TEMPLATE</a>

              <a href="<?php echo base_url(); ?>admin/aktif_all_karyawan" onclick="javascript: return confirm('Yakin Mengaktifkan semua Karyawan ?')" class="btn btn-md btn-info btn-flat"> AKTIF ALL</a>

              <a href="<?php echo base_url(); ?>admin/nonaktif_all_karyawan" onclick="javascript: return confirm('Yakin Menonaktifkan semua Karyawan ?')" class="btn btn-md btn-info btn-flat"> NONAKTIF ALL</a>

              <a href="<?php echo base_url(); ?>laporan/export_data_karyawan" class="btn btn-md btn-primary btn-flat"><i class="fa fa-download"></i> EXPORT DATA KARYAWAN</a>
            </h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">

            <table id="example" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>PIN_KARYAWAN</th>
                  <th>NAMA_KARYAWAN</th>
                  <th>JABATAN</th>
                  <th>SECTION</th>
                  <th>EMAIL</th>
                  <th>TANGGAL_MASUK</th>
                  <th>JENIS_KELAMIN</th>
                  <th>PLANT</th>
                  <th>AKSES_LEVEL</th>
                  <th>STATUS_AKTIF</th>
                  <th>AKTIVASI</th>
                  <th>______AKSI______</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($data as $lihat) :
                ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $lihat->kar_nik ?></td>
                    <td><?php echo $lihat->kar_nama ?></td>
                    <td><?php echo $lihat->jab_nama ?></td>
                    <td><?php echo $lihat->dep_nama ?></td>
                    <td><?php echo $lihat->kar_email ?></td>
                    <td><?php echo $lihat->kar_tanggalmasuk ?></td>
                    <td><?php echo $lihat->kar_jeniskelamin ?></td>
                    <td><?php echo $lihat->plant_nama ?></td>
                    <td><?php echo $lihat->akses_nama ?></td>
                    <td><?php echo $lihat->is_active ?></td>
                    <td align="center">
                      <div class="btn-group" role="group">
                        <?php if ($lihat->is_active == 1) { ?>
                          <a href="<?php echo base_url(); ?>admin/nonaktif_karyawan/<?php echo $lihat->kar_id ?>" onclick="javascript: return confirm('Yakin Mengaktifkan Karyawan <?php echo $lihat->kar_nama ?>?')" class="btn btn-sm btn-info btn-flat">Non Aktifkan</a>
                        <?php } else { ?>
                          <a href="<?php echo base_url(); ?>admin/aktif_karyawan/<?php echo $lihat->kar_id ?>" onclick="javascript: return confirm('Yakin Mengaktifkan Karyawan <?php echo $lihat->kar_nama ?>?')" class="btn btn-sm btn-info btn-flat">Aktifkan</a>
                        <?php } ?>
                      </div>
                    </td>
                    <td align="center">
                      <div class="btn-group" role="group">
                        <a href="<?php echo base_url(); ?>admin/edit_karyawan/<?php echo $lihat->kar_id ?>" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="<?php echo base_url(); ?>admin/hapus_karyawan/<?php echo $lihat->kar_id ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i>HAPUS</a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

          </div><!-- /.box-body -->
        </div>
      </div>
    </div>


  </section><!-- /.content -->