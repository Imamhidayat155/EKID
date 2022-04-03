<title>Import Excel</title>
<?php
//include"conn.php";
//mysqli_connect('localhost', 'u898275648_kspos', 'kspos123');
//mysql_select_db('u898275648_kspos');
//mysql_connect("localhost", "u599590958_sipm", "087828289410sipm", "u599590958_sipm");
$link = mysqli_connect("u790196814_ecuti_enkei", "Enkei123$", "", "u790196814_ecuti_enkei");
//memanggil file excel_reader
require "excel_reader.php";

//jika tombol import ditekan
if (isset($_POST['submit'])) {

    $target = basename($_FILES['filePlantAll']['name']);
    move_uploaded_file($_FILES['filePlantAll']['tmp_name'], $target);

    // tambahkan baris berikut untuk mencegah error is not readable
    chmod($_FILES['filePlantAll']['name'], 0777);

    $data = new Spreadsheet_Excel_Reader($_FILES['filePlantAll']['name'], false);

    //    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index = 0);

    //    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset($_POST["drop"]) ? $_POST["drop"] : 0;
    if ($drop == 1) {
        //    kosongkan tabel karyawan
        $truncate = "TRUNCATE TABLE m_plant";
        mysqli_query($link, $truncate);
        //$truncate1 ="TRUNCATE TABLE invoice";
        //mysql_query($truncate1);
    };

    //    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i = 2; $i <= $baris; $i++) {
        //  membaca data (kolom ke-1 sd terakhir)
        $plant_id             = $data->val($i, 1);
        $plant_kode           = $data->val($i, 2);
        $plant_nama           = $data->val($i, 3);

        //  setelah data dibaca, masukkan ke tabel yang dituju
        $query = "INSERT into m_plant (plant_id,plant_kode,plant_nama)
	values('$plant_id','$plant_kode','$plant_nama')";
        $hasil = mysqli_query($link, $query);
    }

    if (!$hasil) {
        //  jika import gagal
        //  echo "gagal";
        die(mysqli_error());
    } else {
        //  jika impor berhasil
?>
        <script>
            alert("Data sukses di Upload");
            window.close();
        </script>
<?php
    }

    //    hapus file xls yang udah dibaca
    unlink($_FILES['filePlantAll']['name']);
}

?>

<form name="myForm" id="myForm" onSubmit="return validateForm()" action="importPlant.php" method="post" enctype="multipart/form-data">
    <table border="0" style="border-collapse:collapse;" cellpadding="5">
        <tr>
            <td colspan="">* Ketentuan :</td>
            <td><label>- File yang diupload harus format 97-2003</label></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="file" id="filePlantAll" name="filePlantAll" /><br>
                <label><input type="checkbox" name="drop" value="1" /> <u>KOSONGKAN SQL TERLEBIH DAHULU</u> </label>
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
    function validateForm() {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if (!hasExtension('filePlantAll', ['.xls'])) {
            alert("Hanya file XLS (EXCEL 2003) yang diijinkan.");
            return false;
        }
    }
</script>