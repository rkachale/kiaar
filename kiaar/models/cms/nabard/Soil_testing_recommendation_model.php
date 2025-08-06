<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Soil_testing_recommendation_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_soil_test_results_list($conditions=[])
    {
        $this->db->select('e.*,t.*,n.*');
        $this->db->from('test_tran_head e');
        $this->db->join('test_master t',"t.testID=e.test_ID","left");
        $this->db->join('nabard_farmers_master n',"n.FARMER_ID=e.farmer_ID","left");
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('e.test_tran_ID', 'DESC');
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        return $query->result_array();
    }

    function get_soil_test_name_list()
    {
        $this->db->select('e.test_name,e.testID,COUNT(e.testID) as test_count');
        $this->db->from('test_master e');
        $this->db->order_by('e.testID', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_soil_test_results($testid)
    {
        $this->db->select('e.*');
        $this->db->from('test_template e');
        $this->db->where('e.test_ID', $testid);
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_page_permission($pr_id)
    {
        $this->db->select('*');
        $this->db->from('test_tran_tail tt');
        $this->db->join('test_template t',"t.parameter_ID=tt.parameter_ID","left");
        $this->db->where('tt.test_tran_ID', $pr_id);
        $this->db->where('t.active_flag', 1);
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        $return = $query->result_array();
        return $query->result_array();
    }

    function get_other_page($test_id)
    {
        $this->db->select('*');
        $this->db->from('test_template');
        $this->db->where('test_ID', $test_id);
        $this->db->where('active_flag', 1);
        $query = $this->db->get();
        $return = $query->result_array();
        return $query->result_array();
    }

    function get_test_list()
    {
        $this->db->select('*');
        $this->db->from('test_master');
        $query = $this->db->get();
        $return = $query->result_array();
        return $query->result_array();
    }

    function manage_soil_recommendation($data=[], $id='')
    {  
        if($id)
        {       
                $update['farmer_ID']                = $this->input->post('farmer_id');
                $update['test_ID']                  = $this->input->post('test_ID');
                $update['survey_no']                = $this->input->post('survey_no');
                $update['plot_no']                  = $this->input->post('plot_no');
                $update['plot_area']                = $this->input->post('plot_area');
                $update['sample_date']              = $this->input->post('sample_date');
                $update['future_crop']              = $this->input->post('future_crop');
                $update['soil_type']                = $this->input->post('soil_type');
                $update['test_date']                = $this->input->post('test_date');
                $update['s3_link']                  = $this->input->post('s3_link');
                $update['modified_on']              = date('Y-m-d H:i:s');
                $update['modified_by']              = $this->session->userdata('user_id');

                $this->db->where('test_tran_ID', $id);
                $this->db->update('test_tran_head', $update);                

                // if($id!=null) 
                // {
                    $save = [];
                    $save_user_group = [];
                    foreach ($data['test_parameterid'] as $key => $value) {
                        $save['test_parameterid']   = $value;
                        $save['test_value']         = $data['test_value'][$key];
                        // $save['s3_link']            = $data['s3_link'][$key];
                        $save['template_id']        = $data['template_id'][$key];
                        $save['id2']                = $data['id2'][$key];
                        $save_group_inst[]          = $save;
                    }

                    $id2    = $this->input->post('id2');
                    // echo "<pre>"; print_r($save_group_inst);exit(); 

                    if(isset($data['links_array_check']) && $data['links_array_check'] == 2){ 
                        // echo "i am in insert";exit();
                        foreach($save_group_inst as $result){     
                            $this->db->where('tran_tail_ID',$result['id2']);
                            $this->db->update('test_tran_tail',array("parameter_ID"=>$result['test_parameterid'],"parameter_value"=>$result['test_value'],"template_ID"=>$result['template_id']));
                        }
                    } 
                //}

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Soil test recommendation successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Soil test recommendation'];
                }
        }
        else
        {   
            $insert['farmer_ID']                = $this->input->post('farmer_id');
            $insert['test_ID']                  = $this->input->post('test_ID');
            $insert['survey_no']                = $this->input->post('survey_no');
            $insert['plot_no']                  = $this->input->post('plot_no');
            $insert['plot_area']                = $this->input->post('plot_area');
            $insert['sample_date']              = $this->input->post('sample_date');
            $insert['future_crop']              = $this->input->post('future_crop');
            $insert['soil_type']                = $this->input->post('soil_type');
            $insert['test_date']                = $this->input->post('test_date');
            $insert['s3_link']                  = $this->input->post('s3_link');
            $insert['created_on']               = date('Y-m-d H:i:s');
            $insert['created_by']               = $this->session->userdata('user_id');
            $insert['modified_on']              = date('Y-m-d H:i:s');
            $insert['modified_by']              = $this->session->userdata('user_id');
            // echo "<pre>";print_r($insert);
            $this->db->insert('test_tran_head', $insert);
            $insert_id = $this->db->insert_id();

            $save = [];
            $save_user_group = [];
            foreach ($data['test_parameterid'] as $key => $value) {
                $save['test_parameterid']   = $value;
                $save['test_value']         = $data['test_value'][$key];
                // $save['s3_link']            = $data['s3_link'][$key];
                $save['template_id']        = $data['template_id'][$key];
                $save_group_inst[]          = $save;
            }

            // echo "<pre>"; print_r($save_group_inst);exit();
            foreach($save_group_inst as $result)
            {     
                $this->db->insert('test_tran_tail',array("parameter_ID"=>$result['test_parameterid'],"parameter_value"=>$result['test_value'],"template_ID"=>$result['template_id'],"test_tran_ID"=>$insert_id));
                $pinsert[] = $this->db->insert_id();
            } 

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Soil test recommendation successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Soil test recommendation'];
            }
        }
        return $return;
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
        $table      = 'test_tran_head';
        $table2                     = 'test_tran_tail';
        $this->db->where($col, $val);
        $res        = $this->db->delete($table);
        if($res)
        {
            $this->db->where($col, $val);
            $res        = $this->db->delete($table2);
        }
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
                                OR u.FIRST_NAME LIKE "%'.$term.'%" ESCAPE "!"
                                OR u.MIDDLE_NAME LIKE "%'.$term.'%" ESCAPE "!"
                                OR u.LAST_NAME LIKE "%'.$term.'%" ESCAPE "!"
                                OR ugi.sample_date LIKE "%'.$term.'%" ESCAPE "!"
                                OR ugi.test_date LIKE "%'.$term.'%" ESCAPE "!"
                              
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
            // $date                          = isset($_GET['custom_search']['date']) ? $_GET['custom_search']['date'] : [];
            
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

        }

        // Order
        if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
        {
            if($_GET['sort'] == 'farmer_name')
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
                    SELECT ugi.*, u.FARMER_ID, CONCAT(FIRST_NAME , " ", MIDDLE_NAME, " ", LAST_NAME ) as farmer_name  FROM test_tran_head ugi LEFT JOIN nabard_farmers_master u ON ugi.farmer_ID = u.FARMER_ID  
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