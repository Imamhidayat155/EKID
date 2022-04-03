
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
			<title><?php echo $title?></title>
				<fieldset>
					<legend><h2 align="center">UNIFORM REQUISITION TAHUNAN</h2></legend>
                      	<?php  
                        foreach ($data as $var): //ambil data header, cust, member, 1 row
                        ?>
                <table border="0" cellpadding="5">
                    <tr>
						<th align="left" width="100">TANGGAL</th>
						<th> : </th>
						<th align="left" width="200"><?php echo $var->reqhed_tanggal?></th>
						<th width="25%">&nbsp;</th>
						<th align="left" width="150">KODE</th>
						<th> : </th>
						<th align="left"><?php echo ucwords($var->reqhed_code)?></th>
					</tr>
                    <tr>
						<th align="left">NAMA</th>
						<th> : </th>
						<th align="left"><?php echo $var->kar_nama?></th>
						<th align="left">&nbsp;</th>
						<th align="left">NIK</th>
						<th> : </th>
						<th align="left"><?php echo ($var->kar_nik)?></th>
					</tr>
					
                </table>
				<legend><h4 align="left">Detail :</h4></legend>
				</fieldset><br>
				<!-- transaksi detail -->
				
				<table border="1" class="tabel" cellpadding="5" width="100%" style="border-collapse:collapse" >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Warna</th>
                        <th>Size</th>
						<th>Point</th>
						<th>Jumlah</th>
						<th>Point yang dipakai</th>
					  </tr>
                    </thead>
                    <tbody>
					<?php //relasi detail dengan product
						$no=1;
						$sql=$this->db->query("select a.*,b.*,c.*,d.*
						from req_detail a
						inner join m_item b on a.item_id=b.item_id
						left join m_warna c on a.warna_id=c.warna_id
						left join m_size d on a.size_id=d.size_id
						where reqhed_code='$var->reqhed_code'")->result_object();
						foreach($sql as $item){
					?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $item->item_kode." | ".$item->item_nama?></td>
							<td align="center"><?php echo $item->warna_nama?></td>
							<td align="center"><?php echo $item->size_no?></td>
							<td align="center"><?php echo $item->item_point?></td>
							<td align="center"><?php echo $item->req_qty?></td>
							<td align="center"><?php echo number_format($item->item_point*$item->req_qty)?></td>
						</tr>
					<?php } ?>
						<tr>     		
							<th colspan="6">TOTAL</th>
							<th align="center"><?php echo number_format($var->reqhed_totalpoint)?></th>
						</tr>
                    </tbody>
				  </table>
                  <?php endforeach; ?>