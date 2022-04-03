<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Japanese extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if ($this->session->userdata('status') == '') {
			redirect('login/form');
		}
		if($this->session->level != 5) {
			echo "<script>alert('Anda Tidak Punya Akses Untuk Login ke halaman ini !!! Silahkan LOGIN kembali ke akun anda'); 
			location.replace('".base_url('login/form')."');
			</script>";
			// redirect('login/form');
        }
	}
	
    public function index()
	{
		$id = $this->session->userdata('id');
		$get_CB = $this->db->get_where('tr_penambahancuti', array('kar_id' => $id))->row();
		$row_jatah_CP = $this->db->get_where('v_jatah_CP_perkaryawan', array('kar_id' => $id))->row();
		$row_potong_CP = $this->db->get_where('v_potong_CP_perkaryawan', array('kar_id' => $id))->row();
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $id))->row(); //jatah cuti tahunan
		$row_jatah_CT_ok = $this->db->get_where('v_jatah_CT_perkaryawan_OK', array('kar_id' => $id))->row(); //jatah cuti tahunan - cuti bersama 
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $id))->row();

		$sisa_CP_p1 = $row_jatah_CP->total - $row_potong_CP->total - 5;
		if($sisa_CP_p1 < 0) $sisa_CP_p1 = 0;

		$sisa_CP_p2 = $row_jatah_CP->total - $row_potong_CP->total;
		if($sisa_CP_p2 > 5) $sisa_CP_p2 = 5;

		$objek['kar_id'] = $id;
		$objek['jml_CP'] = $row_jatah_CP->total;
		$objek['jml_CT'] = $row_jatah_CT->total;
		$objek['jml_CB'] = $get_CB->penambahan_cuti_cutibersama;
		$objek['sisa_CT_tahun_lalu'] = $get_CB->sisa_cuti_tahun_sebelumnya;
		$objek['jml_CT_sisa'] = $row_jatah_CT_ok->total - $row_potong_CT->total;
		$objek['jml_CT_sisa2'] = $row_jatah_CT->total  - $row_potong_CT->total;  
		$objek['jml_CP_sisa_p1'] = $sisa_CP_p1;
		$objek['jml_CP_sisa_p2'] = $sisa_CP_p2;
		$objek['title'] = 'Dashboard';
		// $objek['page'] = 'v_blank';
		$objek['page'] = 'home';
        $this->load->view('japanese/index', $objek);
        $dep_nama  = $this->session->userdata('nik');
	}
	
	public function profile()
	{
		$objek['title'] = 'MyProfile';
		$objek['page']  = 'profile';
		$this->load->view('japanese/index', $objek);
	}
	public function ganti_foto($id)
	{
		$objek['title'] = 'Ganti Foto Profile';
		$objek['editdata']	= $this->db->get_where('m_user', array('user_id' => $id))->result_object();
		$objek['page'] = 'profile_gantifoto';
		$this->load->view('japanese/index', $objek);
	}
	function edit_fotoadmin($id)
	{
		$objek['title'] = 'Edit Foto Admin';
		$objek['editdata']	= $this->db->get_where('m_admin', array('adm_id' => $id))->result_object();
		$objek['page']	= "admin_editfoto";

		$this->load->view('japanese/index', $objek);
	}
	function update_fotoprofile($id)
	{
		$config = array(
			'upload_path' => 'fotoprofile',
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => 5000000,
			'overwrite' => true
		);
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('file_name')) {
			var_dump($this->upload->display_errors());
			redirect('japanese/ganti_foto/' . $id, 'refresh');
		} else {
			$user_foto = $this->upload->data('file_name');
			$this->db->query("update m_user set user_foto='$user_foto' where user_id='$id'");

			redirect('japanese/user', 'refresh');
		}
    }
	
//----------------------------------------------GANTI PASSWORD
	function ganti_password($id)
	{
		$objek['title'] = 'Ganti Password';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']	= "ganti_password";

		$this->load->view('japanese/index', $objek);
	}

	function update_password($id)
	{
		$kar_password = $this->input->post('kar_password');
		$data 	      = array(
			'kar_password' 	=> $kar_password
		);

		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data);

		echo "<script>alert('Password Berhasil Diubah !!')</script>";
			
		redirect('japanese','refresh');
	}
//----------------------------------------------TRANSAKSI CUTI TAHUNAN
	function tr_cuti()
	{
        $kar_id  = $this->session->userdata('id');
		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
						FROM m_karyawan a
						INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
						INNER JOIN m_status c ON b.pc_status=c.status_id
						WHERE pc_status = 6 && a.kar_id=$kar_id
		")->result_object();
		$data['page']	= "tr_cuti";

		$this->load->view('japanese/index', $data);
	}

	function tambah_trcuti()
	{
		$nik  = $this->session->userdata('nik');
		$auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik);
		$objek['auto']	= $auto;

		$objek['title'] ='List Transaksi';
		$objek['page']	= "trcuti_tambah";
		
		$this->load->view('japanese/index', $objek);
	}

	function insert_trcuti()
	{
		$data = $this->input->post();
		$this->db->insert('tr_permohonan_cuti', $data);

		redirect('japanese/tr_cuti');
	}

	function edit_trcuti($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['page']		= "tr_cuti_edit";

		$this->load->view('japanese/index', $objek);
	}

	function update_trcuti($id)
	{
		$objek['data']		= $this->db->query("SELECT a.*,b.* 
								FROM m_karyawan a
								INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
								")->result_object();
		$data = [
			'pc_tanggalfrom' 	=> $this->input->post('pc_tanggalfrom'),
			'pc_tanggalto'		=> $this->input->post('pc_tanggalto'),
			'pc_lamacuti'		=> $this->input->post('pc_lamacuti'),
			'pc_keterangan'		=> $this->input->post('pc_keterangan'),
		];
		$this->db->where('pc_id', $id);
		$this->db->update('tr_permohonan_cuti', $data);

		redirect('japanese/tr_cuti');
	}

	function hapus_trcuti($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('japanese/tr_cuti');
    }
    
//----------------------------------------------APPROVAL_CUTI
	function approval()
	{	
		$team_id   = $this->session->userdata('team_id');
		$plant_id   = $this->session->userdata('plant_id');
		$akses_id = $this->session->userdata('akses');
		$kar_id = $this->session->userdata('id');

		$objek['title']	='List Cuti Belum Approve';
		$objek['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
			FROM tr_permohonan_cuti a
			INNER JOIN m_karyawan b ON a.kar_id=b.kar_id
			INNER JOIN m_plant c ON b.plant_id=c.plant_id
			INNER JOIN m_user_akses d ON a.akses_id=d.akses_id
			WHERE (a.pc_status=6 && b.akses_id<=$akses_id && b.team_id=$team_id)
			")->result_object();
		$objek['page']	= "approval_cuti";
		
		$this->load->view('japanese/index', $objek);
	}
	function history_approval()
	{	
		$akses_id   = $this->session->userdata('akses');

		$objek['title']	='List Cuti Sudah Approve';
		$objek['data']	= $this->db->query("SELECT a.*,b.* 
			FROM m_karyawan a 
			INNER JOIN m_user_akses b on a.akses_id=b.akses_id 
			WHERE a.akses_id = 4")->result_object();
		$objek['page']	= "history_approval";
		
		$this->load->view('japanese/index', $objek);
	}

	
//----------------------------------------------TRANSAKSI CUTI PANJANG
	function tr_cuti_panjang()
	{
		$kar_id  = $this->session->userdata('id');

		$data['title'] 	= 'List Transaksi Cuti Panjang';
		$data['data']	= $this->db->query("SELECT a.*,b.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
							WHERE pc_kode LIKE 'CP%' && a.kar_id=$kar_id
							")->result_object();
		$data['page']	= "tr_cuti_panjang";

		$this->load->view('japanese/index', $data);
	}


	function tambah_trcuti_panjang()
	{
		$nik  = $this->session->userdata('nik');

		$objek['title']='List Trasaksi Cuti';
		$objek['auto']	= $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CP',$nik);
		$objek['page']	= "trcuti_panjang_tambah";
		
		$this->load->view('japanese/index', $objek);
	}

	function insert_trcuti_panjang()
	{
		$data = $this->input->post();
		$this->db->insert('tr_permohonan_cuti', $data);	
		
		redirect('japanese/tr_cuti');
	}

	function edit_trcuti_panjang($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['data']		= $this->db->query("SELECT a.*,b.* 
								FROM m_karyawan a
								INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
								")->result_object();
		$objek['page']		= "tr_cutipanjang_edit";

		$this->load->view('japanese/index', $objek);
	}

	function update_trcuti_panjang($id)
	{
		$objek['data']		= $this->db->query("SELECT a.*,b.* 
								FROM m_karyawan a
								INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
								")->result_object();
		$data = [
			'pc_tanggalfrom' 	=> $this->input->post('pc_panjang_tanggalfrom'),
			'pc_tanggalto'		=> $this->input->post('pc_panjang_tanggalto'),
			'pc_lamacuti'		=> $this->input->post('pc_panjang_lamacuti'),
			'pc_keterangan'		=> $this->input->post('pc_panjang_keterangan'),
		];
		$this->db->where('pc_id', $id);
		$this->db->update('tr_permohonan_cuti', $data);

		redirect('admin/tr_cuti');
	}

//----------------------------------------------HISTORY PENGAMBILAN CUTI
	function history_pengambilan_cuti(){
		$kar_id  = $this->session->userdata('id');

		$a['title']='History Pengambilan Cuti';
		$a['data']	= $this->db->query("SELECT a.*,b.*,c.*
										FROM m_karyawan a
										INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
										INNER JOIN m_status c ON b.pc_status=c.status_id
										WHERE (pc_status = 7 && a.kar_id=$kar_id) || (pc_status = 4 && a.kar_id=$kar_id)
										")->result_object();
		$a['page']	= "history_pengambilan_cuti";
		
		$this->load->view('japanese/index', $a);
	}

//----------------------------------------------REKAP SISA CUTI

	function rekap_sisa_cuti(){
		$plant_id   = $this->session->userdata('plant_id');
		$akses_id = $this->session->userdata('akses');

		$a['title'] ='Rekap Sisa Cuti';
		$a['data']	=  $this->db->get_where('m_karyawan', array('plant_id' => $plant_id))->result_object();
		$a['page']	= "rekap_sisa_cuti";
		
		$this->load->view('japanese/index', $a);
	}

//----------------------------------------------DETAIL REKAP SISA CUTI

	function detail_rekap_sisa_cuti($id){

		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
			FROM tr_permohonan_cuti a
			INNER JOIN m_karyawan b on a.kar_id=b.kar_id
			INNER JOIN m_status c on a.pc_status=c.status_kode
			WHERE a.kar_id=$id
		")->result_object();
		$data['page']	= "detail_rekap_sisa_cuti";

		$this->load->view('japanese/index', $data);
	}

//---------------------------------------------- DETAIL HISTORY APPROVAL

	function detail_history_approval($id){

		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
						FROM m_karyawan a
						INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
						INNER JOIN m_status c on b.pc_status=c.status_kode
						WHERE a.kar_id=$id
		")->result_object();
		$data['page']	= "detail_history_approval";

		$this->load->view('japanese/index', $data);
	}

//----------------------------------------------APPROVE TRANSAKSI CUTI
	function approve_trcuti($id)
	{	
		$team_id= $this->session->userdata('team_id');
		$kar_id= $this->session->userdata('id');

		//proses validasi sisa cuti
		$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$id'")->row();
		$row2=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

		$jmlct=$row1->pc_lamacuti; //Jumlah Cuti

		$totalctambil=$row2->cuti_diambil + $jmlct; //echo $totalctambil; 1

		$totalsisacuti=$row2->jatah_cuti - $row2->cuti_diambil - $jmlct;

		$sukses=$this->db->query("UPDATE m_cuti_perkaryawan SET cuti_diambil='$totalctambil', sisa_cuti='$totalsisacuti' WHERE kar_id='$row1->kar_id'"); 
		if($sukses){	
			$nama=$this->session->userdata('user');
			$dateapp=date('Y-m-d H:i:s');
			$data=array(
				'pc_approvedby'			=> $nama,
				'pc_dateapproved'		=> $dateapp,
				'pc_sisacuti'			=> $totalsisacuti,
				'pc_jumlahcutidiambil'	=> $totalctambil,
				'pc_status'				=> 7
			);

			if(count($data) > 0){
				$this->db->where('pc_id', $id);
				$this->db->update('tr_permohonan_cuti', $data);

				$this->load->model('M_email_blast', 'M_email_blast');

				//Query untuk ambil data user yang mengapprove cuti
				$email_data = $this->db->query("SELECT m_karyawan.kar_nama, m_karyawan.kar_nik, m_departement.dep_nama, m_karyawan.kar_id, m_karyawan.kar_email
								FROM m_karyawan
								INNER JOIN m_departement
								ON m_karyawan.dep_id=m_departement.dep_id
								WHERE m_karyawan.team_id = $team_id && m_karyawan.kar_id= $row1->kar_id");

					// $return 	= array();
					if($email_data->num_rows() > 0){
						$result_email = $email_data->result();

						foreach($result_email as $value_email){
								$param = array();
								$param['email'] 	  = $value_email->kar_email;  //"ihidayat155@gmail.com"; //Email to Proposer
								$param['id'] 		  = $this->session->userdata('id');  
								$param['kar_id'] 	  = $value_email->kar_id;
								$param['nama'] 		  = $value_email->kar_nama;
								$param['pin'] 		  = $value_email->kar_nik;
								$param['plant'] 	  = $value_email->dep_nama;
								$param['approved_by'] = $this->session->userdata('user');
								$this->M_email_blast->notif_after_approval_to_user( $param );	//Kirim parameter data ke model
						}
					}
				echo "<script>alert('Approve Cuti Success !!!'); 
				location.replace('".base_url('japanese/approval')."');
				</script>";
			}else{
				echo "Approve Failed !";
			}
		}
	}

//----------------------------------------------REJECT TRANSAKSI CUTI

	function reject_trcuti () {

	$nama=$this->session->userdata('user');
	$pc_keterangan_ditolak = $this->input->post('note'); //post('note') dapet dari parameter di Jquery yg di approval cuti
	$pc_id = $this->input->post('pc_id');

	$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$pc_id'")->row();
	$rowmCuti=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

	$totalsisacuti=$rowmCuti->jatah_cuti - $rowmCuti->cuti_diambil;

	$dateapp=date('Y-m-d H:i:s');
	$data=array(
		'pc_approvedby'	 		=> $nama,
		'pc_dateapproved'		=> $dateapp,
		'pc_sisacuti'	 		=> $totalsisacuti,
		'pc_keterangan_ditolak'	=> $pc_keterangan_ditolak,
		'pc_status'		 		=> 4
	);
	$this->db->where('pc_id', $pc_id);
	$this->db->update('tr_permohonan_cuti', $data);
	
	// echo "<script>alert('Reject Cuti Success !!!'); 
	// 	location.replace('".base_url('japanese/approval')."');
	// 	</script>";
	// echo "<script>alert('Not Approve Cuti Success !!!')</script>";
	// redirect('admin/approval','refresh');

}

//----------------------------------------------UNTUK AUTONUMB KODE CUTI DI PERMOHONAN CUTI
function getCutiCode($id,$cuti_kode)
{
	$get_kar= $this->db->get_where('m_karyawan',array('kar_id'=>$id))->row();	
	$nik=$get_kar->kar_nik;
	
	$autonumb=$this->model_admin->autonumbSt("tr_permohonan_cuti","pc_kode","P".$cuti_kode.$nik."",$id);//untuk autonumb
	echo $autonumb;
}

}

