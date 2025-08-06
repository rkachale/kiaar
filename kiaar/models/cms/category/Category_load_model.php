<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_load_model extends CI_Model {
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }


function get_category($public)
    {   

     
        $this->db->where('category.public !=', $public);
        $this->db->select("*");
        $this->db->from('category');
        $this->db->order_by('category_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


function get_category_details($id='',$public)
    {
        $this->db->select('*,category.category_name as name');
        $this->db->from('category');
        $this->db->where('category.category_id', $id);
        $this->db->where('category.public !=', $public);
    
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }

function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'category';

        $res                        = $this->db->insert($table, $data['category']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
        
            $response['status']     = 'success';
            $response['category_id']         = $insert_id;
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
        $table                      = 'category';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $update                     = $this->db->update($table, $updatedata['category']);

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



 function _delete($conditions=[]) {
            
        $update['public']            = -1;
        $table      = 'category';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

}
?>