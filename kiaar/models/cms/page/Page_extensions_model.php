<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page_extensions_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

      function get_page($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id');
        $this->db->where('page.page_id', $id);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }

      function get_all_page_institute($id)
    {
        $this->db->select("*, page.created_date as created_date ,page.public as public");
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id','left');
        $this->db->join('users', 'users.user_id=extensions.user_id','left');
        $this->db->order_by('page.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


      function save($post_id='', $id='', $save=[])
    {   
        $msg = ['error' => 1, 'message' => 'Invalid request'];
        if(!empty($save))
        {
            $post_content = $this->check_extensions_content($post_id, '', $save['language_id']);
            if(!empty($post_content))
            {
                $save['updated_date']   = date('Y-m-d H:i:s');
                $save['user_id']        = $this->session->userdata['user_id'];
                $this->db->where('extension_id', $id);
                $this->db->update('extensions', $save);
            }
            else
            {
                $save['created_date'] = date('Y-m-d H:i:s');
                $save['user_id'] = $this->session->userdata['user_id'];
                $this->db->insert('extensions', $save);
            }

            if($this->db->affected_rows())
            {
                  $response['status']     = 'success';
            }
            else
            {
                  $response['status']     =  'error';
                  // $response['message']    = $this->db->_error_message();
            }
        }
        return $response;
    }

      function check_extensions_content($post_id='', $id='', $language='')
    {
        $this->db->select('*');
        $this->db->from('extensions');
        $this->db->where('relation_id', $post_id);
        $this->db->where('language_id', $language);
        if(!empty($id))
        {
            $this->db->where('contents_id', $id);
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }
function _delete($pressrelease_id, $contents_id) { 
 
        $table      = 'extensions';
        $this->db->where('relation_id', $pressrelease_id);
        $this->db->where('extension_id', $contents_id);
        $res        = $this->db->delete($table);
        $str        = $this->db->last_query();
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted '.$contents_id : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    

 /*   function _delete($col, $val) {
            
        $update['public']            = -1;
        //$update['updated_date']      = date('Y-m-d H:i:s');
        //$update['user_id']           = $this->session->userdata('user_id');

        $table      = 'post';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }*/
}