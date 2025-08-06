<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

      function get_page($id='', $public='')
    {
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id');
        $this->db->where('page.page_id', $id);
        $this->db->where('page.public!=', $public);
       /* if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }*/
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }

      function get_all_page_institute($id='',$public='')
    {
        $this->db->select("*, page.created_date as created_date ,page.public as public");
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id','left');
        $this->db->join('users', 'users.user_id=extensions.user_id','left');
                $this->db->where('page.public!=', $public);
        $this->db->order_by('page.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'page';
        $table2                     = 'extensions';
        $res                        = $this->db->insert($table, $data['page']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['extensions']['relation_id']      = $insert_id;
            $res                        = $this->db->insert($table2, $data['extensions']);
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


    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'page';
        $table2                     = 'extensions';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['page']);
        if($update)
        {
            $this->db->where('extension_id', $updatedata['extensions']['extension_id']);
            $this->db->update($table2, $updatedata['extensions']);
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
            
        $update['public']            = -1;
        $table      = 'page';
        $this->db->where($col, $val);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
}