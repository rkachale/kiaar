<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    function get_galtype()
    {
        $this->db->select("*");
        $this->db->from('galleries_type');
         $this->db->where('public !=','-1');
        $this->db->order_by('id','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
   function get_galtype_detail($id)
    {
        $this->db->select('*');
        $this->db->from('galleries_type');
        $this->db->where('id', $id);
          $this->db->where('public', '1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
   function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'galleries_type';

        $res                        = $this->db->insert($table, $data['galleries_type']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
        
            $response['status']     = 'success';
            $response['id']         = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }


  function _update($conditions=[], $updatedata) {
        $response['status']         = 'error';
        $table                      = 'galleries_type';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $update                     = $this->db->update($table, $updatedata['galleries_type']);

        if($update)
        {

            $response['status']     = 'success';
            $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }

    function _delete($col, $val) {
            
        $update['public']       = -1;
        $update['modified_on']  = date('Y-m-d H:i:s');
        $update['modified_by']  = $this->session->userdata('user_id');

        $table      = 'galleries_type';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
}