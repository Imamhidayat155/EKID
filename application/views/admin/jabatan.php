  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <a href="<?php echo base_url(); ?>admin/tambah_jabatan" class="btn btn-md btn-success btn-flat"><i class="fa fa-plus"></i> TAMBAH DATA</a>
            </h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">

            <table id="example1" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>KODE</th>
                  <th>JABATAN</th>
                  <th align="center">______AKSI______</th>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($data as $lihat) :
                ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $lihat->jab_kode ?></td>
                    <td><?php echo $lihat->jab_nama ?></td>

                    <td align="center">
                      <div class="btn-group" role="group">
                        <a href="<?php echo base_url(); ?>admin/edit_jabatan/<?php echo $lihat->jab_id ?>" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="<?php echo base_url(); ?>admin/hapus_jabatan/<?php echo $lihat->jab_id ?>" onclick="javascript: return confirm('Anda yakin ingin menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i>HAPUS</a>
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