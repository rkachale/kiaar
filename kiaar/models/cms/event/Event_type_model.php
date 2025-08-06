<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_event_type_list($conditions=[])
    {
        $this->db->select('*');
        $this->db->from('event_type');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('public !=', '-1');
        $this->db->order_by('event_type_id', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'event_type';
        
        $res                        = $this->db->insert($table, $data);
        
        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = '';
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
        $table                      = 'event_type';
        
        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata);

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
            
        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata('user_id');

        $table      = 'event_type';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
}