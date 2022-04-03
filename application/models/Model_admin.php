<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_admin extends CI_Model {

	
	public function SumData($tb,$field)
	{
		return $this->db->query("select sum($field)as total from $tb");
	}
	public function count_data($tb,$field,$where)
	{
		$sql= "SELECT count($field) as total FROM $tb WHERE status = $where";
		$result= $this->db->query($sql); 
		return $result->row()->total;

	}
	public function count_data_today($tb,$field,$where)
	{
		$sql= "SELECT count($field) as total FROM $tb WHERE status = 2 && created = '$where'";
		$result= $this->db->query($sql); 
		return $result->row()->total;

	}
	public function Summary($tb)
	{
		return $this->db->get($tb)->num_rows();
	}
	

	public function count_status_CT_wait_approve_leader($dep_id){
		$sql	= "SELECT tr_permohonan_cuti.kar_id AS kar_id,count(tr_permohonan_cuti.pc_lamacuti) AS total from ((tr_permohonan_cuti join m_karyawan on(tr_permohonan_cuti.kar_id = m_karyawan.kar_id)) join m_departement on(m_karyawan.dep_id = m_departement.dep_id)) where tr_permohonan_cuti.cuti_kode = 'CT' and tr_permohonan_cuti.pc_status = 1 and m_karyawan.dep_id = $dep_id and m_karyawan.akses_id < 3 group by tr_permohonan_cuti.kar_id";

		$result = $this->db->query($sql); 
		return $result->row()->total;

	}
	public function count_cuti_wait_approve_leader($tb,$kar_id) //COUNTING CUTI KARYAWAN BELUM APPROVE
	{
		$sql 	= "SELECT count(kar_id) as kar_id FROM $tb WHERE (pc_status = 1 && kar_id = $kar_id) || (pc_status = 2 && kar_id = $kar_id) || (pc_status = 6 && kar_id = $kar_id)";
		$result = $this->db->query($sql); 
		return $result->row()->kar_id;
	}
	public function count_cuti_sudah_diapprove($tb,$kar_id) //COUNTING CUTI KARYAWAN BELUM APPROVE
	{
		$sql 	= "SELECT count(kar_id) as kar_id FROM $tb WHERE (pc_status = 3 && kar_id = $kar_id) || (pc_status = 4 && kar_id = $kar_id) || (pc_status = 5 && kar_id = $kar_id) || (pc_status = 7 && kar_id = $kar_id)";
		$result = $this->db->query($sql); 
		return $result->row()->kar_id;
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
	
//---------------------------AUTONUMB
	public function autonumb($table,$fld,$code) 
	{ 
        $q = $this->db->query("SELECT max(right(".$fld.",5)) AS idmax FROM ".$table);
        $urut = ""; //no urut
        if($q->num_rows()>0){ //jika data ada
            foreach($q->result() as $k){
				
                $tmp = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
                $urut = sprintf("%05s", $tmp); //kode ambil 4 karakter terakhir
            }
        }else{ //jika data kosong diset ke kode awal
            $urut = "00001";
        }
        //gabungkan string dengan kode yang telah dibuat tadi
        return $code.$urut;
	} 


//---------------------------AUTONUMB
	public function autonumb_pc($table, $fld, $code, $kar_id) 
	{ 
		$q = $this->db->query("SELECT max(right(".$fld.",5)) AS idmax FROM ".$table." where kar_id='$kar_id'");
		$urut = ""; //no urut
		if($q->num_rows()>0){ //jika data ada
			foreach($q->result() as $k){
				
				$tmp = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
				$urut = sprintf("%05s", $tmp); //kode ambil 4 karakter terakhir
			}
		}else{ //jika data kosong diset ke kode awal
			$urut = "00001";
		}
		//gabungkan string dengan kode yang telah dibuat tadi
		return $code.$kar_id.$urut;
	} 


//---------------------------AUTONUMB
	public function autonumb2($table,$fld,$code) 
	{ 
        $q = $this->db->query("SELECT max(right(".$fld.",5)) AS idmax FROM ".$table);
        $urut = ""; //no urut
        if($q->num_rows()>0){ //jika data ada
            foreach($q->result() as $k){
				
                $tmp = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
                $urut = sprintf("%05s", $tmp); //kode ambil 4 karakter terakhir
            }
        }else{ //jika data kosong diset ke kode awal
            $urut = "0001";
        }
        //gabungkan string dengan kode yang telah dibuat tadi
        return $code.$urut;
	}

//---------------------------AUTONUMB CUTI
	public function autonumbSt($table,$fld,$code,$id) 
	{ 
		$q = $this->db->query("SELECT max(RIGHT(".$fld.",3)) AS idmax FROM ".$table." WHERE kar_id = '$id'");
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
		return $code."-".$urut;
	} 


//---------------------------AUTONUMB UNIQ
	public function autonumb_uniq($table,$fld,$code,$nik) 
	{ 
		$q = $this->db->query("SELECT max(right(substring_index(".$fld.",'-',1),3)) AS idmax FROM $table WHERE $fld LIKE '%$nik'");
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
		return $code.$nik."-".$urut;
	} 

	
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%m' )
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);
	
		$interval  = date_diff($datetime1, $datetime2);
	
		return $interval->format($differenceFormat);
	
	}

}
