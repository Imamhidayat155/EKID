<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

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
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if($this->session->userdata('status')==''){
			redirect('login/form');
		}
	}
	public function index()
	{
		$objek['title']='Dashboard';
		$objek['data']	= $this->db->query("select a.*,b.*,c.*,d.*
		from req_detail a
		inner join m_item b on a.item_id=b.item_id
		left join m_warna c on a.warna_id=c.warna_id
		left join m_size d on a.size_id=d.size_id
		")->result_object();
		$objek['page']	= "transaksi_tambah";
		
		$this->load->view('karyawan/index2', $objek);
	}
	public function profile()
	{
		$objek['title']='MyProfile';
		$objek['page']='profile';
		$this->load->view('admin/index',$objek);
	}
	public function ganti_foto($id)
	{
		$objek['title']='Ganti Foto Profile';
		$objek['editdata']	= $this->db->get_where('m_user',array('user_id'=>$id))->result_object();	
		$objek['page']='profile_gantifoto';
		$this->load->view('admin/index',$objek);
	}
	function edit_fotoadmin($id)
	{
		$objek['title']='Edit Foto Admin';
		$objek['editdata']	= $this->db->get_where('m_admin',array('adm_id'=>$id))->result_object();		
		$objek['page']	= "admin_editfoto";
		
		$this->load->view('admin/index', $objek);
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
			redirect('admin/ganti_foto/'.$id,'refresh');
		}else{
		$user_foto = $this->upload->data('file_name');
		$this->db->query("update m_user set user_foto='$user_foto' where user_id='$id'");

		redirect('admin/user','refresh');
		}
	}

	//---------------------------------request
	function request()
	{
		$nik = $this->session->userdata('nik');
		$objek['title']='List request';
		$objek['data']	= $this->db->query("select a.*,b.*,c.*,d.*
		from req_detail a
		inner join m_item b on a.item_id=b.item_id
		left join m_warna c on a.warna_id=c.warna_id
		left join m_size d on a.size_id=d.size_id
		inner join req_header e on a.reqhed_code=e.reqhed_code
		where a.reqhed_code like '%$nik'
		")->result_object();
		$objek['page']	= "request";
		
		$this->load->view('karyawan/index2', $objek);
	}
	function tambah_request()
	{
		$objek['autonumb']	= $this->model_admin->autonumb('req_detail','reqhed_code','REQ');
		$objek['title']='List request';
		$objek['page']	= "request_tambah";
		
		$this->load->view('admin/index', $objek);
	}
	function insert_request()
	{
		$data = $this->input->post();
		$this->db->insert('req_detail', $data);
		redirect('admin/request','refresh');
	}
	function edit_request($id)
	{
		$objek['title']='List request';
		$objek['editdata']	= $this->db->get_where('req_detail',array('reqdet_id'=>$id))->result_object();		
		$objek['page']	= "request_edit";
		
		$this->load->view('admin/index', $objek);
	}
	function update_request($id)
	{
		$data = $this->input->post();
		$this->db->where('reqdet_id', $id);
		$this->db->update('req_detail', $data); 

		redirect('admin/request','refresh');
	}
	function hapus_request($id)
	{
		
		$this->model_admin->DeleteData('req_detail','reqdet_id',$id);
		redirect('admin/request','refresh');
	}

	//---------------------------------user
	function user()
	{
	
		$objek['title']='List user';
		$objek['data']	= $this->model_admin->GetAllData('m_user')->result_object();
		$objek['page']	= "user";
		
		$this->load->view('admin/index', $objek);
	}
	function tambah_user()
	{
		$objek['title']='List Tambah ';
		$objek['page']	= "user_tambah";
		
		$this->load->view('admin/index', $objek);
	}
	
	function insert_user()
	{
		$config=array(
			'upload_path'=>'fotoprofile',
			'allowed_types'=>'jpg|jpeg|png',
			'max_size'=>5000000,
			'overwrite'=>true
		);
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('user_foto')){
			var_dump($this->upload->display_errors());
			redirect('admin/tambah_user','refresh');
		}else{
		$user_nama = $this->input->post('user_nama');
		$user_username = $this->input->post('user_username');
		$user_password = $this->input->post('user_password');
		$user_foto = $this->upload->data('file_name');
		$user_aksessebagai = $this->input->post('user_aksessebagai');
		$data = array(
				'user_nama' => $user_nama,
				'user_username' => $user_username,
				'user_password' => $user_password,
				'user_foto' => $user_foto,
				'user_aksessebagai' => $user_aksessebagai
			);
		$this->db->insert('m_user', $data);

		redirect('admin/user','refresh');
		}
	}
	function edit_user($id)
	{
		$objek['title']='List user';
		$objek['editdata']	= $this->db->get_where('m_user',array('user_id'=>$id))->result_object();		
		$objek['page']	= "user_edit";
		
		$this->load->view('admin/index', $objek);
	}
	function update_user($id)
	{
		$data = $this->input->post();
		$this->db->where('user_id', $id);
		$this->db->update('m_user', $data); 

		redirect('admin/user','refresh');
	}
	function hapus_user($id)
	{
		
		$this->model_admin->DeleteData('m_user','user_id',$id);
		redirect('admin/user','refresh');
	}
	//---------------------------------transaksi_toko
	function tambah_transaksi(){
		$id = $this->session->userdata('id');
		$nik = $this->session->userdata('nik');
		$autonumb	= $this->model_admin->autonumb_uniq('req_header','reqhed_code','REQ',$nik);
		$reqpoint = $this->db->query("select sum(req_total) as jmlpoint from req_detail where reqhed_code like '%$nik' and YEAR(req_tanggal) like '".date('Y')."%' ")->row();
		$a['reqhead'] = $this->db->query("select count(*) as jml from req_header where kar_id = '$id' and YEAR(reqhed_tanggal) like '".date('Y')."%' ")->row();
		$a['nik'] = $nik;
		$a['title']='Tambah Work Order';
		$a['autonumb']	= $autonumb;
		$a['page']	= "transaksi_tambah";
		if($reqpoint->jmlpoint != NULL) $a['jmlpoint'] = $reqpoint->jmlpoint; else $a['jmlpoint'] = 0;

		$this->load->view('karyawan/index2', $a);
	}
	function tambah_transaksi_sepatu(){
		$id = $this->session->userdata('id');
		$nik = $this->session->userdata('nik');
		$autonumb	= $this->model_admin->autonumb_uniq('req_header','reqhed_code','REQ',$nik);
		$reqpoint = $this->db->query("select sum(req_total) as jmlpoint from req_detail where reqhed_code like '%$nik' and YEAR(req_tanggal) like '".date('Y')."%' ")->row();
		$a['reqhead'] = $this->db->query("select count(*) as jml from req_header where kar_id = '$id' and YEAR(reqhed_tanggal) like '".date('Y')."%' ")->row();
		$a['nik'] = $nik;
		$a['title']='Tambah Work Order';
		$a['autonumb']	= $autonumb;
		$a['page']	= "transaksi_tambah_sepatu";
		if($reqpoint->jmlpoint != NULL) $a['jmlpoint'] = $reqpoint->jmlpoint; else $a['jmlpoint'] = 0;

		$this->load->view('karyawan/index2', $a);
	}

	function getDataKaryawan($id)
	{
		if($id==0){
			echo "null";
		}else{
		$data=$this->db->query("select * from m_karyawan
		where kar_id='$id'")->result();
		foreach($data as $item){
			echo $item->kar_section."|".$item->kar_posisi;
		};
		}
	}

	function insert_transaksi(){
        if(isset($_POST['selesai']))
        {
			//reqhed_code,req_tanggal,trout_jenis,mk_id,kar_section,kar_posisi,mbr_id,req_qty,trout_totalrp
			$reqhed_code = $this->input->post('reqhed_code');
			$reqhed_totalpoint = $this->input->post('reqhed_totalpoint');
			$reqhed_tanggal = $this->input->post('reqhed_tanggal');
			$kar_id = $this->input->post('kar_id');

			$session = array('kar_id', 'section', 'position');
			$this->session->unset_userdata($session);

			$object = array(
					'reqhed_code' => $reqhed_code,
					'reqhed_tanggal' => $reqhed_tanggal,
					'kar_id' => $kar_id,
					'reqhed_totalpoint' => $reqhed_totalpoint,
				);
			$this->db->insert('req_header', $object);
			?>
			<script>
				window.open('<?php echo base_url()?>laporan/cetak_request/<?php echo $reqhed_code?>');
				window.location.replace('<?php echo base_url()?>karyawan/request');
			</script>
			<?php
			// redirect('admin/request','refresh');
        }
        else
        {
			$reqhed_code = $this->input->post('reqhed_code');
			$item_id = $this->input->post('item_id');
			$warna_id = $this->input->post('warna_id');
			$req_qty = $this->input->post('req_qty');
			$size_id = $this->input->post('size_id');
			$data	= $this->db->query("select * from m_item where item_id='$item_id'")->row();
			$req_total = $req_qty*$data->item_point;
			
			$kar_id = $this->input->post('kar_id');
			$section = $this->input->post('section');
			$position = $this->input->post('position');
			$session = array(
				'kar_id' => $kar_id,
				'section' => $section,
				'position' => $position,
			);
			$this->session->set_userdata($session);
			
			$object = array(
				'reqhed_code' => $reqhed_code,
				'item_id' => $item_id,
				'warna_id' => $warna_id,
				'req_qty' => $req_qty,
				'req_total' => $req_total,
				'size_id' => $size_id,
			);
			$this->db->insert('req_detail', $object);
			redirect('karyawan/tambah_transaksi','refresh');
        }
	}
	function hapus_transaksi($id)
	{		
		$this->model_admin->DeleteData('req_detail','reqdet_id',$id);
		redirect('karyawan/tambah_transaksi','refresh');
	}
	function reset_transkaryawan($code){
		$session = array('kar_id', 'section', 'position');
		$this->session->unset_userdata($session);
		$this->model_admin->DeleteData('req_detail','reqhed_code',$code);
		
		redirect('karyawan/tambah_transaksi');
	}
	function detail_karyawan()
	{
		$id = $this->session->userdata('id');
		$nik = $this->session->userdata('nik');
		
		$a['nik'] = $nik;
		$a['title']='Employee Profile';
		$a['page']	= "karyawan_profile";
		

		$this->load->view('karyawan/index2', $a);
	}

	function edit_karyawan()
	{
		$id = $this->session->userdata('id');
		$nik = $this->session->userdata('nik');
		
		$a['nik'] = $nik;
		$a['title']='Employee Profile';
		$a['page']	= "karyawan_addPhoneNumber";
		

		$this->load->view('karyawan/index2', $a);
	}	

	function update_karyawan()
	{
		$data = $this->input->post();

		$id = $this->session->userdata('id');
		$nik = $this->session->userdata('nik');

		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data); 

		redirect('karyawan/tambah_transaksi');
	}
	
}
