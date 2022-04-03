<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1" >
		<tr>
			<th>No</th>
			<th>PIN</th>
			<th>NAMA KARYAWAN</th>
			<th>SECTION</th>
			<th>PLANT</th>
			<th style="background-color: #3178F5;">TANGGAL PENGAJUAN</th>
			<th style="background-color: #EFF919;">START CUTI</th>
			<th style="background-color: #EFF919;">FINISH CUTI</th>
			<th>ALASAN</th>
			<th>STATUS CUTI</th>
			<th style="background-color: #F1B814;">APPROVED BY LEADER UP</th>
			<th style="background-color: #F1B814;">APPROVED DATE</th>
			<th style="background-color: #72E716;">APPROVED BY SH / MANAGER</th>
			<th style="background-color: #72E716;">APPROVED DATE</th>
		</tr>
		<?php  
		$no = 1;
		foreach ($data as $col):
		// 	$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $col->kar_id))->row();
        //  $row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $col->kar_id))->row();
		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo ucwords($col->kar_nik) ?></td>
			<td><?php echo $col->kar_nama?></td>
			<td><?php echo $col->dep_nama?></td>
			<td><?php echo $col->plant_nama?></td>
			<td><?php echo $col->created?></td>
			<td><?php echo $col->pc_tanggalfrom?></td>
			<td><?php echo $col->pc_tanggalto?></td>
			<td><?php echo $col->pc_keterangan?></td>
			<td><?php echo $col->status_nama?></td>
			<td><?php echo $col->actioned_by?></td>
			<td><?php echo $col->tanggal_approved?></td>
			<td><?php echo $col->pc_approvedby?></td>
			<td><?php echo $col->pc_dateapproved?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
</table>