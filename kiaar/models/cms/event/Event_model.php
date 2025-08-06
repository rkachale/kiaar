<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_event_list($conditions=[])
    {
        $this->db->select('e.*, ec.contents_id, ec.description,ec.language_id');
        $this->db->from('event_new e');
        $this->db->join('eventcontents_new ec','e.event_id = ec.event_id','left');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('ec.language_id',1);
        $this->db->where('e.public !=', '-1');
        $this->db->order_by('e.event_id', 'DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'event_new';
        $table2                     = 'eventcontents_new';

        $res                        = $this->db->insert($table, $data['event']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['contents']['event_id']      = $insert_id;
            
            $res                        = $this->db->insert($table2, $data['contents']);

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
        $table                      = 'event_new';
        $table2                     = 'eventcontents_new';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['event']);

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // echo "<br>----------------<br>";

        if($update)
        {
            $this->db->where('contents_id', $updatedata['contents']['contents_id']);
            $this->db->update($table2, $updatedata['contents']);

            // $str1 = $this->db->last_query();
            // echo "<pre>";
            // print_r($str1);
            // echo "<br>----------------<br>";

            // exit();

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

    function delete_image($id, $update)
    {
        // $update['image']            = null;
        // $update['modified_on']      = date('Y-m-d H:i:s');
        // $update['modified_by']      = $this->session->userdata('user_id');

        $this->db->where('event_id', $id);
        $this->db->update('event_new', $update);

        return $this->db->affected_rows();
    }

    function _delete($col, $val) {
            
        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata('user_id');

        $table      = 'event_new';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function get_all_event_type_list()
    {
        $this->db->select('*');
        $this->db->from('event_type');
        $this->db->where('public =', '1');
        $this->db->order_by('event_type_name', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_audience_type_list()
    {
        $this->db->select('*');
        $this->db->from('event_audience_type');
        $this->db->where('public =', '1');
        $this->db->order_by('audience_name', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
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

    function get_departments()
    {
        $this->db->select("d.Department_Id, d.Department_Name");
        $this->db->from('edu_department_dir d');
    
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
}