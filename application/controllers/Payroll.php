<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll extends CI_Controller
{

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

	public function index()
	{
		$objek['sum_1'] = $this->model_admin->count('m_karyawan');
		$objek['sum_2'] = $this->model_admin->Summary('m_karyawan');
		$objek['sum_3'] = $this->model_admin->Summary('tr_permohonan_cuti');
		// $objek['sum_4'] = $this->model_admin->Summary('m_item');
		$objek['title'] = 'Dashboard';
		$objek['page'] = 'home';
		$this->load->view('admin/index', $objek);
	}
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if ($this->session->userdata('status') == '') {
			redirect('login/form');
		}
	}
	public function profile()
	{
		$objek['title'] = 'MyProfile';
		$objek['page'] = 'profile';
		$this->load->view('admin/index', $objek);
	}
	public function ganti_foto($id)
	{
		$objek['title'] = 'Ganti Foto Profile';
		$objek['editdata']	= $this->db->get_where('m_user', array('user_id' => $id))->result_object();
		$objek['page'] = 'profile_gantifoto';
		$this->load->view('admin/index', $objek);
	}
	function edit_fotoadmin($id)
	{
		$objek['title'] = 'Edit Foto Admin';
		$objek['editdata']	= $this->db->get_where('m_admin', array('adm_id' => $id))->result_object();
		$objek['page']	= "admin_editfoto";

		$this->load->view('admin/index', $objek);
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
			redirect('admin/ganti_foto/' . $id, 'refresh');
		} else {
			$user_foto = $this->upload->data('file_name');
			$this->db->query("update m_user set user_foto='$user_foto' where user_id='$id'");

			redirect('admin/user', 'refresh');
		}
	}
//----------------------------------------------KARYAWAN
	function karyawan()
	{
		$objek['title']	= 'List Karyawan';
		$objek['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN m_jabatan b ON a.jab_id=b.jab_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							LEFT JOIN  m_plant d ON a.plant_id=d.plant_id
							")->result_object();
		$objek['page']	= "karyawan";

		$this->load->view('admin/index', $objek);
	}
	function tambah_karyawan()
	{
		$objek['title']	= 'Tambah Karyawan';
		$objek['page']	= "karyawan_tambah";

		$this->load->view('admin/index', $objek);
	}
	function insert_karyawan()
	{
		$data = $this->input->post();
		$this->db->insert('m_karyawan', $data);
		redirect('admin/karyawan');
	}
	function edit_karyawan($id)
	{
		$objek['title'] = 'Edit Karyawan';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']	= "karyawan_edit";

		$this->load->view('admin/index', $objek);
	}
	function update_karyawan($id)
	{
		$data = $this->input->post();
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data);

		redirect('admin/karyawan');
	}
	function hapus_karyawan($id)
	{
		$this->model_admin->DeleteData('m_karyawan', 'kar_id', $id);
		redirect('admin/karyawan');
	}
	function aktif_karyawan($id)
	{
		$data = array('is_active' => 1);
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data);

		redirect('admin/karyawan', 'refresh');
	}
	function nonaktif_karyawan($id)
	{
		$data = array('is_active' => 0);
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data);

		redirect('admin/karyawan', 'refresh');
	}
	function aktif_all_karyawan()
	{
		$this->db->query("update m_karyawan set is_active=1");

		redirect('admin/karyawan', 'refresh');
	}
	function nonaktif_all_karyawan()
	{
		$this->db->query("update m_karyawan set is_active=0");

		redirect('admin/karyawan', 'refresh');
	}


//----------------------------------------------PLANT
	function plant()
	{

		$objek['title']	= 'List Plant';
		$objek['data']	= $this->model_admin->GetAllData('m_plant')->result_object();
		$objek['page']	= "plant";

		$this->load->view('admin/index', $objek);
	}

	function tambah_plant()
	{
		$objek['title']	= 'Tambah Plant';
		$objek['page']	= "plant_tambah";

		$this->load->view('admin/index', $objek);
	}

	function insert_plant()
	{
		$data = $this->input->post();
		$this->db->insert('m_plant', $data);
		redirect('admin/plant');
	}

	function edit_plant($id)
	{
		$objek['title'] = 'Edit Plant';
		$objek['editdata']	= $this->db->get_where('m_plant', array('plant_id' => $id))->result_object();
		$objek['page']	= "plant_edit";

		$this->load->view('admin/index', $objek);
	}
	function update_plant($id)
	{
		$data = $this->input->post();
		$this->db->where('plant_id', $id);
		$this->db->update('m_plant', $data);

		redirect('admin/plant');
	}

	function hapus_plant($id)
	{
		$this->model_admin->DeleteData('m_plant', 'plant_id', $id);
		redirect('admin/plant');
	}

//----------------------------------------------JABATAN
	function jabatan()
	{

		$objek['title']	= 'List Jabatan';
		$objek['data']	= $this->model_admin->GetAllData('m_jabatan')->result_object();
		$objek['page']	= "jabatan";

		$this->load->view('admin/index', $objek);
	}

	function tambah_jabatan()
	{
		$objek['title']	= 'Tambah Jabatan';
		$objek['page']	= "jabatan_tambah";

		$this->load->view('admin/index', $objek);
	}

	function insert_jabatan()
	{
		$data = $this->input->post();
		$this->db->insert('m_jabatan', $data);
		redirect('admin/jabatan');
	}

	function edit_jabatan($id)
	{
		$objek['title'] = 'Edit Jabatan';
		$objek['editdata']	= $this->db->get_where('m_jabatan', array('jab_id' => $id))->result_object();
		$objek['page']	= "jabatan_edit";

		$this->load->view('admin/index', $objek);
	}
	function update_jabatan($id)
	{
		$data = $this->input->post();
		$this->db->where('jab_id', $id);
		$this->db->update('m_jabatan', $data);

		redirect('admin/jabatan');
	}

	function hapus_jabatan($id)
	{
		$this->model_admin->DeleteData('m_jabatan', 'jab_id', $id);
		redirect('admin/jabatan');
	}

//----------------------------------------------STANDAR CUTI

	function standar_cuti()
	{
		$objek['title'] = 'List Standar Cuti';
		$objek['data'] = $this->model_admin->GetAllData('m_harga_cuti')->result_object();
		$objek['page'] = 'standar_cuti';

		$this->load->view('admin/index', $objek);
	}

	function tambah_standar_cuti()
	{
		$objek['title']	= 'Tambah Standar Cuti';
		$objek['page']	= 'standar_cuti_tambah';

		$this->load->view('admin/index', $objek);
	}
	function insert_standar_cuti()
	{
		$data = $this->input->post();
		$this->db->insert('m_harga_cuti', $data);

		redirect('admin/standar_cuti');
	}

	function edit_standar_cuti($id)
	{
		$objek['title']	= 'Edit Standar Cuti';
		$objek['editdata']	= $this->db->get_where('m_harga_cuti', array('har_cuti_id' => $id))->result_object();
		$objek['page']	= 'standar_cuti_edit';

		$this->load->view('admin/index', $objek);
	}

	function update_standar_cuti($id)
	{
		$data = $this->input->post();

		$this->db->where('har_cuti_id', $id);
		$this->db->update('m_harga_cuti', $data);

		redirect('admin/standar_cuti');
	}

	function hapus_standar_cuti($id)
	{
		$this->model_admin->DeleteData('m_harga_cuti', 'har_cuti_id', $id);
		redirect('admin/standar_cuti');
	}

//----------------------------------------------USER
	function user()
	{

		$objek['title']	 = 'List User';
		$objek['data']	 = $this->db->query("SELECT a.*,b.* 
							FROM m_karyawan a 
							INNER JOIN m_user_akses b on a.akses_id=b.akses_id 
							WHERE a.akses_id > 1")->result_object();
		$objek['page']	 = "user";


		$this->load->view('admin/index', $objek);
	}
	function tambah_user()
	{
		$objek['title'] = 'Tambah User';
		$objek['page']	= "user_tambah";

		$this->load->view('admin/index', $objek);
	}

	function insert_user()
	{
		$config = array(
			'upload_path' => 'fotoprofile',
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => 5000000,
			'overwrite' => true
		);
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('user_foto')) {
			var_dump($this->upload->display_errors());
			redirect('admin/tambah_user');
		} else {
			$user_nama 			= $this->input->post('user_nama');
			$user_nik 			= $this->input->post('user_pin');
			$user_username 		= $this->input->post('user_username');
			$user_password 		= $this->input->post('user_password');
			$user_foto 			= $this->upload->data('file_name');
			$user_akses 		= $this->input->post('akses_id');
			$data 				= array(
				'kar_nama' 			=> $user_nama,
				'kar_nik' 			=> $user_nik,
				'kar_username' 		=> $user_username,
				'kar_password' 		=> $user_password,
				'kar_foto' 			=> $user_foto,
				'akses_id' 			=> $user_akses
			);

			$this->db->insert('m_karyawan', $data);

			redirect('admin/user', 'refresh');
		}
	}
	function edit_user($id)
	{
		$objek['title'] 	= 'Edit User';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']		= "user_edit";

		$this->load->view('admin/index', $objek);
	}
	function update_user($id)
	{
		$data = $this->input->post();
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data);

		redirect('admin/user', 'refresh');
	}
	function hapus_user($id)
	{

		$this->model_admin->DeleteData('m_karyawan', 'kar_id', $id);
		redirect('admin/user');
	}


//----------------------------------------------TRANSAKSI CUTI TAHUNAN
	function tr_cuti()
	{
		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
							WHERE pc_kode LIKE 'CT%'
							")->result_object();
		$data['page']	= "tr_cuti";

		$this->load->view('admin/index', $data);
	}

	function tambah_trcuti()
	{
		$nik  = $this->session->userdata('nik');
		$auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik);
		$objek['auto']	= $auto;

		$objek['title'] ='List Transaksi';
		$objek['page']	= "trcuti_tambah";
		
		$this->load->view('admin/index', $objek);
	}

	function insert_trcuti()
	{
		$data = $this->input->post();
		$this->db->insert('tr_permohonan_cuti', $data);

		redirect('admin/tr_cuti');
	}

	function edit_trcuti($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['page']		= "tr_cuti_edit";

		$this->load->view('admin/index', $objek);
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

		redirect('admin/tr_cuti');
	}

	function hapus_trcuti($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('admin/tr_cuti');
	}



//----------------------------------------------TRANSAKSI CUTI PANJANG
	function tr_cuti_panjang()
	{
		$data['title'] 	= 'List Transaksi Cuti Panjang';
		$data['data']	= $this->db->query("SELECT a.*,b.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
							WHERE pc_kode LIKE 'CP%'
							")->result_object();
		$data['page']	= "tr_cuti_panjang";

		$this->load->view('admin/index', $data);
	}


	function tambah_trcuti_panjang()
	{	
		$nik  = $this->session->userdata('nik');

		$objek['title']='List Trasaksi Cuti';
		$objek['auto']	= $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CP',$nik);
		$objek['page']	= "trcuti_panjang_tambah";
		
		$this->load->view('admin/index', $objek);
	}

	function insert_trcuti_panjang()
	{
		$data = $this->input->post();
		$this->db->insert('tr_permohonan_cuti', $data);	
		
		redirect('admin/tr_cuti');
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

		$this->load->view('admin/index', $objek);
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


//----------------------------------------------APPROVAL_CUTI
	function approval()
	{	
		$objek['title']	='List Cuti Belum Approve';
		$objek['data']	= $this->db->query("SELECT a.*,b.*
							FROM tr_permohonan_cuti a
							INNER JOIN m_karyawan b ON a.kar_id=b.kar_id
							WHERE a.pc_status='Menunggu Konfirmasi'
							")->result_object();
		$objek['page']	= "approval_cuti";
		
		$this->load->view('admin/index', $objek);
	}
	function history_approval()
	{	
		$objek['title']	='List Cuti Sudah Approve';
		$objek['data']	= $this->db->query("SELECT a.*,b.*
							FROM tr_permohonan_cuti a
							INNER JOIN m_karyawan b ON a.kar_id=b.kar_id
							WHERE a.pc_status='Disetujui'
							")->result_object();
		$objek['page']	= "history_approval";
		
		$this->load->view('admin/index', $objek);
	}

	function approval_tambah()
	{
		//proses validasi sisa cuti
		/*$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$id'")->row();
		$row2=$this->db->query("SELECT * FROM m_cuti WHERE kar_id='$row1->kar_id'")->row();
		
		$jmlct=$row1->pc_lamacuti;//echo $jmlct;
		$totalctambil=$row2->cuti_diambil + $jmlct;//echo $totalctambil;
		$totalsisacuti=$row2->cuti_jatahcuti-$row2->cuti_diambil-$jmlct;echo $row2->cuti_jatahcuti." ".$row2->cuti_diambil." ".$totalsisacuti;
		$sukses=$this->db->query("UPDATE m_cuti SET cuti_diambil='$totalctambil',cuti_sisacuti='$totalsisacuti' WHERE kar_id='$row1->kar_id'"); 
		if($sukses){*/
			$nama=$this->session->userdata('user');
			
			$dateapp=date('Y-m-d H:i:s');
			$data= [
				'pc_approvedby'		=> $nama,
				'pc_dateapproved'	=> $dateapp,
				'pc_sisacuti'		=> 12,
				'pc_status'			=> 'Disetujui'
				];
			
			$this->db->where('pc_id', $id);
			$this->db->update('tr_permohonan_cuti', $data);
			echo "<script>alert('Approve Success..')</script>";
			
		//}
		redirect('admin/approval','refresh');
	}


//----------------------------------------------TRANSAKSI_REQUEST
function rekap_sisa_cuti(){
	$a['title']='Rekap Sisa Cuti';
	$a['data']	= $this->db->query("SELECT a.*,b.* 
									FROM m_karyawan a
									INNER JOIN m_departement b ON a.dep_id=b.dep_id
									")->result_object();
	$a['page']	= "rekap_sisa_cuti";
	
	$this->load->view('admin/index', $a);
}



//----------------------------------------------DETAIL REKAP SISA CUTI

function detail_rekap_sisa_cuti($id){

	$data['title'] 	= 'List Transaksi Cuti Tahunan';
	$data['data']	= $this->db->query("SELECT a.*,b.*
					FROM m_karyawan a
					INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
					WHERE a.kar_id=$id
	")->result_object();
	$data['page']	= "detail_rekap_sisa_cuti";

	$this->load->view('leader_up/index', $data);
}






	function hapus_transaksi($id)
	{
		$this->model_admin->DeleteData('req_detail', 'reqdet_id', $id);
		redirect('admin/tambah_transaksi', 'refresh');
	}
	function hapus_header($id)
	{
		$this->model_admin->DeleteData('req_header', 'reqhed_code', $id);
		$this->model_admin->DeleteData('req_detail', 'reqhed_code', $id);
		redirect('admin/transaksi', 'refresh');
	}
	function reset_transkaryawan($code)
	{
		$session = array('kar_id', 'section', 'position');
		$this->session->unset_userdata($session);
		$this->model_admin->DeleteData('req_detail', 'reqhed_code', $code);

		redirect('admin/tambah_transaksi');
	}
}
