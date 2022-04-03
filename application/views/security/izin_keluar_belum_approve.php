<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">                        
                    </div>
                </div><!-- /.box-header -->
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('notif');?>"></div>
                <div class="col-md-12">
								<fieldset class="scheduler-border">
									<legend class="scheduler-border">Filter Group</legend>						
									<form id="form_filter" method="post" action="<?php echo base_url('security/filter_report_izin_keluar_belum_approve'); ?>">
										<div class="row" align="center">
											<div class="col-md-3 col-xs-12">
												<label for="">FROM DATE : </label>
												<input type="text" class="form-control" style="width:150px" name="fromdate" id="tanggal" value="<?php if(isset($fromdate)){ echo $fromdate;}else{ echo date('Y-m-d');}?>" required autocomplete="off" />
											</div>
											<div class="col-md-3 col-xs-12">
												<label for="">TO DATE : </label>
												<input type="text" class="form-control" style="width:150px" name="todate" id="tanggal2" value="<?php if(isset($todate)){ echo $todate;}else{ echo date('Y-m-d');}?>" required autocomplete="off" />
											</div>
											<div class="col-md-3 col-xs-12" style="padding-right: 0px;padding-left: 0px;">
												<button type="submit" class="btn btn-md btn-primary" ><i class="fa fa-search"></i> Filter</button>
												<button type="button" onclick="exportbyfilter()" class="btn btn-md btn-success"> <i class="fa fa-file-excel-o"></i> Export by Filter</button> 	
											</div>
										</div>
									</form>
								</fieldset>
                                <hr>
							</div>
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PIN</th>
                                <th>Nama</th>
                                <th>Section</th>
                                <th>Tanggal</th>
                                <th>Jam Keluar</th>
                                <th>Jam Kembali</th>
                                <th>Alasan</th>
                                <th>Status</th>
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
                                <td><?php echo $lihat->dep_nama?></td>
                                <td><?php echo date("d-m-Y", strtotime($lihat->tanggal))?></td>
                                <td><?php echo $lihat->waktu_start?></td>
                                <td><?php echo $lihat->waktu_finish?></td>
                                <td><?php echo $lihat->keperluan?></td>
                                <td><span class="label label-warning"><?php if ($lihat->status == 1){echo "Belum Approved";}  ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <!-- <tbody>
                            
                        </tbody> -->
                    </table>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>

<script src ="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src ="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<link   href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"type="text/css"/>

<script>
$(function(){
                $(".datepicker").datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: false,
                });
                $("#tgl_mulai").on('changeDate', function(selected) {
                    var startDate = new Date(selected.date.valueOf());
                    $("#tgl_akhir").datepicker('setStartDate', startDate);
                    if($("#tgl_mulai").val() > $("#tgl_akhir").val()){
                        $("#tgl_akhir").val($("#tgl_mulai").val());
                    }
                });
            });

$(function(){
		$('#tanggal').datepicker({
			autoclose:true,
			format:'yyyy-mm-dd'
		});
		$('#tanggal2').datepicker({
			autoclose:true,
			format:'yyyy-mm-dd'
		});
    });
    
function exportbyfilter(){
var a = document.getElementById('tanggal').value; //alert(a)
var b = document.getElementById('tanggal2').value; //alert(b)
window.open('<?php echo base_url()?>karyawan/export_cuti_belum_approve_sh/'+a+'/'+b);
}
</script>

</section><!-- /.content -->