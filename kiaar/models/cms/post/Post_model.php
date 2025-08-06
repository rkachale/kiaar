<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_post_list()
    {
       

        $this->db->select('p.*, cp.contents_id, cp.description, cp.language_id');
        $this->db->from('post p');
        $this->db->join('contentspost cp','p.post_id = cp.post_id','left');

    
        $this->db->where('cp.language_id',1);
        $this->db->where('p.public !=', '-1');
        $this->db->order_by('p.post_id', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'post';
        $table2                     = 'contentspost';

        $res                        = $this->db->insert($table, $data['post']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['contents']['post_id']      = $insert_id;
            
            $res                              = $this->db->insert($table2, $data['contents']);

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
        $table                      = 'post';
        $table2                     = 'contentspost';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['post']);

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

        $this->db->where('post_id', $id);
        $this->db->update('post', $update);

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;


        return $this->db->affected_rows();
    }

    function _delete($col, $val) {
            
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
    }
}