<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event_content_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_event_contents($event_id)
    {
        $this->db->select('ec.*,l.code as language_code');
        $this->db->from('eventcontents_new ec');
        $this->db->join('languages l', 'ec.language_id = l.language_id','left');
        $this->db->where('ec.event_id', $event_id);
        $this->db->where('ec.public !=', '-1');
        $this->db->order_by('ec.contents_id', 'DESC');
        $query = $this->db->get();

        //$str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;

        return $query->result_array();
    }

    function get_details($event_id='', $id='')
    {
        $this->db->select('*');
        $this->db->from('eventcontents_new');
        $this->db->where('event_id', $event_id);
        $this->db->where('contents_id', $id);
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function save($event_id='', $id='', $save=[])
    {   
        $msg = ['error' => 1, 'message' => 'Invalid request'];
        if(!empty($save))
        {
            $event_content = $this->check_event_content($event_id, '', $save['language_id']);

            // print_r($event_content);
            // exit();
            if(!empty($event_content))
            {
                $save['modified_on']   = date('Y-m-d H:i:s');
                $save['modified_by']   = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $event_content['contents_id']);
                $this->db->update('eventcontents_new', $save);
            }
            else
            {
                $save['created_on'] = date('Y-m-d H:i:s');
                $save['created_by'] = $this->session->userdata['user_id'];
                $this->db->insert('eventcontents_new', $save);
            }

            if($this->db->affected_rows())
            {
                $msg = ['error' => 0, 'message' => 'Event content successfully saved'];
            }
            else
            {
                $msg = ['error' => 1, 'message' => 'Unable to save an event content'];
            }
        }
        return $msg;
    }

    function check_event_content($event_id='', $id='', $language='')
    {
        $this->db->select('*');
        $this->db->from('eventcontents_new');
        $this->db->where('event_id', $event_id);
        $this->db->where('language_id', $language);
        if(!empty($id))
        {
            $this->db->where('contents_id', $id);
        }
        // if($this->session->userdata('role') != 1)
        // {
        //     $this->db->where('created_by', $this->session->userdata('user_id'));
        // }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }

    function check_content_by_lang($event_id, $event_content_id, $language_id)
    {
        $this->db->select('*');
        $this->db->from('eventcontents_new');
        $this->db->where('event_id', $event_id);
        $this->db->where('language_id', $language_id);
        if(!empty($event_content_id))
        {
            $this->db->where('contents_id !=', $event_content_id);
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();

        // $str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->num_rows();
    }

    function _delete($event_id, $id) { 

        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata['user_id'];

        $table      = 'eventcontents_new';
        $this->db->where('event_id', $event_id);
        $this->db->where('contents_id', $id);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
}