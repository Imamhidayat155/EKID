<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Select extends CI_Controller {

    function __construct(){
        parent::__construct();
    }

	public function getSelect_Item() {

		$this->db->select( '*' );
		$this->db->from( 'm_item' );
		$result = $this->db->get();

		$return_array = array();
		if ($result->num_rows() < 1) {
			return null;
		} else {
			$return_array['data'] = $result->result_array();
		}

		echo json_encode($return_array);
	}
	public function getSelect_Warna() {

		$item_id = $this->input->post('item_id');
		if ( $item_id != NULL ) {
			$this->db->where( 'item_id' , $item_id );
		}
		$this->db->select( '*' );
		$this->db->from( 'm_warna' );
		$result = $this->db->get();

		$return_array = array();
		if ($result->num_rows() < 1) {
			return null;
		} else {
			$return_array['data'] = $result->result_array();
		}

		echo json_encode($return_array);
	}
	public function getSelect_Size() {

		$item_id = $this->input->post('item_id');
		if ( $item_id != NULL ) {
			$this->db->where( 'item_id' , $item_id );
		}
		$this->db->select( '*' );
		$this->db->from( 'm_size' );
		$result = $this->db->get();

		$return_array = array();
		if ($result->num_rows() < 1) {
			return null;
		} else {
			$return_array['data'] = $result->result_array();
		}

		echo json_encode($return_array);
	}

}
