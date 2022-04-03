<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('email');
	}

	public function after_reg_test()
	{
		$this->load->model('M_email_blast', 'M_email_blast');
		$param = array();
        $param['email'] = 'ihidayat155@gmail.com'; // Email to leader_up
        $param['nama'] = 'imam'; 
        $param['username'] = 'imam';
        $param['password'] = 'imam123';

		$this->M_email_blast->notif_after_register( $param );	//Kirim parameter data ke model
	}
	
	// public function send_mail_test()
	// {
	// 	ini_set( 'display_errors', 1 );
	// 	error_reporting( E_ALL );
		
	// 	$this->load->model('M_email_blast', 'M_email_blast');

	// 	$param = array();
    //     $param['email'] = 'yusufha.72@gmail.com';
    //     $param['nama'] = 'yusufha.72';
    //     $param['username'] = 'yusufha.72';
    //     $param['password'] = 'yusufha.72';

	// 	$this->M_email_blast->send_mail( $param );	
	// }

}
