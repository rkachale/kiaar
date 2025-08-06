<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Posts_content_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_post_contents($post_id)
    {
        $this->db->select('c.*,l.code as language_code');
        $this->db->from('contentspost c');
        $this->db->join('languages l', 'c.language_id = l.language_id','left');
        $this->db->where('c.post_id', $post_id);
        $this->db->where('c.public !=', '-1');
        $this->db->order_by('c.contents_id', 'DESC');
        $query = $this->db->get();

        //$str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;

        return $query->result_array();
    }

    function get_details($post_id='', $id='')
    {
        $this->db->select('*');
        $this->db->from('contentspost');
        $this->db->where('post_id', $post_id);
        $this->db->where('contents_id', $id);
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function save($post_id='', $id='', $save=[])
    {   
        $msg = ['error' => 1, 'message' => 'Invalid request'];
        if(!empty($save))
        {
            $post_content = $this->check_post_content($post_id, '', $save['language_id']);

            // print_r($post_content);
            // exit();
            if(!empty($post_content))
            {
                $save['modified_on']   = date('Y-m-d H:i:s');
                $save['modified_by']        = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $post_content['contents_id']);
                $this->db->update('contentspost', $save);
            }
            else
            {
                $save['created_on'] = date('Y-m-d H:i:s');
                $save['created_by'] = $this->session->userdata['user_id'];
                $this->db->insert('contentspost', $save);
            }

            if($this->db->affected_rows())
            {
                $msg = ['error' => 0, 'message' => 'Post content successfully saved'];
            }
            else
            {
                $msg = ['error' => 1, 'message' => 'Unable to save an post content'];
            }
        }
        return $msg;
    }

    function check_post_content($post_id='', $id='', $language='')
    {
        $this->db->select('*');
        $this->db->from('contentspost');
        $this->db->where('post_id', $post_id);
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

    function check_content_by_lang($post_id, $post_content_id, $language_id)
    {
        $this->db->select('*');
        $this->db->from('contentspost');
        $this->db->where('post_id', $post_id);
        $this->db->where('language_id', $language_id);
        if(!empty($post_content_id))
        {
            $this->db->where('contents_id !=', $post_content_id);
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();

        // $str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->num_rows();
    }

    function _delete($post_id, $id) { 

        $update['public']            = -1;
        //$update['updated_date']      = date('Y-m-d H:i:s');
        //$update['user_id']           = $this->session->userdata('user_id');

        $table      = 'contentspost';
        $this->db->where('post_id', $post_id);
        $this->db->where('contents_id', $id);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        //$str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
}