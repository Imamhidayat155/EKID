        <!-- Min content -->
		<section class="content">
		<div class="box box-info">
			<div class="box-body table-responsive">
			<!-- form start -->
			<div class="col-md-12">
				
			<form method="post" action="<?php echo base_url()?>karyawan/edit_karyawan">
				<table class="table table-bordered table-hover" width="100%">
				<tr>
					<td align="left">NIK | NAMA</td>
					<td>:</td>
					<td>
						<select name="" id="kar_id" onchange="getDataKaryawan()" class="form-control">
							<?php 
							$row        = $this->db->query("select * from m_karyawan where kar_nik='$nik'")->row();
							$section    = $row  ->   kar_section;
                            $position   = $row  ->   kar_posisi;
                            $no_telp    = $row  ->   kar_notelp;
							echo "<option value='$row->kar_id'>$row->kar_nik | $row->kar_nama</option>";
							?>
						</select>
					</td>
				</tr>				
				<tr>
					<td align="left">SECTION</td>
					<td>:</td>
					<td>
						<input type="text" readonly class="form-control" name="section" id="kar_section" onclick="getDataKaryawan()" value="<?php echo $section?>"/>
					</td>
				</tr>
				<tr>
					<td align="left">POSISI</td>
					<td>:</td>
					<td>
						<input type="text" readonly class="form-control" name="position" id="kar_posisi" value="<?php echo $position?>"/>
					</td>
				</tr>
                <tr>
					<td align="left">NO TELP</td>
					<td>:</td>
					<td>
						<input type="text" readonly class="form-control" name="no_telp" id="kar_notelp" value="<?php echo $no_telp?>"/>
					</td>
				</tr>
				</table>

                <a href="<?php echo base_url(); ?>karyawan/tambah_transaksi" class="btn btn-warning"><i class="fa fa-arrow-left"></i> BATAL</a>
                <button type="submit" name="" class="btn btn-success"><i class="fa fa-save"></i>  ADD PHONE NUMBER</button>
			</form>

			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</section><!-- /.content -->
	
	
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
	
<script>
    function getDataKaryawan()
    { 
    var x=document.getElementById("kar_id").value;
    $.ajax({
        type	:"POST",
        url		:"<?php echo base_url()?>admin/getDataKaryawan/"+x,
        success	: function(data){ 
                document.getElementById("kar_section").value=data.split("|")[0];
                document.getElementById("kar_posisi").value=data.split("|")[1];
                document.getElementById("karyawan_id").value=x;
            }
        });											
    }
</script>