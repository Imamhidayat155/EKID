<style>
    body{
        font-family: Tahoma,Geneva, sans-serif;
        text-align: left;
    }
</style>
<div style="background-color:#fff; margin-left: 20px;margin-right: 20px;">
    <div style="padding-left: 20px;">
        <img style="height: auto;width: 100%;max-width: 500px" src="<?=$this->config->item( 'root_url' )?>assets/images/logo_email.png"/>
    </div>
    <div style="background-color: #00ff00; padding: 20px;border-radius: 10px;">
        <p>
            <?php 
                //select table tr_permohonan_cuti untuk mendapatkan nilai GROUP karyawan
                if(isset($kar_id_user)){
                    $kar_id_user = $kar_id_user;
                    $sql2 = $this->db->query("SELECT pc_id, pc_grup_line
                    FROM tr_permohonan_cuti WHERE kar_id=$kar_id_user
                    ORDER BY pc_id DESC LIMIT 1");
                }
                ?>   
            <span style=" font-size: 16px;">Dear <?php if(isset($nama)) echo $nama;?>-<?php if(isset($pin)) echo $pin;?></span><br>

            <p>
                <span>
                    <?php 
                    if(isset($kar_id_user)){
                        $kar_id_user = $kar_id_user;

                        $sql = $this->db->query("SELECT pc_id, pc_lamacuti, pc_tanggalfrom, pc_tanggalto, pc_keterangan
                        FROM tr_permohonan_cuti WHERE kar_id=$kar_id_user
                        ORDER BY pc_id DESC LIMIT 1");
                    }?>
                    <span style="font-size: 16px;">Pengajuan cuti tahunan anda selama <?php echo $sql->row()->pc_lamacuti;?> hari di tanggal <?php echo $sql->row()->pc_tanggalfrom; ?> sampai <?php echo $sql->row()->pc_tanggalto; ?>.<br>
                    <span style="font-size: 16px;"><strong>Dengan Alasan: <?php echo $sql->row()->pc_keterangan; ?></strong></span>
                    <span>
                        <span style="font-size: 16px; font-wieght: bold;"><br>
                            <strong>STATUS CUTI     : Approved By <?php if(isset($approved)) echo $approved;?></strong> <br>
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