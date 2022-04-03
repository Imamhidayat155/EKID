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
                                <th>#</th>
                                <th>Pin</th>
                                <th>Nama Karyawan</th>
                                <th>Section</th>
                                <th>Jam Keluar</th>
                                <th>Jam Kembali</th>
                                <th style="background-color: yellow;">Tanggal Pengajuan</th>
                                <th>Alasan</th>
                                <!-- <th  style="color: blue;">Approved By Leader Up</th> -->
                                <th>AKSI</th>

                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($data as $lihat):
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $lihat->kar_nik?></td>
                                <td><?php echo $lihat->kar_nama?></td>
                                <td><?php echo $lihat->plant_nama?></td>
                                <td><?php echo $lihat->waktu_start?></td>
                                <td><?php echo $lihat->waktu_finish?></td>
                                <td><?php echo date("d-m-Y", strtotime($lihat->created))?></td>
                                <td><?php echo $lihat->tujuan?></td>
                                <!-- <td><?php echo $lihat->actioned_by?></td> -->
                                <td align="center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo base_url(); ?>manager/approve_izin_keluar/<?php echo $lihat->id ?>"
                                            class="btn btn-sm btn-success btn-flat tombol-approve-izin-keluar"><i class="fa fa-check-circle"></i> Approve</a>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="get_id(<?php echo $lihat->id ?>)" id="btn_modal" data-id="<?php echo $lihat->id ?>" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times-circle"></i>
                                        Reject
                                        </button>
                                    </div>
                                </td>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel"><b>Form Reject Izin Keluar</b></h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Alasan</label>
                                                <input type="hidden" id="id_izin_keluar" name="id">
                                                <textarea name="keterangan_ditolak" class="form-control" id="keterangan_ditolak" rows="3" Placeholder="Silahkan tulis alasannya !" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btn_reject" class="btn btn-danger"><i class="fa fa-times-circle"></i> Reject</button>
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Kembali</button>
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
        $('#id_izin_keluar').val(id); //Ambil parameter id saat button reject1 ditekan, lalu set id ke type hidden (#id_izin_keluar)
    }

    $(document).ready(function() {

        $(document).on('click', '#btn_reject', function (){
            var note = $('#keterangan_ditolak').val(); //ambil value dari #keterangan_ditolak  
            var id_izin_keluar = $('#id_izin_keluar').val(); //Ambil value dari #id_izin_keluar
            var param = 'id='+id_izin_keluar+'&note='+note; //parameter yg dikirim ke URL dalam bentuk this->input->post
            $.ajax({
                type	: 'POST',
                url		: "<?php echo base_url()?>manager/reject_izin_keluar/",
                data    : param, //data yang dikirim ke function reject_izin_keluar()
                success :function(data){ //alert(data);
                    alert("Reject Izin Keluar sukses");
                    location.reload("manager/approval_izin_keluar");
                }
            });
        });

    });

</script>
