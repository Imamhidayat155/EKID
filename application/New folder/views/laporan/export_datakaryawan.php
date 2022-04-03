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
						<th>PIN KARYAWAN</th>
                        <th>NAMA KARYAWAN</th>
						<th>EMAIL</th>
						<th>TANGGAL GABUNG</th>
						<th>SECTION</th>
						<th>POSISI</th>
						<th>JENIS KELAMIN</th>
						<th>PLANT</th>
						<th>NO TELP</th>
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
							<td><?php echo $lihat->kar_email?></td>
							<td><?php echo $lihat->kar_gabung?></td>
							<td><?php echo $lihat->kar_section?></td>
							<td><?php echo $lihat->kar_posisi?></td>
							<td><?php echo $lihat->kar_jeniskelamin?></td>
							<td><?php echo $lihat->kar_plant?></td>
							<td><?php echo $lihat->kar_notelp?></td>
                    	</tr>
                    	<?php endforeach; ?>
                    </tbody>
				</table>
				
                </div><!-- /.box-body -->
                