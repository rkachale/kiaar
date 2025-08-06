<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
    protected $CI;
    private $database;
    private $table;
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
    }

    // Unique to models with multiple tables
    function set_table($table) {
        $this->table = $table;
    }
    
    // Get table from table property
    function get_table() {
        return $this->table;
    }

    // Retrieve all data from database and order by column return query
    function get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    // Limit results, then offset and order by column return query
    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $db->get($table);
        return $query;
    }

    // Get where column id is ... return query
    function get_where($col, $val) {
        $table = $this->get_table();
        $this->db->where($col, $val);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    // Get where multiple .... return query
    function get_where_multiple_conditions($conditions=[], $orderBy='') {
        $table = $this->get_table();
        if(is_array($conditions))
        {
            foreach ($conditions as $key => $condition) {
                $this->db->where($key, $condition);
            }
        }
        else
        {
            $this->db->where('id', $conditions);
        }

        if($orderBy != '')
        {
            $this->db->order_by($orderBy);
        }
        $query = $this->db->get($table);
        return $query;
    }

    // Get where custom column is .... return query
    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = $this->get_table();
        $res                        = $this->db->insert($table, $data);
        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = $this->db->insert_id();
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

    function _insert_multiple($data) {
        $table      = $this->get_table();
        $num_rows   = $this->db->insert_batch($table, $data);
        return $num_rows;
    }

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = $this->get_table();
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

    function _update_with_multiple_conditions($conditions, $updatedata) {
        $response['status']         = 'error';
        $table                      = $this->get_table();

        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $update = $this->db->update($table, $updatedata);

        if($update)
        {
            $response['status']     = 'success';
            $response['message']    = 'Successfully updated';
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }

    function update_multiple($field, $data) {
        $table  = $this->get_table();
        $updt   = $this->db->update_batch($table, $data, $field);
        return $updt;
    }

    function _delete($col, $val) {
        if(!empty($this->get_where($col, $val)))
        {
            $table      = $this->get_table();
            $this->db->where($col, $val);
            $res        = $this->db->delete($table);
            $error      = $res ? 0 : 1;
            $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
            $res        = ['error' => $error, 'message' => $message];
        }
        else
        {
            $error      = 1;
            $message    = 'Record does not exist in database';
        }
        $res            = ['error' => $error, 'message' => $message];
        return $res;
    }

    function _delete_with_multiple_conditions($conditions) {
        $table  = $this->get_table();
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $res    = $this->db->delete($table);
        return $res;
    }

    function custom_query($sql) {
        $query = $this->db->query($sql);
        if(is_object($query))
            return $query->result_array();
        else
            return $query;
    }

    function get_designations() {
        return $this->custom_query('SELECT designation_id, name FROM designations WHERE public = "1"');
    }

    function get_speakers() {
        return $this->custom_query('SELECT speaker_id, CONCAT(first_name," ",last_name) as speaker_name FROM speakers WHERE public = "1"');
    }
}