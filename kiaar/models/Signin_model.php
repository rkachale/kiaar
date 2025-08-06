<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signin_model extends CI_Model {
	public function check_mobile($mobile) 
	{	
		echo "<pre>";print_r($mobile);exit;
		$this->db->where(['MOBILE_NO' => $mobile]);
		$query 	= $this->db->get('nabard_farmers_master');
		$result = $query->num_rows();
		return $result;
	}

	public function update_otp($mobile, $data) 
	{
		return $this->db->update('nabard_farmers_master', $data, ["MOBILE_NO"=>$mobile]);
	}

	public function verify($mobile, $otp) 
	{
		$data = [];
		$this->db->where([MOBILE_NO => $mobile, otp => $otp]);
		$query = $this->db->get('nabard_farmers_master');
		$result = $query->row();
		if($result) {
			$data = [
				'login_id' 	=> $result->id,
				'login_name' 	=> $result->name,
				'login_mobile' 	=> $result->mobile,
				'login_status' 	=> TRUE,
			];
		}
		return $data;
	}
}
