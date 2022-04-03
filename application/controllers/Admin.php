<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		$this->load->library('excel');
		if ($this->session->userdata('status') == '') {
			redirect('login/form');
		}
		if($this->session->level != 6) {
			echo "<script>alert('Anda Tidak Punya Akses Untuk Login Sebagai Admin !!! Silahkan LOGIN kembali ke akun anda'); 
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
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $id))->row();
		$row_jatah_CT_ok = $this->db->get_where('v_jatah_CT_perkaryawan_OK', array('kar_id' => $id))->row(); //jatah cuti tahunan - cuti bersama
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $id))->row();

		$sisa_CP_p1 = $row_jatah_CP->total - $row_potong_CP->total - 5; //rumus periode 1
		if($sisa_CP_p1 < 0) $sisa_CP_p1 = 0;

		$sisa_CP_p2 = $row_jatah_CP->total - $row_potong_CP->total; //rumus periode 2
		if($sisa_CP_p2 > 5) $sisa_CP_p2 = 5;

		$objek['kar_id'] = $id;
		$objek['jml_CP'] = $row_jatah_CP->total;
		$objek['jml_CT'] = $row_jatah_CT->total;
		$objek['jml_CB'] = $get_CB->penambahan_cuti_cutibersama;
		$objek['sisa_CT_tahun_lalu'] = $get_CB->sisa_cuti_tahun_sebelumnya;
		$objek['jml_CT_sisa'] = $row_jatah_CT_ok->total - $row_potong_CT->total;
		$objek['jml_CT_sisa2'] = $row_jatah_CT->total  - $row_potong_CT->total; //Aktifkan script berikut kalo CB SUDAH d Open
		$objek['jml_CP_sisa_p1'] = $sisa_CP_p1;
		$objek['jml_CP_sisa_p2'] = $sisa_CP_p2;
		$objek['title'] = 'Dashboard';
		// $objek['page'] = 'v_blank';
		$objek['page'] = 'home';
        $this->load->view('admin/index', $objek);
        $dep_nama  = $this->session->userdata('nik');
	}

//----------------------------------------------PAGE UNTUK UPLOAD KARYAWAN

	public function upload() {
		$data['title']='Upload Data Karyawan';
		$data['subtitle'] = 'Upload Data Karyawan';
		$data['page']='v_karyawan_upload';
		$this->load->view('admin/index',$data);
    }
	
//----------------------------------------------TRANSAKSI UNTUK UPLOAD KARYAWAN

	public function import() {

		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{

					// $id_karyawan = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$nik				= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$kar_username		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$kar_password		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$kar_nama			= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$jab_id				= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$dep_id				= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$kar_email			= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$kar_tanggalmasuk	= $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$kar_jeniskelamin	= $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$plant_id			= $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$akses_id			= $worksheet->getCellByColumnAndRow(11, $row)->getValue();

					$year 				= explode("/",$kar_tanggalmasuk)[2];// dd/mm/yyyy
                    $month 				= explode("/",$kar_tanggalmasuk)[1];
                    $day 				= explode("/",$kar_tanggalmasuk)[0];

					
										
					// $query		= $this->db->get_where('m_karyawan', array('kar_nik'=>$nik, 'kar_nama'=>$kar_nama));
					// $countdata  = $query->num_rows(); 
					// $rowdata 	= $query->row(); 
					// if($countdata > 0){
						$data[] = array(
							'kar_id'			=>	$rowdata->kar_id,
							'kar_nik'			=>	$nik,
							'kar_username'		=>	$kar_username,
							'kar_password'		=>	$kar_password,
							'kar_nama'			=>	$kar_nama,
							'jab_id'			=>	$jab_id,
							'dep_id'			=>	$dep_id,
							'kar_email'			=>	$kar_email,
							'kar_tanggalmasuk'	=>	$year."-".$month."-".$day,
							'kar_jeniskelamin'	=>	$kar_jeniskelamin,
							'plant_id'			=>	$plant_id,
							'akses_id'			=>	$akses_id
						);
				}
			}

			// echo $highestRow;
			// echo json_encode($data);
			if(count($data) > 0){
				$this->db->empty_table('m_karyawan');
				$this->db->insert_batch('m_karyawan',$data);
				echo 'IMPORT DATA SUCCESS !!!';
				$coun = count($data_error['nik']);
				for($i=0 ; $i<$coun ; $i++){
					echo $data_error['nama'][$i].',';
				}
			}else{
				echo 'Data Imported Failed';
			}
			
		}	
	}

//----------------------------------------------PAGE UNTUK UPLOAD JATAH CUTI TAHUNAN

	public function upload_jatah_cuti() {
		$data['title']='Upload Jatah Cuti Karyawan';
		$data['subtitle'] = 'Upload Jatah Cuti Karyawan';
		$data['page']='v_jatah_cuti_upload';
		$this->load->view('admin/index',$data);
	}
//----------------------------------------------PAGE UNTUK UPLOAD JATAH CUTI PANJANG

	public function upload_jatah_cuti_panjang() {
		$data['title']='Upload Jatah Cuti Karyawan';
		$data['subtitle'] = 'Upload Jatah Cuti Karyawan';
		$data['page']='v_jatah_cuti_panjang_upload';
		$this->load->view('admin/index',$data);
	}
	
//----------------------------------------------TRANSAKSI UNTUK UPLOAD JATAH CUTI TAHUNAN 

	public function import_jatah_cuti() {
		$this->db->trans_begin();
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{

					$kar_id						= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$jatah_cuti					= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$cuti_diambil				= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$sisa_cuti					= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$cuti_id					= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$tahun						= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$cutibersama				= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$sisa_cuti_tahun_sebelumnya	= $worksheet->getCellByColumnAndRow(8, $row)->getValue();

					$data[] = array(
						'kar_id'				=>	$kar_id,
						'jatah_cuti'			=>	$jatah_cuti,
						'cuti_diambil'			=>	$cuti_diambil,
						'sisa_cuti'				=>	$sisa_cuti
					);
					$data2[] = array(
						'kar_id'					=>	$kar_id,
						'cuti_id'					=>	$cuti_id,
						'penambahan_cuti_tahun'		=>	$tahun,
						'penambahan_cuti_jatahcuti' =>	$jatah_cuti,
						'penambahan_cuti_cutibersama'=>	$cutibersama,
						'sisa_cuti_tahun_sebelumnya'=>	$sisa_cuti_tahun_sebelumnya
					);
				}
				if(count($data) > 0){
					$this->db->empty_table('m_cuti_perkaryawan');
					$this->db->insert_batch('m_cuti_perkaryawan',$data);
					// echo 'IMPORT DATA JATAH CUTI SUCCESS !!!';
					
				}else{
					echo 'IMPORT DATA JATAH CUTI FAILED !!!';
				}
				$this->db->insert_batch('tr_penambahancuti' , $data2); // insert to tr_penambahan_cuti
			}

			// // echo $highestRow;
			// //echo json_encode($data);
			
		}
		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
			echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!!'); 
			location.replace('".base_url('admin/tambah_cuti_tahunan')."');
			</script>";
			// echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!')</script>";
			// redirect('admin/tambah_cuti_tahunan', 'refresh');
		} else {
			$this->db->trans_commit();
			echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!!'); 
			location.replace('".base_url('admin/tambah_cuti_tahunan')."');
			</script>";
			// echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!')</script>";
			// redirect('admin/tambah_cuti_tahunan', 'refresh');
		}
	}
//----------------------------------------------TRANSAKSI UNTUK UPLOAD JATAH CUTI PANJANG 

	public function import_jatah_cuti_panjang() {
		$this->db->trans_begin();
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{

					$kar_id			= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$jatah_cuti		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$cuti_diambil	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$sisa_cuti		= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$cuti_id		= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$tahun			= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$cutibersama	= $worksheet->getCellByColumnAndRow(7, $row)->getValue();

					$data[] = array(
						'kar_id'				=>	$kar_id,
						'jatah_cuti'			=>	$jatah_cuti,
						'cuti_diambil'			=>	$cuti_diambil,
						'sisa_cuti'				=>	$sisa_cuti
					);
					$data2[] = array(
						'kar_id'					=>	$kar_id,
						'cuti_id'					=>	$cuti_id,
						'penambahan_cuti_tahun'		=>	$tahun,
						'penambahan_cuti_jatahcuti' =>	$jatah_cuti,
						'penambahan_cuti_cutibersama'=>	$cutibersama
					);
				}
				$cek_count_kar = $this->db->get_where('m_cuti_perkaryawan', array('kar_id'=>$kar_id))->num_rows();
				if($cek_count_kar > 0){
					$arr_update = array(); //siapkan data array untuk proses update multiple tabel m_cuti_perkaryawan
					$arr_update[ 'kar_id' ] = $kar_id;
					$arr_update[ 'jatah_cuti' ] = $jatah_cuti;
					
					

					$this->db->update_batch( 'm_cuti_perkaryawan', $data, 'kar_id' ); //Update multiple
					// $this->db->query( "UPDATE m_cuti_perkaryawan SET jatah_cuti=jatah_cuti + $jatah_cuti WHERE kar_id='$kar_id'" ); //insert satuan
				}
				$this->db->insert_batch('tr_penambahancuti' , $data2); // insert to tr_penambahan_cuti
			}

			// echo $highestRow;
			//echo json_encode($data);
			
		}
		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
			echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!!'); 
			location.replace('".base_url('admin/tambah_cuti_panjang')."');
			</script>";
			// echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!')</script>";
			// redirect('admin/tambah_cuti_tahunan', 'refresh');
		} else {
			$this->db->trans_commit();
			echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!!'); 
			location.replace('".base_url('admin/tambah_cuti_panjang')."');
			</script>";
			// echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!')</script>";
			// redirect('admin/tambah_cuti_tahunan', 'refresh');
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
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
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
			$this->db->query("update m_karyawan set kar_foto='$user_foto' where kar_id='$id'");
			
			echo "<script>alert('Ganti foto sukses !!!'); 
			location.replace('".base_url('admin')."');
			</script>";
			// redirect('admin', 'refresh');
		}
	}

//----------------------------------------------GANTI PASSWORD
	function ganti_password($id)
	{
		$objek['title'] = 'Ganti Password';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']	= "ganti_password";

		$this->load->view('admin/index', $objek);
	}

	function update_password($id)
	{
		$kar_password = $this->input->post('kar_password');
		$data 	      = array('kar_password' => $kar_password);

		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data);

		echo "<script>alert('Password Berhasil Diubah !!')</script>";
			
		redirect('admin','refresh');
	}


//----------------------------------------------KARYAWAN
	function karyawan()
	{
		$objek['title']	= 'List Karyawan';
		$objek['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*,e.*
			FROM m_karyawan a
			INNER JOIN m_jabatan b ON a.jab_id=b.jab_id
			INNER JOIN m_departement c ON a.dep_id=c.dep_id
			LEFT JOIN  m_plant d ON a.plant_id=d.plant_id
			INNER JOIN m_user_akses e ON a.akses_id=e.akses_id
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
		$this->db->query("UPDATE m_karyawan set is_active=1 where akses_id < 6 && kar_tanggalkeluar = '0000-00-00'");

		redirect('admin/karyawan', 'refresh');
	}
	function nonaktif_all_karyawan()
	{
		$this->db->query("UPDATE m_karyawan set is_active=0 where akses_id < 6");

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

	//----------------------------------------------TRANSAKSI POTONG CUTI TAHUNAN MASSAL

	function getCutiCode($id,$cuti_kode) //----------------------------------------------UNTUK AUTONUMB KODE CUTI DI PERMOHONAN CUTI
	{
		$get_kar= $this->db->get_where('m_karyawan',array('kar_id'=>$id))->row();	
		$nik=$get_kar->kar_nik;
		
		$autonumb=$this->model_admin->autonumb_pc('tr_permohonan_cuti','pc_kode','PC',$id);
		// $this->model_admin->autonumbSt("tr_permohonan_cuti","pc_kode","P".$cuti_kode.$nik."",$id);//untuk autonumb
		echo $autonumb;
	}

	//----------------------------------------------STATUS CUTI MASSAL
	function status_cuti_massal()
	{
		$plant_id  = $this->session->userdata('plant_id');
		$data['title'] 	= 'Status Pengajuan Cuti Massal';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
						FROM m_karyawan a
						INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
						INNER JOIN m_status c ON b.pc_status=c.status_id
						WHERE pc_status=2  && a.plant_id=$plant_id && b.pc_kode LIKE '%CM%'
		")->result_object();
		$data['page']	= "status_cuti_massal";

		$this->load->view('admin/index', $data);
	}

	function potong_cuti_karyawan()
	{
		$kar_id  = $this->session->userdata('id');
		$data['title'] 	= 'Status Pengajuan Cuti';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
						FROM m_karyawan a
						INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
						INNER JOIN m_status c on b.pc_status=c.status_id
						WHERE pc_status = 2 && a.kar_id=$kar_id
		")->result_object();
		$data['page']	= "potong_cuti_karyawan";

		$this->load->view('manager/index', $data);
	}

	function tambah_potong_cuti_karyawan()
	{
		$nik  = $this->session->userdata('nik');
		$auto = $this->model_admin->autonumb('tr_permohonan_cuti','pc_kode','PC');
		$objek['auto']	= $auto;

		$objek['title'] ='Potong Cuti Karyawan';
		$objek['page']	= "v_tambah_potong_cuti_karyawan";
		
		$this->load->view('admin/index', $objek);
	}

	function insert_potong_cuti_karyawan_multiple()
	{

        $row = $this->input->post('kar_id');
		if ( isset( $row ) > 0 ) {
			$dataarray = array();
			foreach ( $row as $key => $value ) {
				$dataTmp = array();
				$dataTmp[ 'kar_id']			= $value;
				$dataTmp[ 'akses_id']		= $this->input->post('akses_id');
				$dataTmp[ 'pc_kode']		= $this->model_admin->autonumb('tr_permohonan_cuti','pc_kode','CM');
				$dataTmp[ 'pc_tanggalfrom'] = $this->input->post('pc_tanggalfrom');
				$dataTmp[ 'pc_tanggalto'] 	= $this->input->post('pc_tanggalto');
				$dataTmp[ 'pc_lamacuti'] 	= $this->input->post('pc_lamacuti');
				$dataTmp[ 'pc_keterangan'] 	= $this->input->post('pc_keterangan');
				$dataTmp[ 'cuti_kode'] 		= $this->input->post('cuti_kode');
				$dataTmp[ 'pc_status'] 		= $this->input->post('pc_status');

				// $dataarray[] = $dataTmp;
				$this->db->insert( 'tr_permohonan_cuti' , $dataTmp); //pakai insert biasa agar data langsung di insert dan pc_kode berubah
			}
			// $this->db->insert_batch( 'tr_permohonan_cuti' , $dataarray); //tidak bisa pakai insert_batch
		}
		redirect('admin/status_cuti_massal','refresh');

	}
	function edit_potong_cuti_karyawan($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['page']		= "potong_cuti_karyawan_edit";

		$this->load->view('manager/index', $objek);
	}

	function update_potong_cuti_karyawan($id)
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

		redirect('manager/tr_cuti');
	}

	function hapus_potong_cuti_karyawan($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('manager/potong_cuti_karyawan');
	}




























	//----------------------------------------------PAGE STATUS CUTI
	function tr_cuti()
	{
		$kar_id  = $this->session->userdata('id');
		
		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
			FROM m_karyawan a
			INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
			INNER JOIN m_status c on b.pc_status=c.status_kode
			WHERE pc_status = 2 && a.kar_id=$kar_id
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
		$kar_id= $this->session->userdata('id');
		$lama_cuti= $this->input->post('pc_lamacuti');
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $kar_id))->row(); //Jatah CT
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $kar_id))->row(); //CT yg sudah dipakai
		$from_date= $this->input->post('pc_tanggalfrom');
		$to_date= $this->input->post('pc_tanggalto');

		$begin = new DateTime($from_date);
		$end = new DateTime($to_date);

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		$cek=0;
		foreach ($period as $dt) {
			$tanggal= $dt->format("Y-m-d");
			$get= $this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_tanggalfrom = '$tanggal' && kar_id='$kar_id' && pc_status != 5 ")->num_rows();

			$cek += $get;
		}
		$get= $this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_tanggalfrom = '$to_date' && kar_id='$kar_id' && pc_status != 5 ")->num_rows();
		$cek += $get;

		//Validasi tanggal pengajuan yang dobel nya
		if($from_date <= '2021-12-31'){
			echo "<script>alert('Maaf, Tidak bisa mengajukan cuti untuk tahun 2021 !');
			location.replace('".base_url('admin/tambah_trcuti')."'); 
			</script>";
		}else{
			if($cek > 0){
				echo "<script>alert('Anda sudah pernah membuat pengajuan di tanggal tersebut !'); 
				</script>";
			}else{
				//Validasi sisa cuti nya
				$sisa_cuti = $row_jatah_CT->total - $row_potong_CT->total ;
				$sisa_cuti_saat_pengajuan = $sisa_cuti - $lama_cuti;
				if($sisa_cuti_saat_pengajuan < 0 ){
					echo "<script>alert('Jumlah cuti yang anda ambil melebihi sisa cuti anda saat ini !'); 
					location.replace('".base_url('admin/tambah_trcuti')."');
					</script>";
				}else{
					$data = $this->input->post();
					$this->db->insert('tr_permohonan_cuti', $data);
					redirect('admin/tr_cuti');
				}
			}	
		}	
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

	// function tambah_cuti_panjang()
	// {
	// 	$data['title'] 	= 'Form Tambah Cuti Tahunan';
	// 	$data['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
	// 						FROM m_karyawan a
	// 						INNER JOIN m_jabatan b ON a.jab_id=b.jab_id
	// 						INNER JOIN m_departement c ON a.dep_id=c.dep_id
	// 						LEFT JOIN  m_plant d ON a.plant_id=d.plant_id
	// 						")->result_object();
	// 	$data['page']	= "tambah_cuti_panjang";

	// 	$this->load->view('admin/index', $data);
	// }


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


//----------------------------------------------PAGE APPROVAL_CUTI & HISTORY APPROVAL
	function approval()
	{	
		$akses_id = $this->session->userdata('akses');

		$objek['title']	='List Cuti Belum Approve';
		$objek['data']	=$this->db->query("SELECT a.*,b.*
			FROM m_karyawan a
			INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
			WHERE (b.pc_status < 3 && b.akses_id = $akses_id) || (b.pc_status = 6)
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

//----------------------------------------------HISTORY PENGAMBILAN CUTI
	function history_pengambilan_cuti(){
		$kar_id  = $this->session->userdata('id');

		$a['title']='History Pengambilan Cuti';
		$a['data']	= $this->db->query("SELECT a.*,b.*,c.*
										FROM m_karyawan a
										INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
										INNER JOIN m_status c ON b.pc_status=c.status_id
										WHERE pc_status > 2 && a.kar_id=$kar_id
										")->result_object();
		$a['page']	= "history_pengambilan_cuti";
		
		$this->load->view('admin/index', $a);
	}

//----------------------------------------------APPROVE TRANSAKSI CUTI
	function approve_trcuti($id)
	{	
		//proses validasi sisa cuti
		$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$id'")->row();
		$row2=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

		$jmlct=$row1->pc_lamacuti; //Jumlah Cuti

		$totalctambil=$row2->cuti_diambil + $jmlct; //echo $totalctambil; 1

		$totalsisacuti=$row2->jatah_cuti - $totalctambil; //$row2->cuti_diambil - $jmlct;

		$sukses=$this->db->query("UPDATE m_cuti_perkaryawan SET cuti_diambil='$totalctambil', sisa_cuti='$totalsisacuti' WHERE kar_id='$row1->kar_id'"); 
		if($sukses){	
			$nama=$this->session->userdata('user');
			$dateapp=date('Y-m-d H:i:s');
			$data=array(
				'pc_approvedby'			=> $nama,
				'pc_dateapproved'		=> $dateapp,
				'pc_sisacuti'			=> $totalsisacuti,
				'pc_jumlahcutidiambil'	=> $totalctambil,
				'pc_status'				=> 3
			);
			$this->db->where('pc_id', $id);
			$this->db->update('tr_permohonan_cuti', $data);
			// $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>APPROVE CUTI BERHASIL!</b> '.$this->upload->display_errors().'</div>');
			echo "<script>alert('Approve Cuti Success !!!'); 
			location.replace('".base_url('admin/approval')."');
			</script>";
			// echo "<script>alert('Approve Cuti Success !!!')</script>";
		}
		// redirect('admin/approval');
	}

//----------------------------------------------REJECT TRANSAKSI CUTI

	function reject_trcuti ($id) {

		$nama=$this->session->userdata('user');

		$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$id'")->row();
		$rowmCuti=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

		$totalsisacuti=$rowmCuti->jatah_cuti - $rowmCuti->cuti_diambil;

		$dateapp=date('Y-m-d H:i:s');
		$data=array(
			'pc_approvedby'	 => $nama,
			'pc_dateapproved'=> $dateapp,
			'pc_sisacuti'	 => $totalsisacuti,
			'pc_status'		 => 4
		);
		$this->db->where('pc_id', $id);
		$this->db->update('tr_permohonan_cuti', $data);
		echo "<script>alert('Not Approve Cuti Success !!!')</script>";
		redirect('admin/approval','refresh');

	}

//----------------------------------------------PAGE CANCEL CUTI
	function cancel_cuti()
	{	
		$objek['title']	='Menu Cancel Cuti';
		$this->db->select('m_karyawan.kar_nik, m_karyawan.kar_id, m_karyawan.kar_nama, m_departement.dep_nama' );
		$this->db->from('m_karyawan','m_departement');
		$this->db->join('m_departement','m_karyawan.dep_id = m_departement.dep_id');
		// $this->db->where('m_karyawan.is_active=1');
		$objek['data']	=$this->db->get()->result_object();
		$objek['page']	= "cancel_cuti";
		
		$this->load->view('admin/index', $objek);
	}

//----------------------------------------------DETAIL REKAP SISA CUTI KARYAWAN

function detail_rekap_cuti_karyawan_cancel_cuti($id){

	$data['title'] 	= 'List Transaksi Cuti Tahunan';
	$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
		FROM tr_permohonan_cuti a
		INNER JOIN m_karyawan b on a.kar_id=b.kar_id
		INNER JOIN m_status c on a.pc_status=c.status_kode
		WHERE (a.pc_status=3 && a.kar_id=$id) || (a.pc_status=4 && a.kar_id=$id)  || (a.pc_status=7 && a.kar_id=$id)
	")->result_object();
	$data['page']	= "detail_rekap_cuti_karyawan_cancel_cuti";

	$this->load->view('admin/index', $data);
}

//----------------------------------------------CANCEL TRANSAKSI CUTI	
	function cancel_trcuti($id)
	{	
		//proses validasi sisa cuti
		$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$id'")->row();
		$row2=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

		$jmlct=$row1->pc_lamacuti; //Jumlah Cuti

		$totalctambil=$row2->cuti_diambil - $jmlct; //echo $totalctambil; 1

		$totalsisacuti=$row2->jatah_cuti - $totalctambil; //$row2->cuti_diambil - $jmlct;

		$sukses=$this->db->query("UPDATE m_cuti_perkaryawan SET cuti_diambil='$totalctambil', sisa_cuti='$totalsisacuti' WHERE kar_id='$row1->kar_id'"); 
		if($sukses){	
			$nama=$this->session->userdata('user');
			$dateapp=date('Y-m-d H:i:s');
			$data=array(
				'pc_approvedby'			=> $nama,
				'pc_dateapproved'		=> $dateapp,
				'pc_sisacuti'			=> $totalsisacuti,
				'pc_jumlahcutidiambil'	=> $totalctambil,
				'pc_status'				=> 5
			);
			$this->db->where('pc_id', $id);
			$this->db->update('tr_permohonan_cuti', $data);
			// $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>APPROVE CUTI BERHASIL!</b> '.$this->upload->display_errors().'</div>');
			echo "<script>alert('CANCEL CUTI SUCCESS !!!'); 
			location.replace('".base_url('admin/detail_rekap_cuti_karyawan_cancel_cuti/'.$row1->kar_id)."');
			</script>";
		}
		// redirect('admin/cancel_cuti','refresh');
	}


//----------------------------------------------REKAP SISA CUTI
	function rekap_sisa_cuti(){
		$a['title']='Rekap Sisa Cuti';

		$this->db->select('a.kar_id, a.kar_nik, a.kar_nama, b.dep_nama');
		$this->db->from('m_karyawan a');
		$this->db->join('m_departement b', 'a.dep_id=b.dep_id');
		$sql = $this->db->get('');
		$a['data'] = $sql->result();
		
		$a['page']	= "rekap_sisa_cuti";		
		$this->load->view('admin/index', $a);
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

		$this->load->view('admin/index', $data);
	}

//----------------------------------------------PAGE TAMBAH JATAH CUTI TAHUNAN
	function tambah_cuti_tahunan()
	{
		$data['title'] 	= 'Form Tambah Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN m_jabatan b ON a.jab_id=b.jab_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							LEFT JOIN  m_plant d ON a.plant_id=d.plant_id
							")->result_object();
		$data['page']	= "tambah_cuti_tahunan";

		$this->load->view('admin/index', $data);
	}

//----------------------------------------------PAGE TAMBAH JATAH CUTI TAHUNAN
	function tambah_cuti_panjang()
	{
		$data['title'] 	= 'Form Tambah Cuti Panjang';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN m_jabatan b ON a.jab_id=b.jab_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							LEFT JOIN  m_plant d ON a.plant_id=d.plant_id
							")->result_object();
		$data['page']	= "tambah_cuti_panjang";

		$this->load->view('admin/index', $data);
	}

//----------------------------------------------TRANSAKSI SIMPAN CUTI TAHUNAN (MULTIPLE)
	function simpan_cuti_tahunan_multiple()
	{
		$this->db->trans_begin();

			$tahun		= $this->input->post('tahun');
			$jumlah		= $this->input->post('jumlah'); //array
			$cuti_id	= $this->input->post('cuti_id');
			$kar_id		= $this->input->post('kar_id');//array
			
			// proses insert ke tr_penambahancuti
			if ( isset( $kar_id ) > 0 ) {

				$arr_insert = array(); //siapin data array untuk proses insert batch ke tabel tr_penambahancuti

				foreach ( $kar_id as $key => $value ) {
					// untuk contoh validasi
					// $row_item = $this->db->get_where('m_items', array('item_code'=>$value))->row();

					$dataTmp = array();
					$dataTmp[ 'kar_id' ] = $value; //array
					$dataTmp[ 'cuti_id' ] = $cuti_id;
					$dataTmp[ 'penambahan_cuti_jatahcuti' ] = $jumlah[$key]; //array
					$dataTmp[ 'penambahan_cuti_tahun' ] = $tahun;

					$arr_insert[] = $dataTmp;
					// $this->db->insert( 'tr_penambahancuti' , $dataTmp ); // jika mau insert satuan

					// proses update/insert cuti perkaryawan
					$cek_count_kar = $this->db->get_where('m_cuti_perkaryawan', array('kar_id'=>$value))->num_rows();
					if($cek_count_kar > 0){
						$this->db->query( "UPDATE m_cuti_perkaryawan SET jatah_cuti=jatah_cuti+$jumlah[$key] WHERE kar_id='$value'" ); // jika mau insert satuan
					}else{
						$arr_insert2 = array(); //siapin data array untuk proses insert multiple ke tabel m_cuti_perkaryawan
						$arr_insert2[ 'kar_id' ] = $value;
						$arr_insert2[ 'jatah_cuti' ] = $jumlah[$key];

						// echo json_encode($arr_insert2);
						$this->db->insert( 'm_cuti_perkaryawan' , $arr_insert2 ); // jika mau insert satuan
					}
				}
				$this->db->insert_batch( 'tr_penambahancuti' , $arr_insert ); // insert multiple ke tr_penambahancuti
			}
		
		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
			echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!!'); 
			location.replace('".base_url('admin/tambah_cuti_tahunan')."');
			</script>";
			// echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!')</script>";
			// redirect('admin/tambah_cuti_tahunan', 'refresh');
		} else {
			$this->db->trans_commit();
			echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!!'); 
			location.replace('".base_url('admin/tambah_cuti_panjang')."');
			</script>";
			// echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!')</script>";
			// redirect('admin/tambah_cuti_tahunan', 'refresh');
		}
	}	

//----------------------------------------------TRANSAKSI SIMPAN CUTI PANJANG (MULTIPLE)
	function simpan_cuti_panjang_multiple()
	{
		$this->db->trans_begin();

			$tahun = $this->input->post('tahun');
			$jumlah = $this->input->post('jumlah'); //array
			$cuti_id = $this->input->post('cuti_id');
			$kar_id = $this->input->post('kar_id');//array
			
			// proses insert ke tr_penambahancuti
			if ( isset( $kar_id ) > 0 ) {

				$arr_insert = array(); // data array untuk proses insert batch

				foreach ( $kar_id as $key => $value ) {
					// untuk contoh validasi
					// $row_item = $this->db->get_where('m_items', array('item_code'=>$value))->row();

					$dataTmp = array();
					$dataTmp[ 'kar_id' ] = $value; //array
					$dataTmp[ 'cuti_id' ] = $cuti_id;
					$dataTmp[ 'penambahan_cuti_jatahcuti' ] = $jumlah[$key]; //array
					$dataTmp[ 'penambahan_cuti_tahun' ] = $tahun;

					$arr_insert[] = $dataTmp;
					// $this->db->insert( 'tr_penambahancuti' , $dataTmp ); // jika mau insert satuan

					// proses update/insert cuti perkaryawan
					$cek_count_kar = $this->db->get_where('m_cuti_perkaryawan', array('kar_id'=>$value))->num_rows();
					if($cek_count_kar > 0){
						$this->db->query( "update m_cuti_perkaryawan set jatah_cuti=jatah_cuti+$jumlah[$key] where kar_id='$value'" ); // jika mau insert satuan
					}else{
						$arr_insert2 = array();
						$arr_insert2[ 'kar_id' ] = $value;
						$arr_insert2[ 'jatah_cuti' ] = $jumlah[$key];
						$this->db->insert( 'm_cuti_perkaryawan' , $arr_insert2 ); // jika mau insert satuan
					}

				}
				$this->db->insert_batch( 'tr_penambahancuti' , $arr_insert ); // jika mau insert multiple
			}
		
		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
			echo "<script>alert('TAMBAH DATA JATAH CUTI FAILED !!')</script>";
			redirect('admin/tambah_cuti_tahunan', 'refresh');
		} else {
			$this->db->trans_commit();
			echo "<script>alert('TAMBAH DATA JATAH CUTI SUCCESS !!')</script>";
			redirect('admin/tambah_cuti_tahunan', 'refresh');
		}
	}	

//----------------------------------------------PAGE REPORT IZIN KELUAR DAILY
	function report_izin_keluar()
	{	
		$objek['title']	='Report Izin Keluar';

		$this->db->select('a.*, b.kar_nik, b.kar_nama, c.dep_nama');
		$this->db->from('tr_izin_keluar a');
		$this->db->join('m_karyawan b', 'a.kar_nik = b.kar_nik');
		$this->db->join('m_departement c', 'b.dep_id = c.dep_id');
		$this->db->where('a.status=',0);
		$result = $this->db->get('');

		$objek['data']	= $result->result();
		$objek['page']	= "izin_keluar/v_report_izin_keluar";		
		$this->load->view('admin/index', $objek);
	}

//----------------------------------------------FILTER REPORT CUTI DAILY
function filter_report_izin_keluar_daily()
{	
	$objek['title']	='Report Izin Keluar';
	$fromdate=$this->input->post('fromdate');
	$todate=$this->input->post('todate');
	
	$objek['fromdate']=$fromdate;
	$objek['todate']=$todate;
	$today=date('Y-m-d');

	$this->db->select('a.*,b.*,c.*');
	$this->db->from('tr_izin_keluar a');
	$this->db->join('m_karyawan b','a.kar_nik=b.kar_nik');
	$this->db->join('m_departement c','b.dep_id=c.dep_id');

	if(isset($fromdate)){
		$this->db->where('DATE(a.date_approved) >=',$fromdate);	
		$this->db->where('DATE(a.date_approved) <=',$todate);				
		$this->db->where_in("status",array(2,3));				
	}	
	
	$this->db->order_by('a.kar_nik', 'desc');
	$result = $this->db->get();
	$objek['data']	= $result->result();
	$objek['page']	= "izin_keluar/v_report_izin_keluar";
	
	$this->load->view('admin/index', $objek);
	
}


//----------------------------------------------PAGE REPORT CUTI DAILY
	function report_cuti_daily()
	{	
		$objek['title']	='List Cuti Sudah Approve';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							WHERE (b.pc_status = 0) || (b.pc_status = 0)
						")->result_object();
		$objek['page']	= "report_cuti_daily";
		
		$this->load->view('admin/index', $objek);
	}
	
//----------------------------------------------PAGE REPORT DETAIL CUTI ALL KARYAWAN
	function report_detail_cuti()
	{	
		$objek['title']	='List Detail Pengajuan Cuti All Karyawan';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							WHERE (b.pc_status = 0) || (b.pc_status = 0) || (b.pc_status = 0) || (b.pc_status = 0)
						")->result_object();
		$objek['page']	= "report_detail_cuti";
		
		$this->load->view('admin/index', $objek);
	}


//----------------------------------------------FILTER REPORT CUTI DAILY
	function filter_report_cuti_daily()
	{	
		
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		
		$objek['fromdate']=$fromdate;
		$objek['todate']=$todate;
		$today=date('Y-m-d');

		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_permohonan_cuti b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','a.dep_id=c.dep_kode');
		$this->db->join('m_status d','b.pc_status=d.status_kode');

		if(isset($fromdate)){
			$this->db->where('DATE(b.pc_dateapproved) >=',$fromdate);	
			$this->db->where('DATE(b.pc_dateapproved) <=',$todate);				
			$this->db->where_in("pc_status",array(7,3));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_cuti_daily";
		
		$this->load->view('admin/index', $objek);
		
	}

	//----------------------------------------------FILTER REPORT CUTI DAILY
	function filter_report_detail_cuti_all()
	{	
		
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		
		$objek['fromdate']=$fromdate;
		$objek['todate']=$todate;
		$today=date('Y-m-d');

		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_permohonan_cuti b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','a.dep_id=c.dep_kode');
		$this->db->join('m_status d','b.pc_status=d.status_kode');

		if(isset($fromdate)){
			$this->db->where('DATE(b.pc_dateapproved) >=',$fromdate);	
			$this->db->where('DATE(b.pc_dateapproved) <=',$todate);				
			$this->db->where_in("pc_status",array(7,3,4,5));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_detail_cuti";
		
		$this->load->view('admin/index', $objek);
		
	}

	//----------------------------------------------EXPORT CUTI DAILY FILTER BY DATE APPROVED
	function export_daily($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Cuti Sudah Approve tanggal '.$tgl. ' sampai '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_permohonan_cuti b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','a.dep_id=c.dep_id');
		$this->db->join('m_status d','b.pc_status=d.status_id');
		// $this->db->join('history_approval_leaderup e','a.pc_id=e.pc_id');
		$this->db->where_in("b.pc_status",array(7,3));
		$this->db->where('DATE(b.pc_dateapproved) >=', $tgl);
		$this->db->where('DATE(b.pc_dateapproved) <=', $tgl2);
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "admin/report/pengajuan_cuti/pengajuan_cuti_export_daily";
		
		$this->load->view($page, $objek);
	}

	//----------------------------------------------EXPORT CUTI DAILY FILTER BY DATE APPROVED
	function export_izin_keluar_daily($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Izin Keluar Sudah Approve tanggal '.$tgl. ' sampai '.$tgl2;
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_izin_keluar b','a.kar_nik=b.kar_nik');
		$this->db->join('m_departement c','a.dep_id=c.dep_id');
		$this->db->where_in("b.status",array(1,2));
		$this->db->where('DATE(b.date_approved) >=', $tgl);
		$this->db->where('DATE(b.date_approved) <=', $tgl2);
		
		$this->db->order_by('a.kar_nik', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "admin/report/izin_keluar/izin_keluar_export_daily";
		
		$this->load->view($page, $objek);
	}

	//----------------------------------------------EXPORT CUTI All Karyawan
	function export_detail_cuti_all($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Pengajuan Cuti tanggal '.$tgl. ' sampai '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_permohonan_cuti b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','a.dep_id=c.dep_id');
		$this->db->join('m_status d','b.pc_status=d.status_id');
		// $this->db->join('history_approval_leaderup e','a.pc_id=e.pc_id');
		$this->db->where_in("b.pc_status",array(7,3,4,5));
		$this->db->where('DATE(b.pc_dateapproved) >=', $tgl);
		$this->db->where('DATE(b.pc_dateapproved) <=', $tgl2);
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "admin/report/pengajuan_cuti/detail_pengajuan_cuti_all_karyawan";
		
		$this->load->view($page, $objek);
	}

	//----------------------------------------------EXPORT DETAIL CUTI FILTER BY DATE APPROVED
	function export_detail($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Detail Pengajuan Cuti All Karyawan tanggal '.$tgl. ' sampai '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_status d','a.pc_status=d.status_id');
		// $this->db->join('history_approval_leaderup e','a.pc_id=e.pc_id');
		$this->db->where_in("a.pc_status",array(3,4,5,7));
		$this->db->where('DATE(a.pc_dateapproved) >=', $tgl);
		$this->db->where('DATE(a.pc_dateapproved) <=', $tgl2);
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "admin/report/pengajuan_cuti/detail_cuti_export";
		
		$this->load->view($page, $objek);
	}


	//----------------------------------------------EXPORT SISA CUTI TAHUNAN
	function export_yearly()
	{	
		$objek['title']	='Laporan Sisa Cuti Tahunan';
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('m_karyawan a');
		$this->db->join('m_departement b','a.dep_id=b.dep_id');
		$this->db->join('m_plant c','a.plant_id=c.plant_id');
		$this->db->where("a.kar_tanggalkeluar = '0000-00-00'");
		// $this->db->where('a.is_active=1');
		// $this->db->join('tr_penambahancuti c','a.kar_id=c.kar_id');
		
		$this->db->order_by('a.kar_id', 'asc');
		$result 		= $this->db->get();
		$objek['data']	= $result->result();
		$page			= "admin/report/sisa_cuti/sisa_cuti_tahunan";
		
		$this->load->view($page, $objek);
	}

	//----------------------------------------------EXPORT SISA CUTI PANJANG
	function export_yearly_cp()
	{	
		$objek['title']	='Laporan Sisa Cuti CP';
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('m_karyawan a');
		$this->db->join('m_departement b','a.dep_id=b.dep_id');
		$this->db->join('tr_penambahancuti c','a.kar_id=c.kar_id');
		$this->db->where('c.cuti_id',2);
		
		$this->db->order_by('a.kar_id', 'asc');
		$result 		= $this->db->get();
		$objek['data']	= $result->result();
		$page			= "admin/report/sisa_cuti/sisa_cuti_panjang";
		
		$this->load->view($page, $objek);
	}

	//----------------------------------------------EXPORT DETAIL CUTI CUTI TAHUNAN
	function export_detail_cuti_ct()
	{	
		$objek['title']	='Laporan Detail Cuti Tahunan '.date('Y') ;
		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_plant d','b.plant_id=d.plant_id');
		$this->db->join('history_approval_leaderup e','a.pc_id=e.pc_id');
		$this->db->join('m_status f','a.pc_status=f.status_kode');
		// $this->db->where('c.cuti_id',2);
		
		// $this->db->group_by('a.kar_id');
		$this->db->order_by('a.kar_id', 'asc');
		$result 		= $this->db->get();
		$objek['data']	= $result->result();
		$page			= "admin/report/sisa_cuti/detail_cuti_tahunan";
		
		$this->load->view($page, $objek);
	}

	//----------------------------------------------PAGE REPORT CUTI BELUM APPROVE LEADER UP
	function report_cuti_belum_approve_leader()
	{	
		$objek['title']	='List Cuti Belum Approve Leader Up';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							WHERE b.pc_status = 1   
						")->result_object();
		$objek['page']	= "report_cuti_belum_approve_leader";
		
		$this->load->view('admin/index', $objek);
	}

//----------------------------------------------FILTER REPORT CUTI BELUM APPROVE LEADER
	function filter_report_cuti_belum_approve_leader()
	{	
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		
		$objek['title']	='List Cuti Belum Approve Leader Up';
		$objek['fromdate']=$fromdate;
		$objek['todate']=$todate;
		$today=date('Y-m-d');

		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_permohonan_cuti b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','a.dep_id=c.dep_kode');
		$this->db->join('m_status d','b.pc_status=d.status_kode');

		if(isset($fromdate)){
			$this->db->where('DATE(b.created) >=',$fromdate);	
			$this->db->where('DATE(b.created) <=',$todate);	
			$this->db->where_in("pc_status",array(1));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_cuti_belum_approve_leader";
		
		$this->load->view('admin/index', $objek);
		
	}

//----------------------------------------------EXPORT CUTI DAILY BELUM APPROVE LEADER FILTER BY DATE CREATED
	function export_cuti_belum_approve_leader($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Pengajuan Cuti Belum Approve Leader Up tanggal '.$tgl. ' sampai dengan '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*,e.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_status d','a.pc_status=d.status_id');
		$this->db->join('v_jatah_CT_perkaryawan e','a.kar_id=e.kar_id');
		$this->db->where('DATE(a.created) >=', $tgl);
		$this->db->where('DATE(a.created) <=', $tgl2);
		$this->db->where('(a.pc_status)=1');
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "admin/report/pengajuan_cuti/pengajuan_cuti_belum_approve_leaderUp_export";
		
		$this->load->view($page, $objek);
	}


	//----------------------------------------------PAGE REPORT CUTI BELUM APPROVE SH/MANAGER
	function report_cuti_belum_approve_sh()
	{	
		$objek['title']	='List Cuti Belum Approve SH / Manager';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*,e.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							LEFT JOIN history_approval_leaderup e ON b.pc_id=e.pc_id
							WHERE b.pc_status = 2   
						")->result_object();
		$objek['page']	= "report_cuti_belum_approve_sh";
		
		$this->load->view('admin/index', $objek);
	}

//----------------------------------------------FILTER REPORT CUTI BELUM APPROVE SH/MANAGER
	function filter_report_cuti_belum_approve_sh()
	{	
		
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		
		$objek['title']	='List Cuti Belum Approve SH / Manager';
		$objek['fromdate']=$fromdate;
		$objek['todate']=$todate;
		$today=date('Y-m-d');

		$this->db->select('a.*,b.*,c.*,d.*,e.*');
		$this->db->from('m_karyawan a');
		$this->db->join('tr_permohonan_cuti b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','a.dep_id=c.dep_kode');
		$this->db->join('m_status d','b.pc_status=d.status_kode');
		$this->db->join('history_approval_leaderup e','b.pc_id=e.pc_id', 'left');

		if(isset($fromdate)){
			$this->db->where('DATE(b.created) >=',$fromdate);	
			$this->db->where('DATE(b.created) <=',$todate);	
			$this->db->where_in("pc_status",array(2));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_cuti_belum_approve_sh";
		
		$this->load->view('admin/index', $objek);
		
	}

//----------------------------------------------EXPORT CUTI DAILY BELUM APPROVE SH FILTER BY DATE CREATED
	function export_cuti_belum_approve_sh($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Pengajuan Cuti Belum Approve SH / Manager tanggal '.$tgl. ' sampai dengan '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_status d','a.pc_status=d.status_id');
		$this->db->join('v_jatah_CT_perkaryawan e','a.kar_id=e.kar_id');
		$this->db->join('history_approval_leaderup f','a.pc_id=f.pc_id','left');
		$this->db->where('DATE(a.created) >=', $tgl);
		$this->db->where('DATE(a.created) <=', $tgl2);
		$this->db->where('(a.pc_status)=2');
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "admin/report/pengajuan_cuti/pengajuan_cuti_belum_approve_sh_export";
		
		$this->load->view($page, $objek);
	}


}
