<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_admin extends CI_Model {

	
	public function SumData($tb,$field)
	{
		return $this->db->query("select sum($field)as total from $tb");
	}
	public function Summary($tb)
	{
		return $this->db->get($tb)->num_rows();
	}
	public function GetAllData($tb)
	{
		return $this->db->get($tb);
	}
	public function GetAllData1($tb,$fl,$id)
	{
		return $this->db->query("select * from $tb where $fl='$id'");
	}
	public function DeleteData($tb,$pk,$id)
	{
		return $this->db->delete($tb, array($pk => $id));
	}
	public function detail_data($id = NULL)
	{
		return $this->db->get_where('m_karyawan', array('kar_id' => $id))->row();
	}

//---------------------------Login
	public function cek_login($table,$where)
	{
		return $this->db->get_where($table,$where);
	}
	
//---------------------------Autonumb
	public function autonumb($table,$fld,$code) 
	{ 
        $q = $this->db->query("SELECT max(right(".$fld.",3)) AS idmax FROM ".$table);
        $urut = ""; //no urut
        if($q->num_rows()>0){ //jika data ada
            foreach($q->result() as $k){
				
                $tmp = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
                $urut = sprintf("%03s", $tmp); //kode ambil 4 karakter terakhir
            }
        }else{ //jika data kosong diset ke kode awal
            $urut = "001";
        }
        //gabungkan string dengan kode yang telah dibuat tadi
        return $code.$urut;
	} 
	public function autonumb_uniq($table,$fld,$code,$nik) 
	{ 
		$q = $this->db->query("SELECT max(right(substring_index(".$fld.",'-',1),3)) AS idmax FROM $table where $fld like '%$nik'");
		$urut = ""; //no urut
		if($q->num_rows()>0){ //jika data ada
			foreach($q->result() as $k){
				
				$tmp = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
				$urut = sprintf("%03s", $tmp); //kode ambil 4 karakter terakhir
			}
		}else{ //jika data kosong diset ke kode awal
			$urut = "001";
		}
		//gabungkan string dengan kode yang telah dibuat tadi
		return $code.$urut."-".$nik;
	} 

}
