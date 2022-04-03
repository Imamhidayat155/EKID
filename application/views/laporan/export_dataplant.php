<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<h2><?php echo $title ?></h2>
<table id="example1" class="table table-bordered table-hover dataTable">
	<thead>
		<tr>
			<th>NO</th>
			<th>KODE PLANT</th>
			<th>NAMA PLANT</th>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach ($data as $lihat) :
		?>
			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php echo $lihat->plant_kode ?></td>
				<td><?php echo $lihat->plant_nama ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

</div><!-- /.box-body -->