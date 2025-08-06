<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Farmers_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_farmers_list($conditions=[])
    {
        $this->db->select('e.*');
        $this->db->from('nabard_farmers_master e');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('e.FIRST_NAME', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'nabard_farmers_master';

        $res                        = $this->db->insert($table, $data['farmers']);
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

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'nabard_farmers_master';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['farmers']);

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

    function get_table_data($table, $conditions)
    {
        $this->db->select('*');
        $this->db->from($table);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function _delete($col, $val) 
    {
        $table      = 'nabard_farmers_master';
        $this->db->where($col, $val);
        $res        = $this->db->delete($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function farmer_data_save($id,$data)
    {
        if($id!='')
        {
            $this->db->where('id', $id);            
            if($this->db->update('nabard_farmers_master', $data))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            if($this->db->insert('nabard_farmers_master', $data))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }

}