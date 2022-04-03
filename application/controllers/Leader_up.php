<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leader_up extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if ($this->session->userdata('status') == '') {
			redirect('login/form');
		}

		if($this->session->level != 3) {
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
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $id))->row();
		$row_jatah_CT_ok = $this->db->get_where('v_jatah_CT_perkaryawan_OK', array('kar_id' => $id))->row(); //jatah cuti tahunan - cuti bersama
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $id))->row(); //Cuti yg sudah dipakai

		$sisa_CP_p1 = $row_jatah_CP->total - $row_potong_CP->total - 5;
		if($sisa_CP_p1 < 0) $sisa_CP_p1 = 0;

		$sisa_CP_p2 = $row_jatah_CP->total - $row_potong_CP->total;
		if($sisa_CP_p2 > 5) $sisa_CP_p2 = 5;

		$objek['kar_id'] = $id;
		$objek['jml_CP'] = $row_jatah_CP->total;
		$objek['jml_CT'] = $row_jatah_CT->total;
		$objek['jml_CB'] = $get_CB->penambahan_cuti_cutibersama;
		$objek['sisa_CT_tahun_lalu'] = $get_CB->sisa_cuti_tahun_sebelumnya;
		$objek['jml_CT_sisa'] = $row_jatah_CT_ok->total  - $row_potong_CT->total; //Aktifkan script berikut kalo CB BELUM di Open
		$objek['jml_CT_sisa2'] = $row_jatah_CT->total  - $row_potong_CT->total; //Aktifkan script berikut kalo CB SUDAH d Open
		$objek['jml_CP_sisa'] = $row_jatah_CP->total - $row_potong_CP->total;
		$objek['jml_CP_sisa_p1'] = $sisa_CP_p1;
		$objek['jml_CP_sisa_p2'] = $sisa_CP_p2;
		$objek['title'] = 'Dashboard';
		// $objek['page'] = 'v_blank';
		$objek['page'] = 'home';
        $this->load->view('leader_up/index', $objek);
        $dep_nama  = $this->session->userdata('nik');
	}
	
	public function profile()
	{
		$objek['title'] = 'MyProfile';
		$objek['page']  = 'profile';
		$this->load->view('leader_up/index', $objek);
	}
	public function ganti_foto($id)
	{
		$objek['title'] = 'Ganti Foto Profile';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page'] = 'profile_gantifoto';
		$this->load->view('leader_up/index', $objek);
	}
	function edit_fotoadmin($id)
	{
		$objek['title'] = 'Edit Foto Admin';
		$objek['editdata']	= $this->db->get_where('m_admin', array('adm_id' => $id))->result_object();
		$objek['page']	= "admin_editfoto";

		$this->load->view('leader_up/index', $objek);
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
			redirect('leader_up/ganti_foto/' . $id, 'refresh');
		} else {
			$user_foto = $this->upload->data('file_name');
			$this->db->query("update m_karyawan set kar_foto='$user_foto' where kar_id='$id'");

			redirect('leader_up', 'refresh');
		}
	}
	

//----------------------------------------------GANTI PASSWORD
	function ganti_password($id)
	{
		$objek['title'] = 'Ganti Password';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']	= "ganti_password";

		$this->load->view('leader_up/index', $objek);
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
			
		redirect('leader_up','refresh');
	}

    
//----------------------------------------------TRANSAKSI CUTI TAHUNAN
	function tr_cuti()
	{
        $kar_id  = $this->session->userdata('id');
		$data['title'] 	= 'Status Pengajuan Cuti';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
                        FROM m_karyawan a
                        INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
						INNER JOIN m_status c on b.pc_status=c.status_id
                        WHERE pc_status = 2 && a.kar_id=$kar_id
		")->result_object();
		$data['page']	= "tr_cuti";

		$this->load->view('leader_up/index', $data);
	}

	function tambah_trcuti()
	{
		$nik  = $this->session->userdata('nik');
		$auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik);
		$objek['auto']	= $auto;

		$objek['title'] ='Permohonan Cuti';
		$objek['page']	= "trcuti_tambah";
		
		$this->load->view('leader_up/index', $objek);
	}

	function insert_trcuti()
	{
		$kar_id= $this->session->userdata('id');
		$email	=  $this->input->post('kar_email');
		$lama_cuti= $this->input->post('pc_lamacuti');
		$kode_cuti= $this->input->post('cuti_kode');
		$row_jatah_CT = $this->db->get_where('v_jatah_CT_perkaryawan', array('kar_id' => $kar_id))->row(); //jatah CT
		$row_potong_CT = $this->db->get_where('v_potong_CT_perkaryawan', array('kar_id' => $kar_id))->row(); //CT yg sudah dipakai
		$row_jatah_CP = $this->db->get_where('v_jatah_CP_perkaryawan', array('kar_id' => $kar_id))->row(); //jatah CP
		$row_potong_CP = $this->db->get_where('v_potong_CP_perkaryawan', array('kar_id' => $kar_id))->row(); //CP yg sudah dipakai
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

		if($from_date <= '2021-12-31'){
			echo "<script>alert('Maaf, Tidak bisa mengajukan cuti untuk tahun 2021 !');
			location.replace('".base_url('leader_up/tambah_trcuti')."'); 
			</script>";
			// echo "<script>alert('Maaf, Pengajuan Cuti untuk tahun 2020 tidak bisa dibuat karena sudah closing !');
			// location.replace('".base_url('leader_up/tambah_trcuti')."'); 
			// </script>";
		}else{
			if($kode_cuti == 'CT'){
				//Validasi tanggal pengajuan yang dobel nya
				if($cek > 0){
					echo "<script>alert('Anda sudah pernah membuat pengajuan di tanggal tersebut !'); 
					</script>";
				}else{
					//Validasi sisa cuti nya
					$sisa_CT = $row_jatah_CT->total - $row_potong_CT->total ;
					$sisa_CT_saat_pengajuan = $sisa_CT - $lama_cuti;
					if($sisa_CT_saat_pengajuan < 0 ){
						echo "<script>alert('Jumlah cuti yang anda ambil melebihi sisa cuti anda saat ini !'); 
						location.replace('".base_url('leader_up/tambah_trcuti')."');
						</script>";
					}else{
						$data = $this->input->post();
						if($this->db->insert('tr_permohonan_cuti', $data)){
							$this->load->model('M_email_blast', 'M_email_blast');
							$plant_id = $this->session->userdata('plant_id');
				
							$result = $this->db->query("SELECT m_karyawan.plant_id, 
														m_karyawan.kar_nama, m_karyawan.kar_nik, m_karyawan.akses_id, a.akses_nama, m_karyawan.kar_email
														FROM `m_karyawan` 
														INNER JOIN m_user_akses a
														ON a.akses_id=m_karyawan.akses_id
														WHERE m_karyawan.plant_id = $plant_id && m_karyawan.akses_id= 4");
				
							if($result->num_rows() > 0){
								$return 	= array();
								$result2 	= $result->result();
				
								foreach($result2 as $value){
									$param = array();
									$param['email'] = $value->kar_email; //email to SH/Manager masing-masing
									$param['id'] 	= $this->session->userdata('id'); 
									$param['nama'] 	= $this->session->userdata('user'); 
									$param['pin'] 	= $this->session->userdata('nik');
									$param['plant'] = $this->session->userdata('plant_id');
				
									$this->M_email_blast->notif_after_pengajuan( $param );	//Kirim parameter data ke model
									echo "<script>alert('Pengajuan cuti sudah dibuat silahkan tunggu untuk Approval Section Head / Manager !'); 
									location.replace('".base_url('leader_up')."');
									</script>";
								}
							}
						}
					}
				}
			}else if($kode_cuti == 'CP'){
				//Validasi tanggal pengajuan yang dobel nya
				if($cek > 0){
					echo "<script>alert('Anda sudah pernah membuat pengajuan di tanggal tersebut !'); 
					</script>";
				}else{
					//Validasi sisa cuti nya
					$sisa_CP = $row_jatah_CP->total - $row_potong_CP->total ;
					$sisa_CP_saat_pengajuan = $sisa_CP - $lama_cuti;
					if($sisa_CP_saat_pengajuan < 0 ){
						echo "<script>alert('Jumlah cuti yang anda ambil melebihi sisa cuti anda saat ini !'); 
						location.replace('".base_url('leader_up/tambah_trcuti')."');
						</script>";
					}else{
						$data = $this->input->post();
						if($this->db->insert('tr_permohonan_cuti', $data)){
							$this->load->model('M_email_blast', 'M_email_blast');
							$plant_id = $this->session->userdata('plant_id');
				
							$result = $this->db->query("SELECT m_karyawan.plant_id, 
														m_karyawan.kar_nama, m_karyawan.kar_nik, m_karyawan.akses_id, a.akses_nama, m_karyawan.kar_email
														FROM `m_karyawan` 
														INNER JOIN m_user_akses a
														ON a.akses_id=m_karyawan.akses_id
														WHERE m_karyawan.plant_id = $plant_id && m_karyawan.akses_id= 4");
				
							if($result->num_rows() > 0){
								$return 	= array();
								$result2 	= $result->result();
				
								foreach($result2 as $value){
									$param = array();
									$param['email'] = $value->kar_email; //email to SH/Manager masing-masing
									$param['id'] 	= $this->session->userdata('id'); 
									$param['nama'] 	= $this->session->userdata('user'); 
									$param['pin'] 	= $this->session->userdata('nik');
									$param['plant'] = $this->session->userdata('plant_id');
				
									$this->M_email_blast->notif_after_pengajuan( $param );	//Kirim parameter data ke model
									echo "<script>alert('Pengajuan cuti sudah dibuat silahkan tunggu untuk Approval Section Head / Manager !'); 
									location.replace('".base_url('leader_up')."');
									</script>";
								}
							}
						}
					}
				}
			}else{
				echo "<script>alert('Anda belum memilih jenis cuti, Silahkan pilih jenis cuti !!!'); 
				location.replace('".base_url('leader_up/tambah_trcuti')."');
				</script>";
			}
		}

	}

	function edit_trcuti($id)
	{
		$objek['title'] 	= 'Edit Transaksi Cuti';
		$objek['editdata']	= $this->db->get_where('tr_permohonan_cuti', array('pc_id' => $id))->result_object();
		$objek['page']		= "tr_cuti_edit";

		$this->load->view('leader_up/index', $objek);
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

		redirect('leader_up/tr_cuti');
	}

	function hapus_trcuti($id)
	{

		$this->model_admin->DeleteData('tr_permohonan_cuti', 'pc_id', $id);
		redirect('leader_up/tr_cuti');
    }
    
//----------------------------------------------APPROVAL_CUTI
	function approval()
	{	
		$dep_id   = $this->session->userdata('dep_id');
		$akses_id = $this->session->userdata('akses');

		$objek['title']	='List Cuti Belum Approve';
		$objek['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
						FROM m_karyawan a
						INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
						INNER JOIN m_departement c ON a.dep_id=c.dep_id
						INNER JOIN m_user_akses d ON b.akses_id=d.akses_id
						WHERE b.pc_status = 1 && c.dep_id = $dep_id && b.akses_id < $akses_id
						")->result_object();
		$objek['page']	= "approval_cuti";
		
		$this->load->view('leader_up/index', $objek);
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

		$this->load->view('leader_up/index', $data);
	}


	function tambah_trcuti_panjang()
	{
		$nik  = $this->session->userdata('nik');

		$objek['title']='List Trasaksi Cuti';
		$objek['auto']	= $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CP',$nik);
		$objek['page']	= "trcuti_panjang_tambah";
		
		$this->load->view('leader_up/index', $objek);
	}

	function insert_trcuti_panjang()
	{
		$data = $this->input->post();
		$this->db->insert('tr_permohonan_cuti', $data);	
		
		redirect('leader_up/tr_cuti');
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

		$this->load->view('leader_up/index', $objek);
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

		redirect('leader_up/tr_cuti');
	}


//----------------------------------------------HISTORY PENGAMBILAN CUTI
	function detail_rekap_cuti_karyawan($id){

		$data['title']='History Pengambilan Cuti';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
										FROM m_karyawan a
										INNER JOIN tr_permohonan_cuti b ON a.kar_id=b.kar_id
										INNER JOIN m_status c ON b.pc_status=c.status_id
										WHERE pc_status > 2 && a.kar_id=$id
										")->result_object();
		$data['page']	= "history_pengambilan_cuti";
		
		$this->load->view('leader_up/index', $data);
	}

//----------------------------------------------REKAP SISA CUTI

	function rekap_sisa_cuti(){
		$dep_id   = $this->session->userdata('dep_id');
		$akses_id = $this->session->userdata('akses');

		$a['title'] ='Rekap Sisa Cuti';
		$a['data']	=  $this->db->query("SELECT a.*,b.*
						FROM m_karyawan a
						INNER JOIN m_cuti_perkaryawan b on a.kar_id=b.kar_id
						WHERE a.dep_id=$dep_id
		")->result_object();
		$a['page']	= "rekap_sisa_cuti";
		
		$this->load->view('leader_up/index', $a);
	}

//----------------------------------------------DETAIL REKAP SISA CUTI

	function detail_rekap_sisa_cuti($id){

		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*
                        FROM m_karyawan a
                        INNER JOIN tr_permohonan_cuti b on a.kar_id=b.kar_id
						INNER JOIN m_status c on b.pc_status=c.status_id
						WHERE a.kar_id=$id && b.pc_status > 2
		")->result_object();
		$data['page']	= "detail_rekap_sisa_cuti";

		$this->load->view('leader_up/index', $data);
	}

//----------------------------------------------PAGE DETAIL HISTORY APPROVAL

	function history_approval()
	{	
		$dep_id   = $this->session->userdata('dep_id');

		$objek['title']	='List Cuti Sudah Approve';
		$objek['data']	= $this->db->query("SELECT a.*,b.* 
						FROM m_karyawan a 
						INNER JOIN m_user_akses b on a.akses_id=b.akses_id 
						WHERE a.dep_id = $dep_id")->result_object();
		$objek['page']	= "history_approval";
		
		$this->load->view('leader_up/index', $objek);
	}

//---------------------------------------------- DETAIL HISTORY APPROVAL

	function detail_history_approval($id){

		$data['title'] 	= 'List Transaksi Cuti Tahunan';
		$data['data']	= $this->db->query("SELECT a.*,b.*,c.*,d.*
                        FROM tr_permohonan_cuti a
                        INNER JOIN m_karyawan b on a.kar_id=b.kar_id
                        INNER JOIN m_status c on a.pc_status=c.status_kode
                        INNER JOIN history_approval_leaderup d on a.pc_id=d.pc_id
						WHERE a.kar_id=$id
		")->result_object();
		$data['page']	= "detail_history_approval";

		$this->load->view('leader_up/index', $data);
	}

//----------------------------------------------APPROVE TRANSAKSI CUTI
	function approve_trcuti($id)
	{	
		$this->db->trans_begin();
		$nama=$this->session->userdata('user');

		$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$id'")->row();
		$rowmCuti=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

		$totalsisacuti=$rowmCuti->jatah_cuti - $rowmCuti->cuti_diambil;

		$dateapp=date('Y-m-d H:i:s');
		$data=array(
			'pc_approvedby'	 => $nama,
			'pc_dateapproved'=> $dateapp,
			'pc_sisacuti'	 => $totalsisacuti,
			'pc_status'		 => 2
		);
		$data2[]=array(
			'actioned_by'	 	 => $nama,
			'pc_id'			 	 => $id,
			'tanggal_approved'	 => $dateapp,
			'status_id'			 => 2,
			'keterangan_actioned'=> 'OK'
		);
		if(count($data) > 0){
			$this->db->where('pc_id', $id);
			$this->db->update('tr_permohonan_cuti', $data);
			$plant_id = $this->session->userdata('plant_id');

			$this->load->model('M_email_blast', 'M_email_blast');
			
			//Query untuk ambil data email SH berdasarkan sectionnya dan akses levelnya
			$result = $this->db->query("SELECT m_karyawan.kar_email
										FROM m_karyawan 
										INNER JOIN m_user_akses 
										ON m_user_akses.akses_id=m_karyawan.akses_id
										WHERE m_karyawan.plant_id = $plant_id && m_karyawan.akses_id= 4");

			//Query untuk ambil data user yang mengajukan cuti
			$email_data = $this->db->query("SELECT m_karyawan.kar_nama, m_karyawan.kar_nik, m_departement.dep_nama, m_karyawan.kar_id
										FROM m_karyawan
										INNER JOIN m_departement
										ON m_karyawan.dep_id=m_departement.dep_id
										WHERE kar_id ='$row1->kar_id'");

			if($result->num_rows() > 0){
				$return 	= array();
				$result2 	= $result->result();

				if($email_data->num_rows() > 0){
					$result_email = $email_data->result();

					foreach($result_email as $value_email){
						foreach($result2 as $value){
							$param = array();
							$param['email'] 	  = $value->kar_email; //email to SH or Manager  "ihidayat155@gmail.com";
							$param['id'] 		  = $this->session->userdata('id');  
							$param['kar_id'] 	  = $value_email->kar_id;
							$param['nama'] 		  = $value_email->kar_nama;
							$param['pin'] 		  = $value_email->kar_nik;
							$param['plant'] 	  = $value_email->dep_nama;
							$param['approved_by'] = $this->session->userdata('user');
		
							$this->M_email_blast->notif_after_approval( $param );	//Kirim parameter data ke model
							
							// echo "<script>alert('Pengajuan cuti sudah dibuat silahkan tunggu untuk Approval Leader !!!'); 
							// location.replace('".base_url('karyawan')."');
							// </script>";
						}
					}
					
				}
				
			}
			
		}else{
			echo 'APPROVE FAILED !!!';
		}
		$this->db->insert_batch('history_approval_leaderup',$data2);
		
		if ( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
			echo "<script>alert('APPROVE CUTI FAILED !!!'); 
			location.replace('".base_url('leader_up/history_approval')."');
			</script>";
		} else {
			$this->db->trans_commit();
			echo "<script>alert('APPROVE CUTI SUCCESS !!!'); 
			location.replace('".base_url('leader_up/approval')."');
			</script>";
		}
		// echo "<script>alert('Approve Cuti Success !!!'); 
		// location.replace('".base_url('leader_up/approval')."');
		// </script>";
		
		// redirect('admin/approval','refresh');
	}

//----------------------------------------------REJECT TRANSAKSI CUTI

	function reject_trcuti() {

		$pc_keterangan_ditolak = $this->input->post('note'); //post('note') dapet dari parameter di Jquery yg di view approval cuti
		$pc_id = $this->input->post('pc_id');
		$plant_id= $this->session->userdata('plant_id');


		$row1=$this->db->query("SELECT * FROM tr_permohonan_cuti WHERE pc_id='$pc_id'")->row();
		$rowmCuti=$this->db->query("SELECT * FROM m_cuti_perkaryawan WHERE kar_id='$row1->kar_id'")->row();

		$totalsisacuti=$rowmCuti->jatah_cuti - $rowmCuti->cuti_diambil;

		$nama= $this->session->userdata('user');
		$dateapp=date('Y-m-d H:i:s');
		$data=array(
			'pc_approvedby'	 		 => $nama,
			'pc_dateapproved'		 => $dateapp,
			'pc_sisacuti'	 		 => $totalsisacuti,
			'pc_keterangan_ditolak'	 => $pc_keterangan_ditolak,
			'pc_status'		 		 => 4
		);

		if(count($data) > 0){

			$this->load->model('M_email_blast', 'M_email_blast');

			//Query untuk ambil data user yang mengapprove cuti
			$email_data = $this->db->query("SELECT m_karyawan.kar_nama, m_karyawan.kar_nik, m_departement.dep_nama, m_karyawan.kar_id, m_karyawan.kar_email
							FROM m_karyawan
							INNER JOIN m_departement
							ON m_karyawan.dep_id=m_departement.dep_id
							WHERE m_karyawan.plant_id = $plant_id && m_karyawan.kar_id= $row1->kar_id");

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
							$param['alasan']	  = $pc_keterangan_ditolak;
							$this->M_email_blast->notif_after_reject_to_user( $param );	//Kirim parameter data ke model
					}
				}
				$this->db->where('pc_id', $pc_id);
				$this->db->update('tr_permohonan_cuti', $data);
			// echo "<script>alert('Reject Cuti Success !!!'); 
			// location.replace('".base_url('leader_up/approval')."');
			// </script>";
		}//else{
		// 	echo "Reject Failed !";
		// }
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

	function blank()
	{
		$nik  = $this->session->userdata('nik');
		// $auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik); // ga dipake
		$objek['auto']	= $auto;
		$objek['title'] ='Permohonan Izin Keluar';
		$objek['page']	= "izin_keluar/v_under_development";
		
		$this->load->view('leader_up/index', $objek);
	}

	function status_izin_keluar()
	{
		$kar_nik  		= $this->session->userdata('nik');
		$data['title'] 	= 'Status Pengajuan Izin Keluar';
		$data['data']	= $this->db->query("SELECT a.*,b.*
						FROM  tr_izin_keluar a
						INNER JOIN m_karyawan b ON a.kar_nik=b.kar_nik
						WHERE a.status = 1 && a.kar_nik=$kar_nik
		")->result_object();


		$data['page']	= "izin_keluar/v_status_izin_keluar";

		$this->load->view('leader_up/index', $data);
	}

	function tambah_izin_keluar()
	{
		$nik  = $this->session->userdata('nik');
		// $auto = $this->model_admin->autonumb_uniq('tr_permohonan_cuti','pc_kode','CT',$nik); // ga dipake
		$objek['title'] ='Permohonan Izin Keluar';
		$objek['page']	= "izin_keluar/v_tambah_izin_keluar";
		
		$this->load->view('leader_up/index', $objek);
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
					$param['nik'] 	= $this->session->userdata('nik'); 
					$param['nama'] 	= $this->session->userdata('user'); 
					$param['pin'] 	= $this->session->userdata('nik');
					$param['plant'] = $this->session->userdata('plant_id');

					$this->M_email_blast->notif_after_pengajuan_izin_keluar( $param );	//Kirim parameter data ke model
					echo "<script>alert('Izin Keluar sudah dibuat silahkan tunggu untuk Approval SH !!!'); 
					location.replace('".base_url('leader_up')."');
					</script>";
				}
			}
		}
		redirect('leader_up/status_izin_keluar','refresh');
	}

	function edit_izin_keluar($id)
	{
		$objek['title'] 	= 'Edit Izin Keluar';
		$objek['editdata']	= $this->db->get_where('tr_izin_keluar', array('id' => $id))->result_object();
		$objek['page']		= "izin_keluar/v_edit_izin_keluar";

		$this->load->view('leader_up/index', $objek);
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

		redirect('leader_up/tr_cuti');
	}

	function hapus_izin_keluar($id)
	{

		$this->model_admin->DeleteData('tr_izin_keluar', 'id', $id);
		redirect('leader_up/status_izin_keluar');
	}

}

