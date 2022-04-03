<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// session_start();
		$this->load->library('session');
	}


	public function form()
	{
		$this->load->view('login-form');
	}

	public function form_admin()
	{
		$params = array();

		$cookie_name = str_replace(array(' ','.'), "_", $this->config->item('app'))."_".date('y')."_".str_replace(".", "_", $_SERVER['REMOTE_ADDR']);
		$cookie_value = $_SERVER['REMOTE_ADDR'];

		$params['username'] = "";
		$params['password'] = "";
		$params['is_cookies'] = 0;

		// if(isset($_COOKIE[$cookie_name])) {
		// 	$get_cookies = $this->db->get_where('cookies', array('cookie_name'=>$cookie_name))->row();
		// 	// echo $this->db->last_query(); die;
		// 	$params['username'] = $get_cookies->username;
		// 	$params['password'] = $get_cookies->password;
		// 	$params['is_cookies'] = 1;
		// }else{
		// 	$delete_cookies = $this->db->where(array('cookie_name'=>$cookie_name))->delete('cookies');
		// }

		$this->load->view('login-form-admin');
	}

	public function aksi_login()
	{
		$kar_username 	= $this->input->post('username');
		$kar_password 	= $this->input->post('password');
		$akses_id 		= $this->input->post('akses');

		$where 		= array(
			'kar_username' 	=> $kar_username,
			'kar_password' 	=> $kar_password,
			'is_active' 	=> 1
			// 'akses_id'			=> $akses_id
		);
		$cek 		  = $this->model_admin->cek_login('m_karyawan', $where)->num_rows();   // UNTUK PENGECEKAN ADA TIDAKNYA DATA
		$cek1 		  = $this->model_admin->cek_login('m_karyawan', $where)->result();     // UNTUK PEMBUATAN SESSION
		$cek2 		  = $this->model_admin->cek_login('m_karyawan', $where)->row();        // UNTUK HAK AKSES
		$cek3 		  = $this->model_admin->cek_login('m_karyawan', $where)->row_array();  // UNTUK HAK AKSES
		$join_tabel	  = $this->db->query("SELECT a.*, b.* 	
						FROM m_karyawan a
						INNER JOIN m_departement b ON a.dep_id=b.dep_id"
		)->result(); // JOIN TABEL UNTUK PEMBUATAN SESSION

		foreach ($cek1 as $var) {
			$kar_id 		= $var->kar_id;
			$kar_nik 		= $var->kar_nik;
			$kar_nama 		= $var->kar_nama;
			$kar_foto 		= $var->kar_foto;
			$akses			= $var->akses_id;
			$dep_id			= $var->dep_id;
			$plant_id		= $var->plant_id;
			$team_id		= $var->team_id;
			$email			= $var->kar_email;
		}

		foreach($join_tabel as $var) {
			$dep_nama	= $var->dep_nama;
		}

		if ($cek > 0) {
			
			$data_session = array( // BUAT SESSION
				'user' 		=> $kar_nama,
				'id' 		=> $kar_id,
				'nik' 		=> $kar_nik,
				'foto' 		=> $kar_foto,
				'akses' 	=> $akses,
				'dep_id' 	=> $dep_id,
				'plant_id' 	=> $plant_id,
				'team_id' 	=> $team_id,
				'email' 	=> $email,
				'level'  	=> $cek3['akses_id'],
				'status' 	=> 'login'
			);
			$this->session->set_userdata($data_session);

			if ($cek2->akses_id == 7) {
				redirect('security/index');
			} else if ($cek2->akses_id == 6) {
				redirect('admin/index');
			} else if ($cek2->akses_id == 5) {
				redirect('japanese/index');
			} else if ($cek2->akses_id == 4) {
				redirect('manager/index');
			} else if ($cek2->akses_id == 3) {
				redirect('leader_up/index');
			} else {
				redirect('karyawan/index');
			}
		} else {
			//print_r($user_name.$password.$akses_id);
			$this->session->set_flashdata('info', 'Username atau Password Salah !.');
			redirect('login/form');
		}
	}

	
	public function aksi_login_admin()
	{
		$kar_username 	= $this->input->post('username');
		$kar_password 	= $this->input->post('password');

		$where 		= array(
			'kar_username' 	=> $kar_username,
			'kar_password' 	=> $kar_password,
			'is_active' 	=> 1
		);
		$cek 		  = $this->model_admin->cek_login('m_karyawan', $where)->num_rows();   // UNTUK PENGECEKAN ADA TIDAKNYA DATA
		$cek1 		  = $this->model_admin->cek_login('m_karyawan', $where)->result();     // UNTUK PEMBUATAN SESSION
		$cek2 		  = $this->model_admin->cek_login('m_karyawan', $where)->row();        // UNTUK HAK AKSES
		$cek3 		  = $this->model_admin->cek_login('m_karyawan', $where)->row_array();  // UNTUK HAK AKSES
		$join_tabel	  = $this->db->query("SELECT a.*, b.* 	
						FROM m_karyawan a
						INNER JOIN m_departement b ON a.dep_id=b.dep_id"
		)->result(); // JOIN TABEL UNTUK PEMBUATAN SESSION

		foreach ($cek1 as $var) {
			$kar_id 		= $var->kar_id;
			$kar_nik 		= $var->kar_nik;
			$kar_nama 		= $var->kar_nama;
			$kar_foto 		= $var->kar_foto;
			$akses			= $var->akses_id;
			$dep_id			= $var->dep_id;
			$plant_id		= $var->plant_id;
			$team_id		= $var->team_id;
			$email			= $var->kar_email;
		}

		foreach($join_tabel as $var) {
			$dep_nama	= $var->dep_nama;
		}

		if ($cek > 0) {
			
			$data_session = array( // BUAT SESSION
				'user' 		=> $kar_nama,
				'id' 		=> $kar_id,
				'nik' 		=> $kar_nik,
				'foto' 		=> $kar_foto,
				'akses' 	=> $akses,
				'dep_id' 	=> $dep_id,
				'plant_id' 	=> $plant_id,
				'team_id' 	=> $team_id,
				'email' 	=> $email,
				'level'  	=> $cek3['akses_id'],
				'status' 	=> 'login'
			);
			$this->session->set_userdata($data_session);

			if ($cek2->akses_id == 6) {
				redirect('admin/index');
			} else if ($cek2->akses_id == 5) {
				redirect('japanese/index');
			} else if ($cek2->akses_id == 4) {
				redirect('manager/index');
			} else if ($cek2->akses_id == 3) {
				redirect('leader_up/index');
			} else {
				redirect('karyawan/index');
			}
		} else {
			//print_r($user_name.$password.$akses);
			$this->session->set_flashdata('info', 'Username atau Password Salah !.');
			redirect('login/form');
		}
	}
	
	public function logout_user($id)
	{
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', array('kar_lastlogin' => date('Y-m-d H:i:s')));
		$this->session->sess_destroy();
		redirect('login/form');
	}
	public function logout_karyawan($id)
	{
		$this->db->where('kar_id', $id);
		$this->session->sess_destroy();
		redirect('login/form_karyawan');
	}
}
