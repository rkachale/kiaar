<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model{
	function __construct() {
		$this->tableName = 'users_test';
		$this->primaryKey = 'id';
	}
	public function checkUser($data = array()){
		$this->db->select($this->primaryKey);
		$this->db->from($this->tableName);
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$query = $this->db->get();
		$check = $query->num_rows();
		
		if($check > 0){
			$result = $query->row_array();
			$data['modified'] = date("Y-m-d H:i:s");
			$update = $this->db->update($this->tableName,$data,array('id'=>$result['id']));
			$userID = $result['id'];
		}else{
			$data['created'] = date("Y-m-d H:i:s");
			$data['modified'] = date("Y-m-d H:i:s");
			$insert = $this->db->insert($this->tableName,$data);
			$userID = $this->db->insert_id();
		}

		return $userID?$userID:false;
    }

    public function checkUserSomaiya($data = array()){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where(array('email'=>$data['email']));
		$query = $this->db->get();
		// $check = $query->num_rows();
		
		  $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
		  return $result;
    }
}
