
<style>
body {
    font-family: cambria;	
    font-size: 12px;
    font-weight:bold ;
}
tabel {
	border-collapse: collapse;
    font-family: cambria;	
    font-size: 18px;
    font-weight:bold ;	
}
.tabelhead {
	border-collapse: collapse;
    font-family: cambria;	
    font-size: 12px;
    font-weight:bold ;	
}
.tabelunderhead {
	border-collapse: collapse;
    font-family: cambria;	
    font-size: 12px;	
}
.tabeldetail {
	border-collapse: collapse;
    font-family: cambria;	
    font-size: 18px;
    font-weight:bold ;	
}
.tabelfooter {
	border-collapse: collapse;
    font-family: cambria;	
    font-size: 12px;	
}
</style>
	<body onload="window.print();" onafterprint="window.close();" >

				<title><?php echo $title?></title>
					<fieldset>
						<legend style="color: green;"><h2 align="center">Detail Histori CT</h2></legend>
						<?php  
							foreach ($data as $var): //ambil data 
						?>
						<table border="0" cellpadding="5">
							<tr>
								<th align="left" width="100">NAMA</th>
								<th> : </th>
								<th align="left" width="200"><?php echo $var->kar_nama?></th>
								<th align="left" width="150">DEPT</th>
								<th> : </th>
								<th align="left"><?php echo ucwords($var->dep_nama)?></th>
							</tr>
							<tr>
								<th align="left">PIN</th>
								<th> : </th>
								<th align="left"><?php echo $var->kar_nik?></th>
								<th align="left">JOIN DATE</th>
								<th> : </th>
								<th align="left"><?php echo $var->kar_tanggalmasuk?></th>
							</tr>
							<tr>
								<th align="left"><u>JATAH CT</u></th>
								<th> : </th>
								<th align="left"><u><?php echo $var->penambahan_cuti_jatahcuti?></u></th>
							</tr>
							
						</table>
					</fieldset><br>
					<legend><h3 align="left">Detail :</h3></legend>

					<!-- transaksi detail -->
					
					<table border="1" class="tabel" cellpadding="5" width="100%" style="border-collapse:collapse" >
						<thead>
							<tr>
								<th>NO</th>
								<th>KODE CUTI</th>
								<th>FROM</th>
								<th>TO</th>
								<th>ALASAN</th>
								<th>STATUS</th>
								<th>CUTI DIAMBIL</th>
								<th>ACTIONED BY</th>
							</tr>
						</thead>
						<tbody>
						<?php //relasi detail dengan karyawan
							$id = $var->id_kar;
							$no = 1;
							$this->db->select('a.*, b.status_nama, c.total as total_jatah, d.total as total_potong');
							$this->db->from('tr_permohonan_cuti a');
							$this->db->join('m_status b', 'a.pc_status=b.status_id');
							$this->db->join('v_jatah_CT_perkaryawan c', 'c.kar_id=a.kar_id', 'left');
							$this->db->join('v_potong_CT_perkaryawan d', 'd.kar_id=a.kar_id', 'left');
							$this->db->where('a.kar_id=',$id);
							$this->db->where('a.cuti_kode=','CT');
							$sql = $this->db->get('')->result_object();
							
							foreach($sql as $detail_cuti){
						?>
							<tr>
								<td><?php echo $no++?></td>
								<td><?php echo $detail_cuti->pc_kode?></td>
								<td><?php echo $detail_cuti->pc_tanggalfrom?></td>
								<td><?php echo $detail_cuti->pc_tanggalto?></td>
								<td align="center"><?php echo $detail_cuti->pc_keterangan?></td>
								<td align="center"><?php echo $detail_cuti->status_nama?></td>
								<td align="center"><?php echo $detail_cuti->pc_lamacuti?></td>
								<td align="center"><?php echo $detail_cuti->pc_approvedby?></td>
							</tr>
						<?php } ?>
							<tr>     		
								<th colspan="6">Total Cuti</th>
								<th align="center"><?php echo number_format($detail_cuti->total_potong)?></th>
							</tr>
							<tr>     		
								<th colspan="6">Sisa Cuti</th>
								<th align="center"><?php echo number_format($detail_cuti->total_jatah - $detail_cuti->total_potong)?></th>
							</tr>
						</tbody>
					</table>
					<?php endforeach; ?>
</body>
