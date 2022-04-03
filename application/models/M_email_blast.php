<?php

require_once APPPATH . '/third_party/PHPMailer/src/Exception.php';
require_once APPPATH . '/third_party/PHPMailer/src/OAuth.php';
require_once APPPATH . '/third_party/PHPMailer/src/PHPMailer.php';
require_once APPPATH . '/third_party/PHPMailer/src/POP3.php';
require_once APPPATH . '/third_party/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class M_email_blast extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function notif_after_pengajuan( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data             = array();
        $data['kar_id']   = $param['id'];
        $data['email']    = $param['email'];
        $data['nama']     = $param['nama'];
        $data['pin']      = $param['pin'];
        $data['plant']    = $param['plant'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Pengajuan Cuti Notification';
        // $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast/v_content_notif_after_pengajuan_SH' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );


        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        // $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        if(!$mail->send()){
            echo "email tidak terkirim";
        }else{
            echo "email terkirim";
        }
    }

    public function notif_after_approval( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data                    = array();
        $data['kar_id']          = $param['id']; //ambil nilai kar_id pengapprove
        $data['kar_id_user']     = $param['kar_id']; //ambil nilai kar_id karyawan yang di approve
        $data['email']           = $param['email'];
        $data['nama']            = $param['nama'];
        $data['pin']             = $param['pin'];
        $data['plant']           = $param['plant'];
        $data['approved']        = $param['approved_by'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Approval Cuti Notification';
        // $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast/v_content_notif_after_approval' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );


        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        // $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        if(!$mail->send()){
            echo "email tidak terkirim";
        }else{
            echo "email terkirim";
        }
    }

    public function notif_after_approval_to_user( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data                    = array();
        $data['kar_id']          = $param['id']; //ambil nilai kar_id pengapprove
        $data['kar_id_user']     = $param['kar_id']; //ambil nilai kar_id karyawan yang di approve
        $data['email']           = $param['email'];
        $data['nama']            = $param['nama'];
        $data['pin']             = $param['pin'];
        $data['plant']           = $param['plant'];
        $data['approved']        = $param['approved_by'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Notifikasi Cuti Disetujui';
        // $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast/v_content_notif_after_approval_to_user' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );

        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        // $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        if(!$mail->send()){
            echo "email tidak terkirim";
        }else{
            echo "email terkirim";
        }
    }

    public function notif_after_reject_to_user( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data                    = array();
        $data['kar_id']          = $param['id']; //ambil nilai kar_id pengapprove
        $data['kar_id_user']     = $param['kar_id']; //ambil nilai kar_id karyawan yang di approve
        $data['email']           = $param['email'];
        $data['nama']            = $param['nama'];
        $data['pin']             = $param['pin'];
        $data['plant']           = $param['plant'];
        $data['approved']        = $param['approved_by'];
        $data['alasan']        = $param['alasan'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Notifikasi Cuti Ditolak';
        $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast/v_content_notif_after_reject_to_user' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );

        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        if(!$mail->send()){
            echo "email tidak terkirim";
        }else{
            echo "email terkirim";
        }
    }


    public function notif_after_pengajuan_izin_keluar( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data             = array();
        $data['kar_nik']   = $param['nik'];
        $data['email']    = $param['email'];
        $data['nama']     = $param['nama'];
        $data['pin']      = $param['pin'];
        $data['plant']    = $param['plant'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Izin Keluar Notifikasi';
        // $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast_izin_keluar/v_content_notif_after_pengajuan' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );


        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        // $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        if(!$mail->send()){
            echo "email tidak terkirim";
        }else{
            echo "email terkirim";
        }
    }

    public function notif_after_approval_izin_keluar_to_user( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data                    = array();
        $data['kar_id']          = $param['id']; //ambil nilai kar_id pengapprove
        $data['kar_id_user']     = $param['kar_id']; //ambil nilai kar_id karyawan yang di approve
        $data['email']           = $param['email'];
        $data['nama']            = $param['nama'];
        $data['pin']             = $param['pin'];
        $data['plant']           = $param['plant'];
        $data['approved']        = $param['approved_by'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Notifikasi Izin Keluar Disetujui';
        // $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast_izin_keluar/v_content_notif_after_approval_izin_keluar_to_user' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );

        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        // $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        // if(!$mail->send()){
        //     echo "email tidak terkirim";
        // }else{
        //     echo "email terkirim";
        // }
    }

    public function notif_after_reject_izin_keluar_to_user( $param = array() ) {

        $now = date( 'Y-m-d' , strtotime( 'NOW' ) );

        $data                    = array();
        $data['kar_id']          = $param['id']; //ambil nilai kar_id pengapprove
        $data['kar_id_user']     = $param['kar_id']; //ambil nilai kar_id karyawan yang di approve
        $data['email']           = $param['email'];
        $data['nama']            = $param['nama'];
        $data['pin']             = $param['pin'];
        $data['plant']           = $param['plant'];
        $data['approved']        = $param['approved_by'];
        $data['alasan']          = $param['alasan'];

        // $data['data_member'] = $this->db->get('m_karyawan')->result();
        // $data['data_akun'] = $this->db->get('m_karyawan')->row();

        // subject/title email blast
        $subject = 'Notifikasi Izin Keluar Ditolak';
        $cc = 'imamhidayat@enkei.co.id';

        // content email blast
        $content = $this->load->view( 'email_blast_izin_keluar/v_content_notif_after_reject_izin_keluar_to_user' , $data , TRUE );

        $mail = new PHPMailer;

        //Server settings
        $mail->SMTPDebug    = 0;                           // Enable verbose debug output  //BISA DIISI 0,1,2 
        $mail->isSMTP();                                   // Set mailer to use SMTP
        $mail->SMTPAuth     = TRUE;                        // Enable SMTP authentication
        $mail->Host         = 'smtp.gmail.com';            // Specify main and backup SMTP servers
        $mail->Username     = 'storage@enkei.co.id';       // SMTP username (Email pengirim)
        $mail->Password     = '#storage';                  // SMTP password
        $mail->SMTPSecure   = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = 587;                         // TCP port to connect to

        //Set who the message is to be sent from
        $mail->setFrom( 'no-reply@enkei.co.id' , 'no-reply@enkei.co.id' );

        //Set who the message is to be sent to
        $mail->addAddress( $data['email']); //, $data['nama'] 
        $mail->AddCC($cc);

        $mail->isHTML( TRUE );
        $mail->Subject  = $subject;
        $mail->Body     = $content;
        $mail->AltBody  = $content;

        if(!$mail->send()){
            echo "email tidak terkirim";
        }else{
            echo "email terkirim";
        }
    }
}
