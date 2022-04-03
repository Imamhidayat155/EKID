<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if($this->session->userdata('status')==''){
			redirect('login/form');
		}
		// if($this->session->level > 2) {
		// 	echo "<script>alert('Anda Tidak Punya Akses Untuk Login ke halaman ini !!! Silahkan LOGIN kembali ke akun anda'); 
		// 	location.replace('".base_url('login/form')."');
		// 	</script>";
		// 	redirect('login/form');
        // }
		
		$this->load->helper('form');
		$this->load->library('email');

		
	}
	public function index()
	{
		$id = $this->session->userdata('id');
		$dep_id= $this->session->userdata('dep_id');
		$get_CB = $this->db->get_where('tr_penambahancuti', array('kar_id' => $id))->row();
		$row_jatah_CP = $this->db->get_where('v_jatah_CP_perkaryawan', array('kar_id' => $id))->row();
		$row_potong_CP = $this->db->get_where('v_potong_CP_perkaryawan', array('kar_id' => $id))->row();
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $id))->row(); //jatah cuti tahunan
		$row_jatah_CT_ok = $this->db->get_where('v_jatah_CT_perkaryawan_OK', array('kar_id' => $id))->row(); //jatah cuti tahunan - cuti bersama 
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $id))->row(); //Cuti yg sudah dipakai
		
		$sisa_CP_p1 = $row_jatah_CP->total - $row_potong_CP->total - 5;
		if($sisa_CP_p1 < 0) $sisa_CP_p1 = 0;

		$sisa_CP_p2 = $row_jatah_CP->total - $row_potong_CP->total;
		if($sisa_CP_p2 > 5) $sisa_CP_p2 = 5;

		$objek['kar_id'] = $id;
		$objek['jml_CP'] = $row_jatah_CP->total;
		$objek['jml_CT'] =  $row_jatah_CT->total;
		$objek['jml_CB'] = $get_CB->penambahan_cuti_cutibersama;
		$objek['sisa_CT_tahun_lalu'] = $get_CB->sisa_cuti_tahun_sebelumnya;
		$objek['jml_CT_sisa'] = $row_jatah_CT_ok->total  - $row_potong_CT->total; //Aktifkan script berikut kalo CB BELUM di Open
		$objek['jml_CT_sisa2'] = $row_jatah_CT->total  - $row_potong_CT->total; //Aktifkan script berikut kalo CB SUDAH d Open
		$objek['jml_CP_sisa'] = $row_jatah_CP->total - $row_potong_CP->total; 
		$objek['jml_CP_sisa_p1'] = $sisa_CP_p1;
		$objek['jml_CP_sisa_p2'] = $sisa_CP_p2;
		$objek['jml_cuti_wait_approve_leader'] = $this->model_admin->count_cuti_wait_approve_leader('tr_permohonan_cuti',$id);
		$objek['jml_cuti_approved'] = $this->model_admin->count_cuti_sudah_diapprove('tr_permohonan_cuti',$id);
		$objek['title'] = 'Dashboard';
		// $objek['page'] = 'v_blank';
		$objek['page'] = 'home';
        $this->load->view('karyawan/index', $objek);
        $dep_nama  = $this->session->userdata('nik');
	}
	public function profile()
	{
		$objek['title']='MyProfile';
		$objek['page']='profile';
		$this->load->view('karyawan/index',$objek);
	}
	public function ganti_foto($id)
	{
		$objek['title']='Ganti Foto Profile';
		$objek['editdata']	= $this->db->get_where('m_karyawan',array('kar_id'=>$id))->result_object();	
		$objek['page']='profile_gantifoto';
		$this->load->view('karyawan/index',$objek);
	}
	function edit_fotoadmin($id)
	{
		$objek['title']='Edit Foto Admin';
		$objek['editdata']	= $this->db->get_where('m_admin',array('adm_id'=>$id))->result_object();		
		$objek['page']	= "admin_editfoto";
		
		$this->load->view('karyawan/index', $objek);
	}
	function update_fotoprofile($id)
	{
		$config=array(
			'upload_path'=>'fotoprofile',
			'allowed_types'=>'jpg|jpeg|png',
			'max_size'=>5000000,
			'overwrite'=>true
		);
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('file_name')){
			var_dump($this->upload->display_errors());
			redirect('karyawan/ganti_foto/'.$id,'refresh');
		}else{
		$user_foto = $this->upload->data('file_name');
		$this->db->query("update m_karyawan set kar_foto='$user_foto' where kar_id='$id'");

		redirect('karyawan','refresh');
		}
	}

//----------------------------------------------TRANSAKSI CUTI TAHUNAN
	function tr_cuti()
	{
        $kar_id  = $this->session->userdata('id');
		$data['title'] 	= 'Status Pengajuan Cuti';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
                        FROM  tr_permohonan_cuti a
                        INNER JOIN m_karyawan b ON a.kar_id=b.kar_id
						INNER JOIN m_status c ON a.pc_status=c.status_id
						-- LEFT JOIN history_approval_leaderup d ON a.pc_id=d.pc_id
                        WHERE pc_status < 3 && a.kar_id=$kar_id
		")->result_object();
		$data['page']	= "tr_cuti";

		$this->load->view('karyawan/index', $data);
	}

	function tambah_trcuti()
	{
		$nik  = $this->session->userdata('nik');
		// $auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik); // ga dipake
		$objek['auto']	= $auto;

		$objek['title'] ='Permohonan Cuti';
		$objek['page']	= "trcuti_tambah";
		
		$this->load->view('karyawan/index', $objek);
	}

	function insert_trcuti()
	{
		$kar_id	= $this->input->post('kar_id');
		$email	=  $this->input->post('kar_email');
		$lama_cuti= $this->input->post('pc_lamacuti');
		$kode_cuti= $this->input->post('cuti_kode');
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $kar_id))->row();//Jatah CT
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $kar_id))->row(); //CT yg sudah dipakai
		$row_jatah_CP = $this->db->get_where('v_jatah_CP_perkaryawan', array('kar_id' => $kar_id))->row();//Jatah CP
		$row_potong_CP = $this->db->get_where('v_potong_CP_perkaryawan', array('kar_id' => $kar_id))->row(); //CP yg sudah dipakai
		$from_date= $this->input->post('pc_tanggalfrom');
		$to_date= $this->input->post('pc_tanggalto');
		$kar_id= $this->session->userdata('id');

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
		// echo $kode_cuti;
		// die;

		if($from_date <= '2021-12-31'){
			echo "<script>alert('Maaf, Tidak bisa mengajukan cuti untuk tahun 2021 !');
			location.replace('".base_url('karyawan/tambah_trcuti')."'); 
			</script>";
			// echo "<script>alert('Maaf, Pengajuan Cuti untuk tahun 2021 tidak bisa dibuat karena sudah closing !');
			// location.replace('".base_url('leader_up/tambah_trcuti')."'); 
			// </script>";
		}else{
			if($kode_cuti == 'CT'){
				//Validasi tanggal pengajuan yang dobel nya
				if($cek > 0){
					echo "<script>alert('Anda sudah pernah membuat pengajuan cuti di tanggal tersebut, Silahkan cek di menu Status Cuti / History Cuti untuk memastikan !');
					location.replace('".base_url('karyawan/tambah_trcuti')."'); 
					</script>";	
				}else{
				
					//Validasi sisa CT nya
					$sisa_CT = $row_jatah_CT->total - $row_potong_CT->total ;
					$sisa_CT_saat_pengajuan = $sisa_CT - $lama_cuti;
	
					if($sisa_CT_saat_pengajuan < 0 ){
						echo "<script>alert('Jumlah cuti yang anda ambil melebihi sisa cuti anda saat ini !'); 
						location.replace('".base_url('karyawan/tambah_trcuti')."');
						</script>";
					}else{
						$data = $this->input->post(); //Ambil data dari inputan form
						if($this->db->insert('tr_permohonan_cuti', $data)){
							$this->load->model('M_email_blast', 'M_email_blast');
							$dep_id = $this->session->userdata('dep_id');
				
							//select data untuk mendapatkan data email leader up perkaryawan
							$result = $this->db->query("SELECT m_karyawan.kar_nama, m_karyawan.akses_id, m_karyawan.kar_email
														FROM `m_karyawan` 
														INNER JOIN m_user_akses a
														ON a.akses_id=m_karyawan.akses_id
														WHERE m_karyawan.dep_id = $dep_id && m_karyawan.akses_id= 3 && m_karyawan.is_active=1");
				
							if($result->num_rows() > 0){
								$return 	= array();
								$result2 	= $result->result();
				
								foreach($result2 as $value){
									$param = array();
									$param['email'] = $value->kar_email; //email to leader_up "ihidayat155@gmail.com";
									$param['id'] 	= $this->session->userdata('id'); //this
									$param['nama'] 	= $this->session->userdata('user'); //this
									$param['pin'] 	= $this->session->userdata('nik');
									$param['plant'] = $this->session->userdata('plant_id');
				
									$this->M_email_blast->notif_after_pengajuan( $param );	//Kirim parameter data ke model
									echo "<script>alert('Pengajuan cuti sudah dibuat silahkan tunggu untuk Approval Leader !!!'); 
									location.replace('".base_url('karyawan')."');
									</script>";
								}
							}
						}
					}
				}
			}else if($kode_cuti == 'CP'){
				//Validasi tanggal pengajuan yang dobel nya
				if($cek > 0){
					echo "<script>alert('Anda sudah pernah membuat pengajuan cuti di tanggal tersebut, Silahkan cek di menu Status Cuti / History Cuti !');
					location.replace('".base_url('karyawan/tambah_trcuti')."'); 
					</script>";	
				}else{
					//Validasi sisa CP nya
					$sisa_CP = $row_jatah_CP->total - $row_potong_CP->total ;
					$sisa_CP_saat_pengajuan = $sisa_CP - $lama_cuti;
	
					if($sisa_CP_saat_pengajuan < 0 ){
						echo "<script>alert('Jumlah cuti yang anda ambil melebihi sisa cutiiiii anda saat ini !'); 
						location.replace('".base_url('karyawan/tambah_trcuti')."');
						</script>";
					}else{
						$data = $this->input->post(); //Ambil data dari inputan form
						if($this->db->insert('tr_permohonan_cuti', $data)){
							$this->load->model('M_email_blast', 'M_email_blast');
							$dep_id = $this->session->userdata('dep_id');
				
							//select data untuk mendapatkan data email leader up perkaryawan
							$result = $this->db->query("SELECT m_karyawan.plant_id, 
														m_karyawan.kar_nama, m_karyawan.kar_nik, m_karyawan.akses_id, a.akses_nama, m_karyawan.kar_email
														FROM `m_karyawan` 
														INNER JOIN m_user_akses a
														ON a.akses_id=m_karyawan.akses_id
														WHERE m_karyawan.dep_id = $dep_id && m_karyawan.akses_id= 3");
				
							if($result->num_rows() > 0){
								$return 	= array();
								$result2 	= $result->result();
				
								foreach($result2 as $value){
									$param = array();
									$param['email'] = $value->kar_email; //email to leader_up "ihidayat155@gmail.com";
									$param['id'] 	= $this->session->userdata('id'); //this
									$param['nama'] 	= $this->session->userdata('user'); //this
									$param['pin'] 	= $this->session->userdata('nik');
									$param['plant'] = $this->session->userdata('plant_id');
				
									$this->M_email_blast->notif_after_pengajuan( $param );	//Kirim parameter data ke model
									echo "<script>alert('Pengajuan cuti sudah dibuat silahkan tunggu untuk Approval Leader !!!'); 
									location.replace('".base_url('karyawan')."');
									</script>";
								}
							}
						}
					}
				}
			}else{
				echo "<script>alert('Anda belum memilih jenis cuti, Silahkan pilih jenis cuti !!!'); 
				location.replace('".base_url('karyawan/tambah_trcuti')."');
				</script>";
			}
		}
		
	}
	function insert_trcuti_multiple()
	{
        $row = $this->input->post('kar_id');
		if ( isset( $row ) > 0 ) {
			$dataarray = array();
			foreach ( $row as $key => $value ) {
				$dataTmp = array();
				$dataTmp[ 'kar_id']			= $value;
				$dataTmp[ 'akses_id']		= $this->input->post('akses_id');
				$dataTmp[ 'pc_tanggalfrom'] = $this->input->post('pc_tanggalfrom');
				$dataTmp[ 'pc_tanggalto'] 	= $this->input->post('pc_tanggalto');
				$dataTmp[ 'pc_lamacuti'] 	= $this->input->post('pc_lamacuti');
				$dataTmp[ 'pc_keterangan'] 	= $this->input->post('pc_keterangan');
				$dataTmp[ 'cuti_kode'] 		= $this->input->post('cuti_kode');
				$dataTmp[ 'pc_status'] 		= $this->input->post('pc_status');

				$dataarray[] = $dataTmp;
			}
			$this->db->insert_batch( 'tr_permohonan_cuti' , $dataarray);
		}
		redirect('admin/asignment','refresh');
	}

	function edit_trcuti($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['page']		= "tr_cuti_edit";

		$this->load->view('karyawan/index', $objek);
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

		redirect('karyawan/tr_cuti');
	}

	function hapus_trcuti($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('karyawan/tr_cuti');
	}

	

	function hapus_header($id)
	{
		$this->model_admin->DeleteData('history_approval_leaderup', 'pc_id', $id);
		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('karyawan/tr_cuti');
	}
	
//----------------------------------------------GANTI PASSWORD
	function ganti_password($id)
	{
		$objek['title'] = 'Ganti Password';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']	= "ganti_password";

		$this->load->view('karyawan/index', $objek);
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
			
		redirect('karyawan','refresh');
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

		$this->load->view('karyawan/index', $data);
	}


	function tambah_trcuti_panjang()
	{
		$nik  = $this->session->userdata('nik');

		$objek['title']='List Trasaksi Cuti';
		$objek['auto']	= $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CP',$nik);
		$objek['page']	= "trcuti_panjang_tambah";
		
		$this->load->view('karyawan/index', $objek);
	}

	function insert_trcuti_panjang()
	{
		$data = $this->input->post();
		$this->db->insert('tr_permohonan_cuti', $data);	
		
		redirect('karyawan/tr_cuti');
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

		$this->load->view('karyawan/index', $objek);
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

		redirect('karyawan/tr_cuti');
	}

//----------------------------------------------HISTORY SISA CUTI
	function rekap_sisa_cuti(){
		$kar_id  = $this->session->userdata('id');

		$a['title']='Rekap Pengambilan Cuti';
		$a['data']	= $this->db->query("SELECT a.*,b.*,c.*
										FROM m_karyawan a
										INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
										INNER JOIN m_status c ON b.pc_status=c.status_id
										WHERE pc_status > 2 && a.kar_id=$kar_id
										")->result_object();
		$a['page']	= "rekap_sisa_cuti";
		
		$this->load->view('karyawan/index', $a);
	}

	//----------------------------------------------TRANSAKSI POTONG CUTI TAHUNAN BY karyawan
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

		$this->load->view('karyawan/index', $data);
	}

	function tambah_potong_cuti_karyawan()
	{
		$nik  = $this->session->userdata('nik');
		$auto = $this->model_admin->autonumb('tr_permohonan_cuti','pc_kode','PC');
		$objek['auto']	= $auto;

		$objek['title'] ='Potong Cuti Karyawan';
		$objek['page']	= "potong_cuti_karyawan_tambah";
		
		$this->load->view('karyawan/index', $objek);
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
		redirect('karyawan/status_cuti_massal','refresh');

	}
	function edit_potong_cuti_karyawan($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['page']		= "potong_cuti_karyawan_edit";

		$this->load->view('karyawan/index', $objek);
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

		redirect('karyawan/tr_cuti');
	}

	function hapus_potong_cuti_karyawan($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('karyawan/potong_cuti_karyawan');
	}

//----------------------------------------------UNTUK AUTONUMB KODE CUTI DI PERMOHONAN CUTI
	function getCutiCode($id,$cuti_kode)
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

		$this->load->view('karyawan/index', $data);
	}

//----------------------------------------------DELETE CUTI MASSAL	
	function hapus_cuti_massal($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('karyawan/status_cuti_massal');
	}

//----------------------------------------------REKAP CUTI KARYAWAN

	function rekap_cuti_karyawan(){
		$plant_id   = $this->session->userdata('plant_id');
		$akses_id = $this->session->userdata('akses');

		$a['title'] ='Rekap Sisa Cuti';
		// $a['data']	=  $this->db->get_where('m_karyawan', array('plant_id' => $plant_id))->result_object();
		$a['data']	= $this->db->query("SELECT a.*,b.*
										FROM m_karyawan a
										INNER JOIN m_departement b ON a.dep_id=b.dep_id
										WHERE a.plant_id=$plant_id
										")->result_object();
		$a['page']	= "rekap_sisa_cuti";
		
		$this->load->view('karyawan/index', $a);
	}

//----------------------------------------------HISTORY PENGAMBILAN CUTI
	function detail_rekap_cuti_karyawan($id){

		$data['title'] 	= 'History Pengambilan Cuti';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
			FROM tr_permohonan_cuti a
			INNER JOIN m_karyawan b on a.kar_id=b.kar_id
			INNER JOIN m_status c on a.pc_status=c.status_kode
			LEFT JOIN history_approval_leaderup d on a.pc_id=d.pc_id
			WHERE (a.pc_status=3 && a.kar_id=$id) || (a.pc_status=4 && a.kar_id=$id) || (a.pc_status=5 && a.kar_id=$id)
		")->result_object();
		$data['page']	= "history_pengambilan_cuti";

		$this->load->view('karyawan/index', $data);
	}

//----------------------------------------------EXPORT SISA CUTI TAHUNAN
	function export_yearly()
	{	
		$objek['title']	='Laporan Sisa Cuti Tahunan';
		$plant_id = $this->session->userdata('plant_id');
		$this->db->select('a.*,b.*');
		$this->db->from('m_karyawan a');
		$this->db->join('m_departement b','a.dep_id=b.dep_id');
		// $this->db->join('m_cuti_perkaryawan c','a.kar_id=c.kar_id');
		$this->db->where('a.plant_id',$plant_id);
		
		$this->db->order_by('a.kar_id', 'asc');
		$result 		= $this->db->get();
		$objek['data']	= $result->result();
		$page			= "karyawan/report/sisa_cuti/sisa_cuti_tahunan";
		
		$this->load->view($page, $objek);
	}

//----------------------------------------------PAGE REPORT CUTI BELUM APPROVE LEADER UP
	function report_cuti_belum_approve_leader()
	{	
		$plant_id=$this->session->userdata('plant_id');
		$objek['title']	='List Cuti Belum Approve Leader Up';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							WHERE b.pc_status = 1 && a.plant_id=$plant_id   
						")->result_object();
		$objek['page']	= "report_cuti_belum_approve_leader";
		
		$this->load->view('karyawan/index', $objek);
	}

//----------------------------------------------FILTER REPORT CUTI BELUM APPROVE LEADER
	function filter_report_cuti_belum_approve_leader()
	{	
		$plant_id=$this->session->userdata('plant_id');
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
			$this->db->where('(a.plant_id)=',$plant_id);			
			$this->db->where_in("pc_status",array(1));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_cuti_belum_approve_leader";
		
		$this->load->view('karyawan/index', $objek);
		
	}

//----------------------------------------------EXPORT CUTI DAILY BELUM APPROVE LEADER FILTER BY DATE CREATED
	function export_cuti_belum_approve_leader($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$plant_id=$this->session->userdata('plant_id');
		$objek['title']	='Laporan Pengajuan Cuti Belum Approve Leader Up tanggal '.$tgl. ' sampai dengan '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*,e.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_status d','a.pc_status=d.status_id');
		$this->db->join('v_jatah_CT_perkaryawan e','a.kar_id=e.kar_id');
		$this->db->where('DATE(a.created) >=', $tgl);
		$this->db->where('DATE(a.created) <=', $tgl2);
		$this->db->where('(b.plant_id)=',$plant_id);
		$this->db->where('(a.pc_status)=1');
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "karyawan/report/pengajuan_cuti/pengajuan_cuti_belum_approve_leaderUp_export";
		
		$this->load->view($page, $objek);
	}

//----------------------------------------------PAGE REPORT CUTI BELUM APPROVE SH/MANAGER
	function report_cuti_belum_approve_js()
	{	
		$team_id=$this->session->userdata('team_id');
		$objek['title']	='List Cuti Belum Approve Japan Staff';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*,e.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							LEFT JOIN history_approval_leaderup e ON b.pc_id=e.pc_id
							WHERE b.pc_status = 6 && a.team_id=$team_id   
						")->result_object();
		$objek['page']	= "report_cuti_belum_approve_js";
		
		$this->load->view('karyawan/index', $objek);
	}
//----------------------------------------------PAGE REPORT CUTI BELUM APPROVE SH/MANAGER
	function report_cuti_belum_approve_sh()
	{	
		$plant_id=$this->session->userdata('plant_id');
		$objek['title']	='List Cuti Belum Approve SH / Manager';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*,e.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							LEFT JOIN history_approval_leaderup e ON b.pc_id=e.pc_id
							WHERE b.pc_status = 2 && a.plant_id=$plant_id   
						")->result_object();
		$objek['page']	= "report_cuti_belum_approve_sh";
		
		$this->load->view('karyawan/index', $objek);
	}

//----------------------------------------------FILTER REPORT CUTI BELUM APPROVE SH/MANAGER
	function filter_report_cuti_belum_approve_sh()
	{	
		$plant_id=$this->session->userdata('plant_id');
		
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
			$this->db->where('(a.plant_id)=',$plant_id);			
			$this->db->where_in("pc_status",array(2));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_cuti_belum_approve_sh";
		
		$this->load->view('karyawan/index', $objek);
		
	}

//----------------------------------------------EXPORT CUTI DAILY BELUM APPROVE SH FILTER BY DATE CREATED
	function export_cuti_belum_approve_sh($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$plant_id=$this->session->userdata('plant_id');
		$objek['title']	='Laporan Pengajuan Cuti Belum Approve SH / Manager tanggal '.$tgl. ' sampai dengan '.$tgl2;
		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_status d','a.pc_status=d.status_id');
		$this->db->join('v_jatah_CT_perkaryawan e','a.kar_id=e.kar_id');
		$this->db->join('history_approval_leaderup f','a.pc_id=f.pc_id');
		$this->db->where('DATE(a.created) >=', $tgl);
		$this->db->where('DATE(a.created) <=', $tgl2);
		$this->db->where('(b.plant_id)=',$plant_id);
		$this->db->where('(a.pc_status)=2');
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "karyawan/report/pengajuan_cuti/pengajuan_cuti_belum_approve_sh_export";
		
		$this->load->view($page, $objek);
	}

//----------------------------------------------PAGE REPORT CUTI DAILY
	function report_cuti_daily()
	{	$plant_id= $this->session->userdata('plant_id');
		$objek['title']	='List Cuti Sudah Approve';
		$objek['data']	=$this->db->query("SELECT a.*,b.*,c.*,d.*
							FROM m_karyawan a
							INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
							INNER JOIN m_departement c ON a.dep_id=c.dep_id
							INNER JOIN m_status d ON b.pc_status=d.status_id
							WHERE (a.plant_id = $plant_id && b.pc_status = 3) || (a.plant_id = $plant_id && b.pc_status = 7)
						")->result_object();
		$objek['page']	= "report_cuti_daily";
		
		$this->load->view('karyawan/index', $objek);
	}

//----------------------------------------------FILTER REPORT CUTI DAILY
	function filter_report_cuti_daily()
	{	
		
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$plant_id = $this->session->userdata('plant_id');
		
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
			$this->db->where('a.plant_id',$plant_id);				
			$this->db->where_in("pc_status",array(7,3));				
		}	
		
		$this->db->order_by('b.kar_id', 'desc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$objek['page']	= "report_cuti_daily";
		
		$this->load->view('karyawan/index', $objek);
		
	}

//----------------------------------------------EXPORT CUTI DAILY FILTER BY DATE APPROVED
	function export_daily($tgl, $tgl2)
	{	
		// $codest=explode("%7C",$id)[0];
		// $tgl=explode("%7C",$id)[1];
		$objek['title']	='Laporan Pengajuan Cuti tanggal '.$tgl. ' sampai dengan '.$tgl2;
		$plant_id = $this->session->userdata('plant_id');
		$this->db->select('a.*,b.*,c.*,d.*');
		$this->db->from('tr_permohonan_cuti a');
		$this->db->join('m_karyawan b','a.kar_id=b.kar_id');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->join('m_status d','a.pc_status=d.status_id');
		$this->db->where('b.plant_id',$plant_id);
		$this->db->where_in("a.pc_status",array(7,3));
		$this->db->where('DATE(a.pc_dateapproved) >=', $tgl);
		$this->db->where('DATE(a.pc_dateapproved) <=', $tgl2);
		
		$this->db->order_by('a.kar_id', 'asc');
		$result = $this->db->get();
		$objek['data']	= $result->result();
		$page	= "karyawan/report/pengajuan_cuti/pengajuan_cuti_export";
		
		$this->load->view($page, $objek);
	}


	//----------------------------------------------TRANSAKSI IZIN KELUAR
	function blank()
	{
		$nik  = $this->session->userdata('nik');
		// $auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik); // ga dipake
		$objek['auto']	= $auto;
		$objek['title'] ='Permohonan Izin Keluar';
		$objek['page']	= "izin_keluar/v_under_development";
		
		$this->load->view('karyawan/index', $objek);
	}

	function status_izin_keluar()
	{
		$kar_nik  		= $this->session->userdata('nik');
		$data['title'] 	= 'Status Pengajuan Izin Keluar';
		$data['data']	= $this->db->query("SELECT a.*,b.*
						FROM  tr_izin_keluar a
						INNER JOIN m_karyawan b ON a.kar_nik=b.kar_nik
						INNER JOIN m_departement c ON b.dep_id=c.dep_id						
						WHERE a.status = 1 && a.kar_nik=$kar_nik
		")->result_object();
		$data['page']	= "izin_keluar/v_status_izin_keluar";

		$this->load->view('karyawan/index', $data);
	}

	function tambah_izin_keluar()
	{
		$nik  = $this->session->userdata('nik');
		// $auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik); // ga dipake
		$objek['title'] ='Permohonan Izin Keluar';
		$objek['page']	= "izin_keluar/v_tambah_izin_keluar";
		
		$this->load->view('karyawan/index', $objek);
	}

	function insert_izin_keluar()
	{
        $data = $this->input->post();

		if($this->db->insert('tr_izin_keluar', $data)){
			$this->load->model('M_email_blast', 'M_email_blast');
			$plant_id = $this->session->userdata('plant_id');

			//select data untuk mendapatkan data email SH
			$result = $this->db->query("SELECT m_karyawan.kar_email
										FROM `m_karyawan` 
										INNER JOIN m_user_akses 
										ON m_user_akses.akses_id=m_karyawan.akses_id
										WHERE m_karyawan.plant_id = $plant_id && m_karyawan.akses_id= 4");

			if($result->num_rows() > 0){
				$return 	= array();
				$result2 	= $result->result();

				foreach($result2 as $value){
					$param = array();
					$param['email'] = $value->kar_email; //"ihidayat155@gmail.com"; //email to SH 
					$param['nik'] 	= $this->session->userdata('nik'); //this
					$param['nama'] 	= $this->session->userdata('user'); //this
					$param['pin'] 	= $this->session->userdata('nik');
					$param['plant'] = $this->session->userdata('plant_id');

					$this->M_email_blast->notif_after_pengajuan_izin_keluar( $param );	//Kirim parameter data ke model
					echo "<script>alert('Izin Keluar sudah dibuat silahkan tunggu untuk Approval SH !!!'); 
					location.replace('".base_url('karyawan')."');
					</script>";
				}
			}
		}
		redirect('karyawan/status_izin_keluar','refresh');
	}

	function edit_izin_keluar($id)
	{
		$objek['title'] 	= 'Edit Izin Keluar';
		$objek['editdata']	= $this->db->get_where('tr_izin_keluar', array('id' => $id))->result_object();
		$objek['page']		= "izin_keluar/v_edit_izin_keluar";

		$this->load->view('karyawan/index', $objek);
	}

	function update_izin_keluar($id)
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

		redirect('karyawan/tr_cuti');
	}

	function hapus_izin_keluar($id)
	{

		$this->model_admin->DeleteData('tr_izin_keluar', 'id', $id);
		redirect('karyawan/status_izin_keluar');
	}
}
