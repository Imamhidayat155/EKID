<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$objek['sum_1']=$this->model_admin->Summary('m_user');
		$objek['sum_2']=$this->model_admin->Summary('m_karyawan');
		$objek['sum_3']=$this->model_admin->Summary('req_detail');
		$objek['sum_4']=$this->model_admin->Summary('m_item');
		$objek['title']='Dashboard';
		$objek['page']='home';
		$this->load->view('admin/index',$objek);
	}
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
		if($this->session->userdata('status')==''){
			redirect('login/form');
		}
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
	function request($id)
	{
	
		$objek['title']='List request';
		$objek['data']	= $this->db->query("select a.*,b.*,c.*,d.*
			from req_detail a
			inner join m_item b on a.item_id=b.item_id
			left join m_warna c on a.warna_id=c.warna_id
			left join m_size d on a.size_id=d.size_id
			where reqhed_code='$id'
			")->result_object();
		$objek['page']	= "request";
		
		$this->load->view('admin/index', $objek);
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
	//---------------------------------size
	function size()
	{
	
		$objek['title']='List size';
		$objek['data']	= $this->db->query("select a.*,b.*
		from m_size a
		inner join m_item b on a.item_id=b.item_id
		")->result_object();
		$objek['page']	= "size";
		
		$this->load->view('admin/index', $objek);
	}
	function tambah_size()
	{
		$objek['autonumb']	= $this->model_admin->autonumb('m_size','size_kode','SZ');
		$objek['title']='List size';
		$objek['page']	= "size_tambah";
		
		$this->load->view('admin/index', $objek);
	}
	function insert_size()
	{
		$data = $this->input->post();
		$this->db->insert('m_size', $data);
		redirect('admin/size','refresh');
	}
	function edit_size($id)
	{
		$objek['title']='List size';
		$objek['editdata']	= $this->db->get_where('m_size',array('size_id'=>$id))->result_object();		
		$objek['page']	= "size_edit";
		
		$this->load->view('admin/index', $objek);
	}
	function update_size($id)
	{
		$data = $this->input->post();
		$this->db->where('size_id', $id);
		$this->db->update('m_size', $data); 

		redirect('admin/size','refresh');
	}
	function hapus_size($id)
	{
		
		$this->model_admin->DeleteData('m_size','size_id',$id);
		redirect('admin/size','refresh');
	}
	//---------------------------------warna
	function warna()
	{
	
		$objek['title']='List warna';
		$objek['data']	= $this->db->query("select a.*,b.*
		from m_warna a
		inner join m_item b on a.item_id=b.item_id
		")->result_object();
		$objek['page']	= "warna";
		
		$this->load->view('admin/index', $objek);
	}
	function tambah_warna()
	{
		$objek['autonumb']	= $this->model_admin->autonumb('m_warna','warna_kode','WR');
		$objek['title']='List warna';
		$objek['page']	= "warna_tambah";
		
		$this->load->view('admin/index', $objek);
	}
	function insert_warna()
	{
		$data = $this->input->post();
		$this->db->insert('m_warna', $data);
		redirect('admin/warna','refresh');
	}
	function edit_warna($id)
	{
		$objek['title']='List warna';
		$objek['editdata']	= $this->db->get_where('m_warna',array('warna_id'=>$id))->result_object();		
		$objek['page']	= "warna_edit";
		
		$this->load->view('admin/index', $objek);
	}
	function update_warna($id)
	{
		$data = $this->input->post();
		$this->db->where('warna_id', $id);
		$this->db->update('m_warna', $data); 

		redirect('admin/warna','refresh');
	}
	function hapus_warna($id)
	{
		
		$this->model_admin->DeleteData('m_warna','warna_id',$id);
		redirect('admin/warna','refresh');
	}
	//---------------------------------item
	function item()
	{
	
		$objek['title']='List item';
		$objek['data']	= $this->model_admin->GetAllData('m_item')->result_object();
		$objek['page']	= "item";
		
		$this->load->view('admin/index', $objek);
	}
	function tambah_item()
	{
		$objek['autonumb']	= $this->model_admin->autonumb('m_item','item_kode','IT');
		$objek['title']='List item';
		$objek['page']	= "item_tambah";
		
		$this->load->view('admin/index', $objek);
	}
	function insert_item()
	{
		$data = $this->input->post();
		$this->db->insert('m_item', $data);
		redirect('admin/item','refresh');
	}
	function edit_item($id)
	{
		$objek['title']='List item';
		$objek['editdata']	= $this->db->get_where('m_item',array('item_id'=>$id))->result_object();		
		$objek['page']	= "item_edit";
		
		$this->load->view('admin/index', $objek);
	}
	function update_item($id)
	{
		$data = $this->input->post();
		$this->db->where('item_id', $id);
		$this->db->update('m_item', $data); 

		redirect('admin/item','refresh');
	}
	function hapus_item($id)
	{
		
		$this->model_admin->DeleteData('m_item','item_id',$id);
		redirect('admin/item','refresh');
	}
	//---------------------------------karyawan
	function karyawan()
	{
	
		$objek['title']	='List Karyawan';
		$objek['data']	= $this->model_admin->GetAllData('m_karyawan')->result_object();
		$objek['page']	= "karyawan";
		
		$this->load->view('admin/index', $objek);
	}
	function tambah_karyawan()
	{
		$objek['title']	='Tambah Karyawan';
		$objek['page']	= "karyawan_tambah";
		
		$this->load->view('admin/index', $objek);
	}
	function insert_karyawan()
	{
		$data = $this->input->post();
		$this->db->insert('m_karyawan', $data);
		redirect('admin/karyawan','refresh');
	}
	function edit_karyawan($id)
	{
		$objek['title']='Edit Karyawan';
		$objek['editdata']	= $this->db->get_where('m_karyawan',array('kar_id'=>$id))->result_object();		
		$objek['page']	= "karyawan_edit";
		
		$this->load->view('admin/index', $objek);
	}
	function update_karyawan($id)
	{
		$data = $this->input->post();
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data); 

		redirect('admin/karyawan','refresh');
	}
	function hapus_karyawan($id)
	{		
		$this->model_admin->DeleteData('m_karyawan','kar_id',$id);
		redirect('admin/karyawan','refresh');
	}
	function aktif_karyawan($id)
	{
		$data = array('is_active'=> 1);
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data); 

		redirect('admin/karyawan','refresh');
	}
	function nonaktif_karyawan($id)
	{
		$data = array('is_active'=> 0);
		$this->db->where('kar_id', $id);
		$this->db->update('m_karyawan', $data); 

		redirect('admin/karyawan','refresh');
	}
	function aktif_all_karyawan()
	{
		$this->db->query("update m_karyawan set is_active=1"); 

		redirect('admin/karyawan','refresh');
	}
	function nonaktif_all_karyawan()
	{
		$this->db->query("update m_karyawan set is_active=0"); 

		redirect('admin/karyawan','refresh');
	}

	//---------------------------------user
	function user()
	{
	
		$objek['title']='List User';
		$objek['data']	= $this->model_admin->GetAllData('m_user')->result_object();
		$objek['page']	= "user";
		
		$this->load->view('admin/index', $objek);
	}
	function tambah_user()
	{
		$objek['title']='Tambah User';
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
		$objek['title']='Edit User';
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
	//---------------------------------transaksi_Request
	function transaksi(){
		$a['title']='List Transaksi';
		$a['data']	= $this->db->query("select a.*,b.*
		from req_header a
		inner join m_karyawan b on a.kar_id=b.kar_id
		")->result_object();
		$a['page']	= "list_transaksi";
		
		$this->load->view('admin/index', $a);
	}
	function tambah_transaksi(){
		$a['title']='Tambah Work Order';
		$a['autonumb']	= $this->model_admin->autonumb('req_header','reqhed_code','REQ');
		$a['page']	= "transaksi_tambah";
		
		$this->load->view('admin/index', $a);
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
				window.location.replace('<?php echo base_url()?>admin/transaksi');
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
			$data	= $this->db->query("select * from m_item where item_id='$item_id'")->result_object();
			
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
				'size_id' => $size_id,
			);
			$this->db->insert('req_detail', $object);
			redirect('admin/tambah_transaksi','refresh');
        }
	}
	function hapus_transaksi($id)
	{		
		$this->model_admin->DeleteData('req_detail','reqdet_id',$id);
		redirect('admin/tambah_transaksi','refresh');
	}
	function hapus_header($id)
	{		
		$this->model_admin->DeleteData('req_header','reqhed_code',$id);
		$this->model_admin->DeleteData('req_detail','reqhed_code',$id);
		redirect('admin/transaksi','refresh');
	}
	function reset_transkaryawan($code){
		$session = array('kar_id', 'section', 'position');
		$this->session->unset_userdata($session);
		$this->model_admin->DeleteData('req_detail','reqhed_code',$code);
		
		redirect('admin/tambah_transaksi');
	}	
}
