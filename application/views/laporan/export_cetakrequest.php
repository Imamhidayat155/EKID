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
						<th>NAMA</th>
						<th>NIK</th>
						<th>SECTION</th>
						<th>PLANT</th>
						<th>NAMA_BARANG</th>
						<th>WARNA</th>
						<th>QTY_REQUEST</th>
						<th>SIZE</th>
						<th>REQ_TANGGAL</th>
                    </thead>
                    <tbody>
					<?php  
                        $no = 1;
                        foreach ($data as $lihat):
					?>
                    	<tr>
                        <td><?php echo $no++ ?></td>
							<td><?php echo $lihat->kar_nama?></td>
							<td><?php echo $lihat->kar_nik?></td>
							<td><?php echo $lihat->kar_section?></td>
							<td><?php echo $lihat->kar_plant?></td>
							<td><?php echo $lihat->item_nama?></td>
							<td><?php echo $lihat->warna_nama?></td>
							<td><?php echo $lihat->req_qty?></td>
							<td><?php echo $lihat->size_no?></td>
							<td><?php echo $lihat->req_tanggal?></td>
                    	</tr>
                    	<?php endforeach; ?>
                    </tbody>
				</table>
				
                </div><!-- /.box-body -->
                