		<!-- Main content -->
		<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
			<div class="alert alert-warning alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-text="true">&times;</button>
			<h3 class="box-title">*JUMLAH POIN TERPAKAI = <?php echo $jmlpoint?></h3><br>
			<?php $selisih = $jmlpoint-20;?>
			<h3 class="box-title">*SISA POINT  = <?php if($jmlpoint > 20) echo "+".$selisih; else echo $selisih;?></h3>
			</div>
			</div>
			<div class="box-body table-responsive">
			<?php 
				if($reqhead->jml >0){
					echo "Tidak Bisa Melakukan Transaksi";
				}else{
			?>
			<!-- form start -->
			<div class="col-md-12">
				
			<form method="post" action="<?php echo base_url()?>karyawan/insert_transaksi">
				<table class="table table-bordered table-hover" width="100%">
				<tr>
					<td align="left">NIK_NAMA</td>
					<td>:</td>
					<td>
						<select name="" id="kar_id" onchange="getDataKaryawan()" class="form-control">
							<?php 
							$row=$this->db->query("select * from m_karyawan where kar_nik='$nik'")->row();
							$section = $row->kar_section;
							$position = $row->kar_posisi;
							echo "<option value='$row->kar_id'>$row->kar_nik | $row->kar_nama</option>";
							?>
						</select>
					</td>
					<td align="left">TAMBAH ITEM</td>
					<td>:</td>
					<td>
						<select name="item_id" id="field_item" class="form-control" onchange="getSelect_Multi();">
							<option value="">--PILIH BARANG--</option>
							<?php $sql=$this->db->query("select * from m_item")->result();
							foreach($sql as $var){
								echo "<option value='$var->item_id'>$var->item_kode | $var->item_nama</option>";
							}
							?>
						</select>
					<input type="hidden" class="form-control" name="reqhed_code" value="<?php echo $autonumb?>" />
					</td>
				</tr>
				
				<tr>
					<td align="left">SECTION</td>
					<td>:</td>
					<td>
						<input type="text" readonly class="form-control" name="section" id="kar_section" onclick="getDataKaryawan()" value="<?php echo $section?>"/>
					</td>
					<td align="left">WARNA</td>
					<td>:</td>
					<td>
						<select name="warna_id" id="field_warna" required class="form-control">
							<!-- <option value="">--PILIH WARNA--</option> -->
							<?php 
							// $sql=$this->db->query("select * from m_warna")->result();
							// foreach($sql as $var){
							// 	echo "<option value='$var->warna_id'>$var->warna_nama</option>";
							// }
							?>
						</select>
					<input type="hidden" class="form-control" name="reqhed_code" value="<?php echo $autonumb?>" />
					</td>
				</tr>
				<tr>
					<td align="left">POSISI</td>
					<td>:</td>
					<td>
						<input type="text" readonly class="form-control" name="position" id="kar_posisi" value="<?php echo $position?>"/>
					</td>
					<td align="left">SIZE</td>
					<td>:</td>
					<td>
						<select name="size_id" id="field_size" required class="form-control">
							<!-- <option value="">--PILIH SIZE--</option> -->
							<?php 
							// $sql=$this->db->query("select * from m_size")->result();
							// foreach($sql as $var){
							// 	echo "<option value='$var->size_id'>$var->size_no</option>";
							// }
							?>
						</select>						
					</td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
					<td align="left">JUMLAH</td>
					<td>:</td>
					<td style="width:20%"><input type="text" class="form-control" name="req_qty" required value=""  /></td>
					<td><button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-plus"></i>Tambah ke Keranjang</button></td>
				</tr>
				</table>
				</form>
			<form method="post" action="<?php echo base_url()?>karyawan/insert_transaksi" onsubmit="return confirm('Yakin akan menyelesaikan transaksi ini dengan Jumlah Point = <?php echo $jmlpoint?>')">
			<input type="hidden" class="form-control" name="reqhed_code" value="<?php echo $autonumb?>" />
			<input type="hidden" class="form-control" name="kar_id" value="<?php echo $this->session->userdata('id')?>" />
			<input type="hidden" style="width:100%" class="form-control" name="reqhed_tanggal" data-date-format="yyyy-mm-dd" id="tanggal" value="<?php echo date('Y-m-d')?>" />
				<table id="" class="table table-bordered table-hover dataTable">
				<thead>
					<tr>
					<th>NO</th>
					<th>KODE</th>
					<th>ITEM</th>
					<th>POINT(A)</th>
					<th>WARNA</th>
					<th>QTY(B)</th>
					<th>TOTAL POINT(C)</th>
					<th>SIZE</th>
					<th>AKSI</th>
				</thead>
				<tbody>
					<?php  
					$no = 1; $totalpoint=0;;
											$data	= $this->db->query("select a.*,b.*,c.*,d.*
											from req_detail a
											inner join m_item b on a.item_id=b.item_id
											left join m_size c on a.size_id=c.size_id
											left join m_warna d on a.warna_id=d.warna_id
											where reqhed_code='$autonumb'
											")->result_object();
																	foreach ($data as $lihat){
											$totalpoint+=$lihat->req_qty*$lihat->item_point;
					?>
					<tr>
					<td><?php echo $no++ ?></td>
											<td><?php echo ucwords($lihat->reqhed_code)?></td> 
											<td><?php echo ucwords($lihat->item_nama)?></td>
											<td><?php echo ucwords($lihat->item_point)?></td>
											<td><?php echo ucwords($lihat->warna_nama)?></td>
											<td><?php echo number_format($lihat->req_qty)?></td>
											<td><?php echo number_format($lihat->req_qty*$lihat->item_point)?></td>
											<td><?php echo ucwords($lihat->size_no)?></td>
					<td align="center">
						<div class="btn-group" role="group">
						<a href="<?php echo base_url(); ?>karyawan/hapus_transaksi/<?php echo $lihat->reqdet_id ?>" onclick="javascript: return confirm('Anda yakin akan menghapus data ini ?')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</a>
						</div>
					</td>                  		
					</tr>
					<?php } ?>
					<tr>     		
						<th colspan="6">TOTAL</th>
						<th><?php echo $totalpoint?><input type="hidden" class="form-control" name="reqhed_totalpoint" value="<?php echo $totalpoint?>" /></th>
						
					</tr>
				</tbody>
				</table>
			<hr/>				  
			</div><!-- /.col-md-12 -->
			<?php
			if($jmlpoint <= 20){
			?>
			<div class="col-md-12" align="center">
				<button type="submit" name="selesai" class="btn btn-success"><i class="fa fa-save"></i> Pesan</button>
			</form>
			</div>
			<?php }else{ ?>
				<p style="color: red; text-align: center;">*Tombol PESAN akan muncul jika Pesanan Tidak Melebihi = 20 Point</p>
			<?php
			} ?>
			<?php } ?>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</section><!-- /.content -->
	
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel1">Warning</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<h5 class="modal-title" id="exampleModalLabel1">Anda memesan lebih dari 20 Point, silahkan hapus beberapa Item untuk mengurangi Point</h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<script src="<?php echo $this->config->item('link_url')?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
	
<script>
<?php 
	if($totalpoint > 20){
		?>
		$(window).on('load',function(){
			$('#exampleModal').modal('show');
		});
<?php
	}
?>
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

$(document).ready(function() {
	getSelect_Item(); //console.log(role);
});
function getSelect_Multi(){
	getSelect_Warna();
	getSelect_Size();
}
function getSelect_Item() {
	var param = null;
	$.ajax( {
		type : "POST" ,
		url : "<?php echo base_url(); ?>select/getSelect_Item" ,
		data : param ,
		cache : false ,
		success : function ( data ) {
			var obj = $.parseJSON( data );

			var str = '';
			str += '<option value="" >--PILIH ITEM--</option>';
			$.each( obj[ 'data' ] , function ( i , val ) {
				str += '<option value="' + val.item_id + '">' + val.item_nama + ', p=' + val.item_point + '</option>';
			} );

			$( '#field_item' ).html( str );

		}
	} );
}
function getSelect_Warna() {

	var param = $('#field_item').val();
	$.ajax( {
		type : "POST" ,
		url : "<?php echo base_url(); ?>select/getSelect_Warna" ,
		data : 'item_id='+param ,
		cache : false ,
		success : function ( data ) {
			var obj = $.parseJSON( data );

			var str = '';
			str += '<option value="" >--PILIH WARNA--</option>';
			$.each( obj[ 'data' ] , function ( i , val ) {
				str += '<option value="' + val.warna_id + '">' + val.warna_nama + '</option>';
			} );

			$( '#field_warna' ).html( str );

		}
	} );
}
function getSelect_Size() {

	var param = $('#field_item').val();
	$.ajax( {
		type : "POST" ,
		url : "<?php echo base_url(); ?>select/getSelect_Size" ,
		data : 'item_id='+param ,
		cache : false ,
		success : function ( data ) {
			var obj = $.parseJSON( data );

			var str = '';
			str += '<option value="" >--PILIH SIZE--</option>';
			$.each( obj[ 'data' ] , function ( i , val ) {
				str += '<option value="' + val.size_id + '">' + val.size_no + '</option>';
			});

			$( '#field_size' ).html( str );

		}
	} );
}
</script>