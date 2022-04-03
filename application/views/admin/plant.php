  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <a href="<?php echo base_url(); ?>admin/tambah_plant" class="btn btn-md btn-primary btn-flat"><i class="fa fa-plus"></i> TAMBAH DATA</a>
              <a href="#" onclick="window.open('<?php echo base_url(); ?>upload_karyawan/importPlant.php','FormUpload','width=500,height=300')" class="btn btn-md btn-warning btn-flat"><i class="fa fa-upload"></i> UPLOAD</a>
              <a href="#" onclick="window.open('<?php echo base_url('upload_karyawan/UploadPlant.xls') ?>')" class="btn  btn-md btn-success btn-flat" style="background: ; color: ;"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> DOWNLOAD_TEMPLATE</a>
              <a href="<?php echo base_url(); ?>laporan/export_data_plant" class="btn btn-md btn-primary btn-flat"><i class="fa fa-download"></i> EXPORT DATA PLANT</a>
            </h3>
            
            <div class="box-tools">
              <!--
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                    -->
            </div>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">

            <table id="example1" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>KODE</th>
                  <th>PLANT</th>
                  <th align="center">______AKSI______</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($data as $lihat) :
                ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $lihat->plant_kode ?></td>
                    <td><?php echo $lihat->plant_nama ?></td>

                    <td align="center">
                      <div class="btn-group" role="group">
                        <a href="<?php echo base_url(); ?>admin/edit_plant/<?php echo $lihat->plant_id ?>" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="<?php echo base_url(); ?>admin/hapus_plant/<?php echo $lihat->plant_id ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i>HAPUS</a>
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