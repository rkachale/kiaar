<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Projects_category_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }



function get_Category($public)
    {   

    
        $this->db->where('project_category.status !=', $public);
        $this->db->select("*");
        $this->db->from('project_category');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }



function get_category_details($id='',$public)
    {
        $this->db->select('*,project_category.category_name as name');
        $this->db->from('project_category');
        $this->db->where('project_category.id', $id);
        $this->db->where('project_category.status !=', $public);
    
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }


function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'project_category';

        $res                        = $this->db->insert($table, $data['project_category']);
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
        $table                      = 'project_category';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $update                     = $this->db->update($table, $updatedata['project_category']);

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
            
        $update['status']            = -1;
        $table      = 'project_category';
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

