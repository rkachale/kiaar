<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Soil_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_soil_master_list($conditions=[])
    {
        $this->db->select('e.*,ec.FIRST_NAME,ec.MIDDLE_NAME,ec.LAST_NAME,ec.MOBILE_NO');
        $this->db->from('soil_master e');
        $this->db->join('nabard_farmers_master ec','e.FARMER_ID = ec.FARMER_ID','left');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('e.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_farmer($id)
    {
        $this->db->select('e.FARMER_ID');
        $this->db->from('soil_master sm');
        $this->db->join('nabard_farmers_master e','sm.FARMER_ID = e.FARMER_ID','left');
        $this->db->where('sm.id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_plot_list($farmerid)
    // function get_plot_list()
    {
        $this->db->select('e.*');
        $this->db->from('plot_master e');
        if(!empty($farmerid))
        {
            $this->db->where('e.FARMER_ID', $farmerid);
        }
        $this->db->order_by('e.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function soil_edit($id=null,$soil_data,$data)
    {   
        $this->db->trans_start();

        if($id!=null) 
        {   
            //echo "i am in update";exit();
            /*** Update Projects data ***/
            $this->db->where('id', $id);
            $this->db->update('soil_master', $soil_data);
            

            /*** Multiple Links ***/
            // // echo "<pre>";print_r($data);exit;
            // $save = [];
            // $save_core_group = [];
            // foreach ($data['link_name'] as $key => $value) 
            // {
            //     $save['link_name']      = $value;
            //     $save['link_url']       = $data['link_url'][$key];
            //     $save['id2']            = isset($data['id2'][$key]) ? $data['id2'][$key] : '';
            //     $save_group_core[]      = $save;
            // }

            // $id2 = $this->input->post('id2');

            // if($id2 == '')
            // { 
            //     if(isset($data['links_array_check']) && $data['links_array_check'] == 1)
            //     { 
            //         // echo"m in insert";exit();
            //         foreach($save_group_core as $key => $result)
            //         { 
            //             $this->db->insert('soil_master_report_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"soil_master_id"=>$id));
            //             $pinsert[] = $this->db->insert_id();
            //         }
            //     }
            // } 

            // if(isset($data['links_array_check']) && $data['links_array_check'] == 2)
            // { 
            //     if (!empty($save_group_core))  
            //     {  
            //         foreach($save_group_core as $key => $result)
            //         { 
            //             if($result['id2'] == '')
            //             {   
            //                 // echo"m in insert1";exit();
            //                 $this->db->insert('soil_master_report_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"soil_master_id"=>$id));
            //                 $pinsert[] = $this->db->insert_id();
            //             } 
            //             else 
            //             {
            //                 // echo"m in update";
            //                 $this->db->where('id',$result['id2']);
            //                 $this->db->update('soil_master_report_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"soil_master_id"=>$id));                            
            //             }
            //         }
            //     }
            // }
        }
        else   
        {   
            //echo "i am in add";exit();
            /*** Add Soil data ***/
            $this->db->insert('soil_master', $soil_data); 
            $insert_id = $this->db->insert_id();


            /*** Multiple Links ***/
            // $save = [];
            // $save_core_group = [];
            // foreach ($data['link_name'] as $key => $value) 
            // {
            //     $save['link_name']      = $value;
            //     $save['link_url']       = $data['link_url'][$key];
            //     $save_group_core[]      = $save;
            // }

            // foreach($save_group_core as $key => $result)
            // { 
            //     $this->db->insert('soil_master_report_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"soil_master_id"=>$insert_id));
            //     $pinsert[] = $this->db->insert_id();
            // } 
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function _delete($col, $val) 
    {
        $table      = 'soil_master';
        $this->db->where($col, $val);
        $res        = $this->db->delete($table);
        if($res)
        {
            $this->db->delete('soil_master_report_links', array('soil_master_id' => $val));
        }
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function get_all_links($id)
    {
        $this->db->select('*');
        $this->db->from('soil_master_report_links');
        $this->db->where('soil_master_id', $id);
        $this->db->order_by('link_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_farmers_details($id)
    {
        $this->db->select('e.report_name,e.report_link,ec.FIRST_NAME,ec.MIDDLE_NAME,ec.LAST_NAME,ec.MOBILE_NO');
        $this->db->from('soil_master e');
        $this->db->join('nabard_farmers_master ec','e.FARMER_ID = ec.FARMER_ID','left');
        $this->db->where('e.id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}