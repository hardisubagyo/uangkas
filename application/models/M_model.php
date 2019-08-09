<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
		date_default_timezone_set('Asia/Jakarta');
	}

	function read($table, $where = null, $orderby = null, $limit = null, $page = null){
		$this->db->select("*");
		$this->db->from($table);

		if($where != null){
			$this->db->where($where);
		}

		if($orderby != null){
			$this->db->order_by($orderby);
		}

		if($limit != null && $page == null){
			$this->db->limit($limit);
		}

		if($limit != null && $page != null){
			$this->db->limit($limit, $page);
		}

		return $this->db->get();
	}

	function insert($tabel, $data){
		$this->db->insert($tabel,$data);
		if ($this->db->affected_rows() > 0 ) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function update($table, $data, $where){
		return $this->db->update($table, $data, $where);
	}

	function delete($table, $where){
		return $this->db->delete($table, $where);
	}

}
