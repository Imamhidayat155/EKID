<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

//---------------------------------Lap Pemesanan
	public function export_pemesanan()
	{
		$a['title']='Laporan Pemesanan';
		$a['data']	= $this->db->query("select a.*,b.*
		from tr_keluar a
		inner join m_member b on a.mbr_id=b.mbr_id
		")->result_object();
		$this->load->view('laporan/export_pemesanan',$a);
	}
	public function preview_pemesanan()
	{
		$a['title']='Laporan Pemesanan';
		$a['data']	= $this->db->query("select a.*,b.*
		from tr_keluar a
		inner join m_member b on a.mbr_id=b.mbr_id
		")->result_object();
		$this->load->view('laporan/preview_pemesanan',$a);
	}
//---------------------------------Lap Stok
	public function export_stok()
	{
		$a['title']='Laporan Stok';
		$a['data']	= $this->db->query("select a.*,b.*
		from tr_masuk a
		inner join m_product b on a.pr_id=b.pr_id
		")->result_object();
		$this->load->view('laporan/export_stok',$a);
	}
	public function preview_stok()
	{
		$a['title']='Laporan Stok';
		$a['data']	= $this->db->query("select a.*,b.*
		from tr_masuk a
		inner join m_product b on a.pr_id=b.pr_id
		")->result_object();
		$this->load->view('laporan/preview_stok',$a);
	}

//---------------------------------export
	function export_cetakgaji()
	{
		$objek['title']='Export Cetak Gaji';
		$objek['data']	= $this->db->query("select a.*,b.*,c.*,d.*
		from tr_gaji a
		inner join m_guru b on a.guru_id=b.guru_id
		inner join m_absensi c on b.guru_id=c.guru_id
		inner join m_gaji d on b.guru_id=d.guru_id
		where gj_delete!='Y'
		")->result_object();
		$page	= "export_cetakgaji";
		
		$this->load->view('laporan/'.$page, $objek);
	}
	function lap_pr()
	{
		$objek['title']='Laporan Purchase Request';
		$objek['data']	= $this->model_admin->tampil_purchaserequest()->result_object();
		$objek['page']	= "lap_prx";
		
		$this->load->view('admin/index', $objek);
	}
	function lap_prexport()
	{
		$objek['title']='Export Purchase Request';
		$objek['data']	= $this->model_admin->tampil_purchaserequest()->result_object();
		$page	= "lap_prexportx";
		
		$this->load->view('laporan/'.$page, $objek);
	}
	function lap_exmember()
	{
		$objek['title']='Export Data Member';
		$objek['data']	= $this->model_admin->tampil_lapmember()->result_object();
		$page	= "export_member";
		
		$this->load->view('laporan/'.$page, $objek);
	}
	function lap_exprogres()
	{
		$objek['title']='Export Data Progres';
		$objek['data']	= $this->model_admin->tampil_lapprogres()->result_object();
		$page	= "export_progres";
		
		$this->load->view('laporan/'.$page, $objek);
	}
	
	function lap_prpreview($id)
	{
		$objek['title']='Preview Detail Purchase Request';
		$objek['editdata']	= $this->db->query("select a.*,b.*
		from tr_purchaserequest a
		inner join m_user b on a.user_id=b.user_id
		where pr_id='$id'
		")->result_object();
		$objek['data']	= $this->model_admin->tampil_purchaserequestdetail($id)->result_object();
		$page	= "lap_prpreviewx";
		//$this->load->view('laporan/'.$page, $objek);
		$to_convert=$this->load->view('laporan/'.$page, $objek,true);
		$this->mpdf = new mPDF ('','',0,'',10,10,8,5,8,8);
		$this->mpdf->WriteHTML($to_convert);
		$this->mpdf->Output();
	}
//---------------------------------Lap Pemesanan
	
	public function export_request()
	{
		$object['title']='Laporan Request';
		$object['data']=$this->db->query("select a.*,b.*,c.*,d.*,e.*,f.*
		from req_detail a
		inner join m_item b on a.item_id=b.item_id
		left join m_warna c on a.warna_id=c.warna_id
		left join m_size d on a.size_id=d.size_id
		inner join req_header e on a.reqhed_code=e.reqhed_code
		inner join m_karyawan f on e.kar_id=f.kar_id
		")->result_object();
		$this->load->view('laporan/export_cetakrequest',$object);
	}
	function cetak_request($id)
	{
		$this->load->library('mpdf/mpdf');
		$objek['title']='PT. ENKEI INDONESIA';
		$objek['data']	= $this->db->query("select a.*,c.*
		from req_header a
		inner join m_karyawan c on a.kar_id=c.kar_id
		where a.reqhed_code='$id'
		")->result_object();
		
		$page	= "print_cetakrequest";
		//$this->load->view('laporan/'.$page, $objek);
		$to_convert=$this->load->view('laporan/'.$page, $objek,true);
		$this->mpdf = new mPDF ('',array(200,140),0,'',10,10,8,5,8,8);
		$this->mpdf->WriteHTML($to_convert);
		$this->mpdf->Output();
	}
	function export_data_karyawan (){
		$object['title']='Data Karyawan';
		$object['data']=$this->model_admin->GetAllData('m_karyawan')->result_object();
		$this->load->view('laporan/export_datakaryawan',$object);
	}
	
}
