<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
				<h2><?php echo $title?></h2>
				<table id="example1" class="table table-bordered table-hover dataTable">
                    <thead>
					<tr>
                        <th>NO</th>
						<th>ID KARYAWAN</th>
						<th>PIN KARYAWAN</th>
                        <th>NAMA KARYAWAN</th>
                        <th>JABATAN</th>
                        <th>SECTION</th>
						<th>EMAIL</th>
						<th>TANGGAL MASUK</th>
						<th>JENIS KELAMIN</th>
						<th>PLANT</th>
						<th>Is Active</th>
                    </thead>
                    <tbody>
					<?php  
                        $no = 1;
                        foreach ($data as $lihat):
					?>
                    	<tr>
                            <td><?php echo $no++ ?></td>
							<td><?php echo $lihat->kar_id?></td>
							<td><?php echo $lihat->kar_nik?></td>
							<td><?php echo $lihat->kar_nama?></td>
							<td><?php echo $lihat->jab_nama?></td>
							<td><?php echo $lihat->dep_nama?></td>
							<td><?php echo $lihat->kar_email?></td>
							<td><?php echo $lihat->kar_tanggalmasuk?></td>
							<td><?php echo $lihat->kar_jeniskelamin?></td>
							<td><?php echo $lihat->plant_nama?></td>
							<td><?php echo $lihat->is_active?></td>
                    	</tr>
                    	<?php endforeach; ?>
                    </tbody>
				</table>
				
                </div><!-- /.box-body -->
                