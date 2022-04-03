<style>
    body{
        font-family: Tahoma,Geneva, sans-serif;
        text-align: left;
    }
</style>
<div style="background-color:#fff; margin-left: 20px;margin-right: 20px;">
    <div style="background-color: #ffa500; padding: 20px;border-radius: 10px;">
        <p>
            <span style=" font-size: 16px;">Dear <?php if(isset($nama)) echo $nama;?>-<?php if(isset($pin)) echo $pin;?></span><br>
            <p>
                <span>
                    <?php 
                        if(isset($pin)){
                            $sql = $this->db->query("SELECT id, waktu_start, waktu_finish, tujuan
                            FROM tr_izin_keluar WHERE kar_nik=$pin
                            ORDER BY id DESC LIMIT 1");
                        }
                    ?>
                    <span style="font-size: 16px;">Izin keluar anda "Ditolak" . 
                    <br><br>
                    <span style="font-size: 16px;">
                        <strong>
                            Waktu keluar:  <?php echo $sql->row()->waktu_start; ?> <br>
                            Waktu Kembali: <?php echo $sql->row()->waktu_finish; ?>
                        </strong>
                    </span>                    
                    <br>
                    <span style="font-size: 16px;"><strong>Alasan: <?php echo $sql->row()->tujuan; ?></strong></span>
                    <span>
                        <span style="font-size: 16px; font-wieght: bold;"><br><br>
                            <strong>Status : Rejected By <?php if(isset($approved)) echo $approved;?></strong> <br>
                        </span>
                    </span>
                </span>
            <p>
                <span style="">
                    <span style="font-size: 16px;">Terimakasih.</span>
                </span>
            </p>
            
        </p>
    </div>
<div>