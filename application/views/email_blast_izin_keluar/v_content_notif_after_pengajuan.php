<style>
    body{
        font-family: Tahoma,Geneva, sans-serif;
        text-align: left;
    }
</style>
<div style="background-color:#fff; margin-left: 20px;margin-right: 20px;">
    <div style="background-color: #EE82EE;padding: 20px;border-radius: 10px;">
        <p>
            <span style=" font-size: 16px;">Dengan Hormat,</span><br>
            <span style=" font-size: 16px;">Dengan ini saya:</span><br>
            <span style="">
                <span style="font-size: 16px; font-wieght: bold;"><br>
                    <strong>NAMA            : <?php if(isset($nama)) echo $nama;?></strong> <br>
                    <strong>PIN             : <?php if(isset($pin)) echo $pin;?></strong> <br>
                    <strong>SECTION/PLANT   : <?php if(isset($plant)) {
                        $sql = $this->db->query("SELECT a.*,b.* 
                        FROM m_karyawan a
                        INNER JOIN m_plant b on a.plant_id=b.plant_id
                        WHERE a.plant_id=$plant")->row();

                        echo $sql->plant_nama;
                    }?></strong> <br>
                </span>
            </span>
        </p>
        <p>
            <span>
                <?php 
                    if(isset($kar_nik)){
                        $kar_nik = $kar_nik;
                        
                        $sql = $this->db->query("SELECT id, waktu_start, waktu_finish, tujuan
                        FROM tr_izin_keluar WHERE kar_nik=$kar_nik
                        ORDER BY id DESC LIMIT 1");
                    }
                ?>

                <span style="font-size: 16px;">Mengajukan izin keluar kantor dari jam: <?php echo $sql->row()->waktu_start; ?> s/d <?php echo $sql->row()->waktu_finish; ?>.<br>
                <span style="font-size: 16px;"><strong>Alasan: <?php echo $sql->row()->tujuan; ?></strong></span>
            </span>
            </span>
            <p style="">
                <span style="">
                    <span style="font-size: 16px;">Demikian Izin Keluar ini saya sampaikan.</span>
                    <br><br>
                    <span style="font-size: 16px;"><strong>"Untuk SH terkait silahkan lakukan <u>Approve atau Reject Izin Keluar</u>, </strong>dengan klik link berikut : </span>
                    <span style="font-size: 16px; color: blue;"><em><u><a href="http://ecuti.enkei.co.id">http://ecuti.enkei.co.id</a></u></em></span>
                    </span>
                </span>
            </p>
        </p>
    </div>
<div>