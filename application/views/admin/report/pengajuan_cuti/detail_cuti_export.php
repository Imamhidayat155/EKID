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
			<th style="background-color: yellow;">MULAI CUTI</th>
			<th style="background-color: yellow;">SELESAI CUTI</th>
			<th style="background-color: #3e6ff6;">LAMA CUTI (hari)</th>
			<th>JENIS CUTI</th>
			<th>SISA CUTI</th>
			<th>ALASAN CUTI</th>
			<th>STATUS CUTI</th>
			<th style="background-color: #00ff00;">APPROVED DATE</th>
			<th>APPROVED BY</th>
			<!-- <th style="background-color: yellow;">Kode</th>
			<th style="background-color: yellow;">Produk</th>
			<th style="background-color: yellow;">Jenis</th>
			<th style="background-color: yellow;">Harga</th>
			<th style="background-color: yellow;">Qty</th>
			<th style="background-color: yellow;">Total</th> -->
			<!-- <th>Diskon</th> -->
			<!-- <th style="background-color: yellow;">Jumlah</th> -->
		</tr>
		<?php  
		$no = 1;$sdet_qty=0;$sdet_discount=0;$sdet_amount=0;
		foreach ($data as $col)
		{
			// $sdet_qty=$sdet_qty+$col->sdet_qty;
			// $sdet_discount=$sdet_discount+$col->sdet_discount;
			// $sdet_amount=$sdet_amount+$col->sdet_amount;  
		?>
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $col->kar_nik?></td>
			<td><?php echo $col->kar_nama?></td>
			<td><?php echo $col->dep_nama?></td>
			<td><?php echo $col->pc_tanggalfrom?></td>
			<td><?php echo $col->pc_tanggalto?></td>
			<td><?php echo $col->pc_lamacuti?></td>
			<td><?php echo $col->cuti_kode?></td>
			<td><?php echo $col->pc_sisacuti?></td>
			<td><?php echo $col->pc_keterangan?></td>
			<td><?php echo $col->status_nama?></td>
			<td><?php echo $col->pc_dateapproved?></td>
			<td><?php echo $col->pc_approvedby?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>