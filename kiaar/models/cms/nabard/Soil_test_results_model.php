<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Soil_test_results_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_soil_test_results_list($conditions=[])
    {
        $this->db->select('e.*,ec.FIRST_NAME,ec.MIDDLE_NAME,ec.LAST_NAME');
        $this->db->from('nabard_soil_test_results e');
        $this->db->join('nabard_farmers_master ec','e.FARMER_ID = ec.FARMER_ID','left');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('e.soil_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'nabard_soil_test_results';

        $res                        = $this->db->insert($table, $data['soil_test_results']);
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
        $table                      = 'nabard_soil_test_results';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['soil_test_results']);

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
        $table      = 'nabard_soil_test_results';
        $this->db->where($col, $val);
        $res        = $this->db->delete($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function get_farmer_data($conditions=[], $limit='', $offset=0, $allcount='')
    {
        $order          = '';
        $where          = '1=1';
        $like_sql       = '';
        $limit_offset   = '';

        // Like
        if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
        {
            $term       = $_GET['search'];
            $like_sql   = ' AND
                            (
                                u.FARMER_ID LIKE "%'.$term.'%" ESCAPE "!"
                                OR ugi.date LIKE "%'.$term.'%" ESCAPE "!"
                              
                            )
                        ';
        }

        // Where
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $where .= ' AND '.$key.'='.$value;
            }
        }

        // Custom Filter
        if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
        {
            $farmer_name                   = isset($_GET['custom_search']['farmer_name']) ? $_GET['custom_search']['farmer_name'] : [];
            $date                          = isset($_GET['custom_search']['date']) ? $_GET['custom_search']['date'] : [];
            //$month                         = isset($_GET['custom_search']['month']) ? $_GET['custom_search']['month'] : [];
            
            if(!empty($farmer_name))
            {
                $g_find_or    = '(';
                $g_space_or   = '';
                foreach ($farmer_name as $gkey => $gvalue) {
                    if($gkey > 0)
                    {
                        $g_space_or = ' OR ';
                    }
                    $g_find_or .= $g_space_or.'FIND_IN_SET('.$gvalue.', u.FARMER_ID)';
                }
                $g_find_or  .= ')';
                $where      .= ' AND '.$g_find_or;
            }


            if(!empty($date))
            {   
                $g_find_or    = '(';
                $g_space_or   = '';
                // foreach ($year as $gkey => $gvalue) {
                //     if($gkey > 0)
                //     {
                //         $g_space_or = ' OR ';
                //     }
                //     $g_find_or .= $g_space_or.'FIND_IN_SET("'.$gvalue.'", ugi.year_month)';
                // }
                $g_find_or  .= $g_space_or.'ugi.date = "'.$date.'"';
                $g_find_or  .= ')';
                $where      .= ' AND '.$g_find_or;
            }

        }

        // Order
        if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
        {
            if($_GET['sort'] == 'date')
            {
                $sort_by = 'ugi.date';
            }
            else if($_GET['sort'] == 'farmer_name')
            {
                $sort_by = 'u.farmer_name';
            }
            else
            {
                $sort_by = 'ugi.id';
            }

            if(isset($_GET['order']) && !empty($_GET['order']))
            {
                $by      = $_GET['order'];
            }
            else
            {
                $by      = 'DESC';
            }
            $order       = 'ORDER BY '.$sort_by.' '.$by;
        } 
        else
        {
            $order       = 'ORDER BY u.FARMER_ID DESC';
        }

        // Limit
        if(empty($allcount))
        {
            if(isset($_GET['limit']) && $_GET['limit'] != -1)
            {
                $offset = $_GET['offset'];
                $limit = $_GET['limit'];
            }
            else if($limit)
            {
                $limit = $limit;
            }
            $offset = !empty($offset) ? $offset : 0;
            $limit_offset = !empty($limit) ? 'LIMIT '.$limit.' OFFSET '.$offset : '';
        }

        $sql =  '
                    SELECT ugi.*, u.FARMER_ID, CONCAT(FIRST_NAME , " ", MIDDLE_NAME, " ", LAST_NAME ) as farmer_name  FROM nabard_soil_test_results ugi LEFT JOIN nabard_farmers_master u ON ugi.FARMER_ID = u.FARMER_ID  
                    WHERE '.$where.'
                    '.$like_sql.'
                    '.$order.'
                    '.$limit_offset.'
                ';
        $query = $this->db->query($sql);
        // echo "<pre>";print_r($this->db->last_query());exit;

        if($allcount == 'allcount')
        {
            return $query->num_rows();
        }
        else
        {
            return $query->result();
        }
    }
}