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
			<th style="background-color: green;">SISA CUTI CT</th>
		</tr>
		<?php  
		$no = 1;
		foreach ($data as $col):
			$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $col->kar_id))->row();
            $row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $col->kar_id))->row();
		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo ucwords($col->kar_nik) ?></td>
			<td><?php echo $col->kar_nama?></td>
			<td><?php echo $col->dep_nama?></td>
			<td><?php echo $col->plant_nama?></td>
			<td><?php echo $row_jatah_CT->total - $row_potong_CT->total?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
</table>