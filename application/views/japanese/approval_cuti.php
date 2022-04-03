<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                
                    <table id="example" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KODE CUTI</th>
                                <th>NAMA KARYAWAN</th>
                                <th>MULAI CUTI</th>
                                <th>SELESAI CUTI</th>
                                <th>LAMA CUTI</th>
                                <th>JENIS CUTI</th>
                                <th>SISA CUTI</th>
                                <th>ALASAN CUTI</th>
                                <th>AKSI</th>

                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($data as $lihat):
                                    $row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                                    $row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $lihat->kar_id))->row();
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->pc_kode?></td>
                                <td><?php echo $lihat->kar_nama?></td>
                                <td><?php echo $lihat->pc_tanggalfrom?></td>
                                <td><?php echo $lihat->pc_tanggalto?></td>
                                <td><?php echo $lihat->pc_lamacuti?> Hari</td>
                                <td><?php echo $lihat->cuti_kode?></td>
                                <td><?php echo $row_jatah_CT->total - $row_potong_CT->total?></td>
                                <td><?php echo $lihat->pc_keterangan?></td>
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo base_url(); ?>japanese/approve_trcuti/<?php echo $lihat->pc_id ?>"
                                            class="btn btn-sm btn-success btn-flat tombol-approve"><i class="fa fa-check-circle"></i> Approve</a>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="get_id(<?php echo $lihat->pc_id ?>)" id="btn_modal" data-id="<?php echo $lihat->pc_id ?>" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times-circle"></i>
                                        Reject
                                        </button>
                                    </div>
                                </td>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel"><b>Form Reject Cuti</b></h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Alasan</label>
                                                <input type="hidden" id="pc_id" name="pc_id">
                                                <textarea name="pc_keterangan_ditolak" class="form-control" id="pc_keterangan_ditolak" rows="3" Placeholder="Silahkan tulis alasannya !!!" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Kembali</button>
                                            <button type="button" id="btn_reject" class="btn btn-danger"><i class="fa fa-times-circle"></i> Reject</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>

</section><!-- /.content -->
<!-- jQuery 2.2.3 -->
<script src="<?php echo $this->config->item('link_url') ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

<script>

    function get_id(id){
        $('#pc_id').val(id); //Ambil parameter pc_id saat button reject1 ditekan, lalu set pc_id ke textarea (#pc_id)
    }

    $(document).ready(function() {

        $(document).on('click', '#btn_reject', function (){
            // alert(id)
            var note = $('#pc_keterangan_ditolak').val(); //ambil value dari #pc_keterangan_ditolak  
            var pc_id = $('#pc_id').val(); //Ambil value dari #pc_id
            var param = 'pc_id='+pc_id+'&note='+note; //parameter yg dikirim ke URL dalam bentuk this->input->post
            $.ajax({
                type	: 'POST',
                url		: "<?php echo base_url()?>leader_up/reject_trcuti/",
                data    : param, //data yang dikirim ke function reject_trcuti()
                success :function(data){ //alert(data)
                    alert("Reject Cuti sukses");
                    location.reload("japanese/approval");
                }
            });
        });

    });

</script>
