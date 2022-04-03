<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if($this->session->userdata('status')==''){
			redirect('login/form');
		}
		// if($this->session->level != 7) {
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
		$id		= $this->session->userdata('id');
		$dep_id	= $this->session->userdata('dep_id');
		$today 	= date('Y-m-d');		
		$objek['title'] = 'Monitoring Izin Keluar';
		$objek['total_izin_keluar']=$this->model_admin->count_data('tr_izin_keluar','id',2);
		$objek['total_izin_keluar_today']=$this->model_admin->count_data_today('tr_izin_keluar','id',$today);

		$this->db->select('a.*,b.*,c.*');
		$this->db->from('tr_izin_keluar a');
		$this->db->join('m_karyawan b','a.kar_nik=b.kar_nik');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->where('created',$today);
		$this->db->where_in("a.status",array(3));
		$result_notapproved = $this->db->get('');
		$objek['data_not_approved'] = $result_notapproved->result();

		$this->db->select('a.*,b.*,c.*');
		$this->db->from('tr_izin_keluar a');
		$this->db->join('m_karyawan b','a.kar_nik=b.kar_nik');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->where('created',$today);
		$this->db->where_in("a.status",array(2));
		$result_approved = $this->db->get('');
		$objek['data_approved'] = $result_approved->result();

		$this->db->select('a.*,b.*,c.*');
		$this->db->from('tr_izin_keluar a');
		$this->db->join('m_karyawan b','a.kar_nik=b.kar_nik');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->where('created',$today);
		$this->db->where_in("a.status",array(1));
		$result_belum_approved = $this->db->get('');
		$objek['data_belum_approved'] = $result_belum_approved->result();

		$objek['page'] = 'home';
        $this->load->view('security/index', $objek);
        $dep_nama  = $this->session->userdata('nik');
	}
	public function profile()
	{
		$objek['title']='MyProfile';
		$objek['page']='profile';
		$this->load->view('security/index',$objek);
	}
	public function ganti_foto($id)
	{
		$objek['title']='Ganti Foto Profile';
		$objek['editdata']	= $this->db->get_where('m_karyawan',array('kar_id'=>$id))->result_object();	
		$objek['page']='profile_gantifoto';
		$this->load->view('security/index',$objek);
	}
	function edit_fotoadmin($id)
	{
		$objek['title']='Edit Foto Admin';
		$objek['editdata']	= $this->db->get_where('m_admin',array('adm_id'=>$id))->result_object();		
		$objek['page']	= "admin_editfoto";
		
		$this->load->view('security/index', $objek);
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
			redirect('security/ganti_foto/'.$id,'refresh');
		}else{
		$user_foto = $this->upload->data('file_name');
		$this->db->query("update m_karyawan set kar_foto='$user_foto' where kar_id='$id'");

		redirect('security','refresh');
		}
	}
	
//----------------------------------------------GANTI PASSWORD
	function ganti_password($id)
	{
		$objek['title'] = 'Ganti Password';
		$objek['editdata']	= $this->db->get_where('m_karyawan', array('kar_id' => $id))->result_object();
		$objek['page']	= "ganti_password";

		$this->load->view('security/index', $objek);
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
			
		redirect('security','refresh');
	}




//----------------------------------------------PAGE REPORT IZIN KELUAR BELUM APPROVE 
	function report_izin_keluar_belum_approve()
	{	
		$plant_id=$this->session->userdata('plant_id');
		$objek['title']	='Izin Keluar Belum Approve';

		$this->db->select('a.*,b.*,c.*');
		$this->db->from('tr_izin_keluar a');
		$this->db->join('m_karyawan b','a.kar_nik=b.kar_nik');
		$this->db->join('m_departement c','b.dep_id=c.dep_id');
		$this->db->where_in("a.status",array(1));
		$result = $this->db->get('');

		$objek['data'] = $result->result(); 
		$objek['page'] = "izin_keluar_belum_approve";
		
		$this->load->view('security/index', $objek);
	}

//----------------------------------------------FILTER REPORT IZIN KELUAR BELUM APPROVE 
	function filter_report_izin_keluar_belum_approve()
	{	
		$plant_id=$this->session->userdata('plant_id');
		
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		
		$objek['title']	='List Izin Keluar Belum Approve SH / Manager';
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
		
		$this->load->view('security/index', $objek);
		
	}

//----------------------------------------------EXPORT CUTI DAILY BELUM APPROVE SH FILTER BY DATE CREATED
	function export_izin_keluar_belum_approve_sh($tgl, $tgl2)
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
		$page	= "security/report/pengajuan_cuti/pengajuan_cuti_belum_approve_sh_export";
		
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
		
		$this->load->view('security/index', $objek);
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
		
		$this->load->view('security/index', $objek);
		
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
		$page	= "security/report/pengajuan_cuti/pengajuan_cuti_export";
		
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
		
		$this->load->view('security/index', $objek);
	}

	
}
