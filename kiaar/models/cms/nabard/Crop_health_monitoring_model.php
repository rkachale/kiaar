<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crop_health_monitoring_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_crop_health_monitoring_list($conditions=[])
    {
        $this->db->select('e.*,ec.FIRST_NAME,ec.MIDDLE_NAME,ec.LAST_NAME');
        $this->db->from('nabard_crop_health_monitoring e');
        $this->db->join('nabard_farmers_master ec','e.FARMER_ID = ec.FARMER_ID','left');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('e.crop_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
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
        $table      = 'nabard_crop_health_monitoring';
        $this->db->where($col, $val);
        $res        = $this->db->delete($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function upload_image($inputdata,$images)
    {  
        $this->db->insert('nabard_crop_health_monitoring', $inputdata); 
        $insert_id = $this->db->insert_id();
        if(!empty($images))
        {
            foreach($images as $file)
            {
                $file_data = array(
                    'image' => $file['image'],
                    'name' => $file['name'],
                    'description' => $file['description'],
                    'crop_id' => $insert_id
                );
                $this->db->insert('nabard_crop_health_monitoring_images', $file_data);
            }
        }

        if($insert_id)
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


    function update_upload_image($id,$inputdata,$images,$all_existing_image_array)
    {
        $this->db->where('crop_id', $id);
        $update  = $this->db->update('nabard_crop_health_monitoring', $inputdata);
        if(!empty($images))
        {
            foreach($images as $file)
            {
                $file_data  =   array(
                                    'image' => $file['image'],
                                    'name' => $file['name'],
                                    'description' => $file['description'],
                                    'crop_id' => $id
                                );
                $this->db->insert('nabard_crop_health_monitoring_images', $file_data);
            }
        }

        if(!empty($all_existing_image_array))
        {
            foreach ($all_existing_image_array as $key1 => $value1) 
            {
            
                $updatedata = array('name'=>$value1['image_name'],'description'=>$value1['image_description']);
                $this->db->where('id', $value1['image_id']);

                $update  = $this->db->update('nabard_crop_health_monitoring_images', $updatedata);
            }
        }

        if($update)
        {
            $response['status']     = 'success';
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
       return $response;
    }

    function get_data_image($id)
    {
        $query=$this->db->query("SELECT * FROM nabard_crop_health_monitoring ud RIGHT JOIN nabard_crop_health_monitoring_images as nabard_crop_health_monitoring_images ON ud.crop_id = nabard_crop_health_monitoring_images.crop_id WHERE ud.crop_id = $id");
        return $query->result_array();
    }


    function get_year()
    {   
        $this->db->select("Distinct(LEFT(`year_month`,LOCATE('-',`year_month`) - 1)) as year");
        $this->db->from('nabard_crop_health_monitoring');
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str);exit();
        return $query->result_array();
    }

    function get_month()
    {
        $this->db->select("Distinct(RIGHT(`year_month`,LOCATE('-',`year_month`) - 3)) as month");
        $this->db->from('nabard_crop_health_monitoring');
        $query = $this->db->get();
        return $query->result_array();
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
                                OR ugi.year_month LIKE "%'.$term.'%" ESCAPE "!"
                              
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
            $year                          = isset($_GET['custom_search']['year']) ? $_GET['custom_search']['year'] : [];
            $month                         = isset($_GET['custom_search']['month']) ? $_GET['custom_search']['month'] : [];
            
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


            if(!empty($year))
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
                $g_find_or  .= $g_space_or.'ugi.year_month LIKE("%'.$year.'-%")';
                $g_find_or  .= ')';
                $where      .= ' AND '.$g_find_or;
            }


            if(!empty($month))
            {   
                $g_find_or    = '(';
                $g_space_or   = '';
                foreach ($month as $gkey => $gvalue) {
                    if($gkey > 0)
                    {
                        $g_space_or = ' OR ';
                    }
                    $g_find_or  .= $g_space_or.'ugi.year_month LIKE("%-'.$gvalue.'%")';
                }
                // $g_find_or  .= $g_space_or.'ugi.year_month LIKE("%'.$month.'-%")';
                $g_find_or  .= ')';
                $where      .= ' AND '.$g_find_or;
            }

        }

        // Order
        if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
        {
            if($_GET['sort'] == 'year_month')
            {
                $sort_by = 'ugi.year_month';
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
                    SELECT ugi.*, u.FARMER_ID, CONCAT(FIRST_NAME , " ", MIDDLE_NAME, " ", LAST_NAME ) as farmer_name  FROM nabard_crop_health_monitoring ugi LEFT JOIN nabard_farmers_master u ON ugi.FARMER_ID = u.FARMER_ID  
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