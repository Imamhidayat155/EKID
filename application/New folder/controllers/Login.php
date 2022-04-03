<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	//function untuk meload form login admin
	public function form()
	{
		$this->load->view('login-form');
	}

	//function untuk meload form login karyawan
	public function form_karyawan()
	{
		$this->load->view('login-form-karyawan');
	}

	//function untuk menangani aksi login admin
	public function aksi_login()
	{
		$user_name=$this->input->post('username');
		$password=$this->input->post('password');
		$akses=$this->input->post('akses');
		$where=array(
			'user_username'=>$user_name,
			'user_password'=>$password,
			'user_aksessebagai'=>$akses
		);
		$cek=$this->model_admin->cek_login('m_user',$where)->num_rows();
		$cek1=$this->model_admin->cek_login('m_user',$where)->result();
		foreach($cek1 as $var){
			$user_id=$var->user_id;
			$user_nama=$var->user_nama;
			$user_foto=$var->user_foto;
		}
		if($cek>0){
			$data_session=array(
				'user'=>$user_username,
				'nama'=>$user_nama,
				'id'=>$user_id,
				'foto'=>$user_foto,
				'akses'=>$akses,
				'status'=>'login'
			);
			$this->session->set_userdata($data_session);
			redirect('admin/index');
		
		}else{
			//print_r($user_name.$password.$akses);
			$this->session->set_flashdata('info','Gagal Login...User atau Password salah..!');
			redirect('login/form');
		}		
	}

	//function untuk menangani aksi login karyawan
	public function aksi_login_karyawan()
	{
		$kar_nik=$this->input->post('nik');
		$where=array(
			'kar_nik'=>$kar_nik,
			'is_active'=>1,
		);
		$cek=$this->model_admin->cek_login('m_karyawan',$where)->num_rows();
		$cek1=$this->model_admin->cek_login('m_karyawan',$where)->result();
		foreach($cek1 as $var){
			$kar_id=$var->kar_id;
			$kar_nama=$var->kar_nama;
		}
		if($cek>0){
			$data_session=array(
				'nik'=>$kar_nik,
				'nama'=>$kar_nama,
				'id'=>$kar_id,
				'akses'=>'Karyawan',
				'status'=>'login'
			);
			$this->session->set_userdata($data_session);
			redirect('karyawan/tambah_transaksi');
		
		}else{
			//print_r($user_name.$password.$akses);
			$this->session->set_flashdata('info','Nik belum terdaftar / belum di Aktifkan..!');
			redirect('login/form_karyawan');
		}		
	}
	public function logout_user($id)
	{	
		$this->db->where('user_id',$id);
		$this->db->update('m_user',array('user_lastlogin'=>date('Y-m-d H:i:s')));
		$this->session->sess_destroy();
		redirect('login/form');
	}
	public function logout_karyawan($id)
	{	
		$this->db->where('kar_id',$id);
		$this->session->sess_destroy();
		redirect('login/form_karyawan');
	}
	
}
