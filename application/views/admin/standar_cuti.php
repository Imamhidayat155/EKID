  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <a href="<?php echo base_url(); ?>admin/tambah_standar_cuti" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-plus"></i> TAMBAH DATA</a>
            </h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">

            <table id="example1" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>KODE_CUTI</th>
                  <th>NAMA_CUTI</th>
                  <th>JUMLAH_CUTI</th>
                  <th align="center">______AKSI______</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($data as $lihat) :
                ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $lihat->cuti_kode ?></td>
                    <td><?php echo $lihat->cuti_namacuti ?></td>
                    <td><?php echo $lihat->cuti_jumlahcuti ?></td>

                    <td align="center">
                      <div class="btn-group" role="group">
                        <a href="<?php echo base_url(); ?>admin/edit_standar_cuti/<?php echo $lihat->har_cuti_id ?>" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="<?php echo base_url(); ?>admin/hapus_standar_cuti/<?php echo $lihat->har_cuti_id ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i>HAPUS</a>
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