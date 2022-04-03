<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

	//---------------------------------Lap Pemesanan

	public function export_request()
	{
		$object['title'] = 'Laporan Pengajuan Cuti';
		$object['data'] = $this->db->query("SELECT a.*,b.*,c.*
		FROM req_detail a
		INNER JOIN m_item b on a.item_id=b.item_id
		LEFT join m_warna c on a.warna_id=c.warna_id
		")->result_object();
		$this->load->view('laporan/export_cetakrequest', $object);
	}
	function detail_ct($id)
	{
		//$this->load->library('mpdf/mpdf');
		$objek['title'] = 'PT. ENKEI INDONESIA';

		$this->db->select('a.kar_id as id_kar, a.kar_nama, a.kar_nik, a.kar_tanggalmasuk, b.dep_nama, c.penambahan_cuti_jatahcuti');
		$this->db->from('m_karyawan a');
		$this->db->join('m_departement b', 'a.dep_id=b.dep_id');
		$this->db->join('tr_penambahancuti c', 'a.kar_id=c.kar_id');
		$this->db->where('a.kar_id', $id);
		$this->db->where('c.cuti_id', 1);
		$sql = $this->db->get('');
		$objek['data']	= $sql->result();
		
		$this->load->view('laporan/print_detail_CT',$objek);
		//$page	= "print_cetakrequest";
		//$this->load->view('laporan/'.$page, $objek);
		// $to_convert = $this->load->view('laporan/' . $page, $objek, true);
		// $this->mpdf = new mPDF('', array(200, 140), 0, '', 10, 10, 8, 5, 8, 8);
		// $this->mpdf->WriteHTML($to_convert);
		// $this->mpdf->Output();
	}
	function detail_cp($id)
	{
		//$this->load->library('mpdf/mpdf');
		$objek['title'] = 'PT. ENKEI INDONESIA';

		$this->db->select('a.kar_id as id_kar, a.kar_nama, a.kar_nik, a.kar_tanggalmasuk, b.dep_nama, c.penambahan_cuti_jatahcuti');
		$this->db->from('m_karyawan a');
		$this->db->join('m_departement b', 'a.dep_id=b.dep_id');
		$this->db->join('tr_penambahancuti c', 'a.kar_id=c.kar_id');
		$this->db->where('a.kar_id', $id);
		$this->db->where('c.cuti_id', 2);
		$sql = $this->db->get('');		
		$objek['data']	= $sql->result();
		
		$this->load->view('laporan/print_detail_CP',$objek);
		//$page	= "print_cetakrequest";
		//$this->load->view('laporan/'.$page, $objek);
		// $to_convert = $this->load->view('laporan/' . $page, $objek, true);
		// $this->mpdf = new mPDF('', array(200, 140), 0, '', 10, 10, 8, 5, 8, 8);
		// $this->mpdf->WriteHTML($to_convert);
		// $this->mpdf->Output();
	}
	function export_data_karyawan()
	{
		$object['title'] = 'Data Karyawan';
		$object['data'] = $this->db->query("SELECT a.*,b.*,c.*,d.*
						FROM m_karyawan a
						INNER JOIN m_jabatan b ON a.jab_id=b.jab_id
						INNER JOIN m_departement c ON a.dep_id=c.dep_id
						LEFT JOIN  m_plant d ON a.plant_id=d.plant_id
						")->result_object();
		$this->load->view('laporan/export_datakaryawan', $object);
	}
	function export_data_plant()
	{
		$object['title'] = 'Data Plant';
		$object['data'] = $this->model_admin->GetAllData('m_plant')->result_object();
		$this->load->view('laporan/export_dataplant', $object);
	}
}
