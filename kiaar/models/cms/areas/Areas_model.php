<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Areas_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'areas';
    }

    function get_all_areas($conditions=[])
    {
        $this->db->select('f.*');
        $this->db->from('areas f');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('f.status !=', '-1');
        $this->db->order_by('f.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function manage_areas($data=[], $id='', $thumbnail, $filename)
    {  
        if($id)
        {
            if(!empty($this->get_all_areas($id)))
            {
                $update['name']                     = $this->input->post('name');
                $update['slug']                     = $this->input->post('slug');
                $update['email']                    = $this->input->post('email');
                $update['description']              = $this->input->post('description');
                $update['consultancy']              = $this->input->post('consultancy');
                if(!empty($thumbnail))
                {
                    $update['grid_image']           = $thumbnail;
                }

                $update['status']                   = $this->input->post('status');
                $update['meta_title']               = $this->input->post('meta_title');
                $update['meta_description']         = $this->input->post('meta_description');
                $update['meta_keywords']            = $this->input->post('meta_keywords');
                $update['modified_on']              = date('Y-m-d H:i:s');
                $update['modified_by']              = $this->session->userdata('user_id');

                $this->db->where('area_id', $id);
                $this->db->update($this->table, $update);

                if($filename!=''){ 
                  $filename1 = explode(',',$filename);
                  foreach($filename1 as $file){
                    $file_data = array(
                        'image' => $file,
                        'type' => 'area_banner_images',
                        'area_id' => $id
                    );
                    $this->db->insert('area_banner_images', $file_data);
                  }
                }

                if($id!=null) 
                {
                    $save = [];
                    $save_user_group = [];
                    foreach ($data['consultancy_offered'] as $key => $value) 
                    {

                        $save['consultancy_offered']  = $value;
                        $save['id']         = $data['id2'][$key];
                        $save_group_inst[]  = $save;
                    }

                    $area_id = $this->input->post('area_id');
                    $id2    = $this->input->post('id2');

                    if($id2 == '')
                    { 

                        if(isset($data['consultancy_offered_array_check']) && $data['consultancy_offered_array_check'] == 1){ 
                            foreach($save_group_inst as $result){     
                                $this->db->insert('area_consultancy_offered',array("consultancy_offered"=>$result['consultancy_offered'],"area_id"=>$id));
                                $pinsert[] = $this->db->insert_id();
                            }
                        }
                    } 

                    if(isset($data['consultancy_offered_array_check']) && $data['consultancy_offered_array_check'] == 2)
                    { 
                        
                        if (!empty($save_group_inst))  {  
                            foreach($save_group_inst as $key => $result){ 
                                if($result['id'] == ''){
                                    // $last_row=$this->db->select('link_order')->order_by('link_order',"desc")->limit(1)->get('mmg_program_links')->row();
                                    // $w_order = $last_row->link_order; 
                                    // $link_order = $w_order + 1;
                                    $this->db->insert('area_consultancy_offered',array("consultancy_offered"=>$result['consultancy_offered'],"area_id"=>$id));
                                    $pinsert[] = $this->db->insert_id();
                                }


                                $this->db->where('id',$result['id']);
                                $this->db->update('area_consultancy_offered',array("consultancy_offered"=>$result['consultancy_offered'],"area_id"=>$id)); 
                            }
                        }
                    } 
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Area successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Area'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Area not found'];
            }
        }
        else
        {   
            $insert['name']                     = $this->input->post('name');
            $insert['slug']                     = $this->input->post('slug');
            $insert['email']                    = $this->input->post('email');
            $insert['description']              = $this->input->post('description');
            $insert['consultancy']              = $this->input->post('consultancy');
            if(!empty($thumbnail))
            {
                $insert['grid_image']           = $thumbnail;
            }

            $insert['status']                   = $this->input->post('status');
            $insert['meta_title']               = $this->input->post('meta_title');
            $insert['meta_description']         = $this->input->post('meta_description');
            $insert['meta_keywords']            = $this->input->post('meta_keywords');
            $insert['created_on']               = date('Y-m-d H:i:s');
            $insert['created_by']               = $this->session->userdata('user_id');
            $insert['modified_on']              = date('Y-m-d H:i:s');
            $insert['modified_by']              = $this->session->userdata('user_id');
            $this->db->insert($this->table, $insert);
            $insert_id = $this->db->insert_id();

            if($filename!='' )
            {
                  $filename1 = explode(',',$filename);
                  foreach($filename1 as $file){
                    $file_data = array(
                        'image' => $file,
                        'type' => 'area_banner_images',
                        'area_id' => $insert_id
                    );
                    $this->db->insert('area_banner_images', $file_data);
                  }
            }

            $consultancy_offered = $this->input->post('consultancy_offered');

            $save = [];
            $save_user_group = [];
            foreach ($data['consultancy_offered'] as $key => $value) {
                $save['consultancy_offered']  = $value;
                $save_group_inst[]  = $save;
            }

            foreach($save_group_inst as $result)
            {     
                $this->db->insert('area_consultancy_offered',array("consultancy_offered"=>$result['consultancy_offered'],"area_id"=>$insert_id));
                $pinsert[] = $this->db->insert_id();
            } 


            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Areas successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add areas'];
            }
        }
        return $return;
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

    function get_all_banner_images($id)
    {
        $this->db->select('*');
        $this->db->from('area_banner_images');
        $this->db->where('type', 'area_banner_images');
        $this->db->where('area_id', $id);
        $this->db->order_by('area_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_all_consultancy_offered($id)
    {
        $this->db->select('*');
        $this->db->from('area_consultancy_offered');
        $this->db->where('area_id', $id);
        // $this->db->order_by('link_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }
}