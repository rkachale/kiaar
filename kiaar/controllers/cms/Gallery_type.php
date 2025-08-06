<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_type extends Kiaar_Controller
{
     function __construct()
    {
    

          parent::__construct('backend');
        $this->load->model('cms/gallery/Gallery_type_model', 'Gallery_type_model');
        $user_id = $this->session->userdata['user_id'];
       
    }

 function index()
    {
      
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "galleries";
        $this->data['child_menu_type'] = "gallery_types";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Gallery_type', 'index', $this->config->item('method_for_view'));

        $this->data['data_list']=$this->Gallery_type_model->get_galtype();
        $this->data['title'] = _l("Gallery Type",$this);
        $this->data['page'] = "index";
       $this->data['content']=$this->load->view('cms/gallery/index_type',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  

    }


   function edit($id='')
    {



       $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "galleries";
        $this->data['child_menu_type'] = "gallery_types";
        $this->data['sub_child_menu_type'] = "";
        $allowed_inst_ids          = [];
        $save_data                 = [];
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Gallery_type', 'edit', $per_action);
        $status      =-1;
        $this->data['title']                = 'gallery_types';
        $this->data['page']                 = 'gallery_types';
        $this->data['data']                 = [];
        $this->data['id']      = $id;
        $this->data['data']['public']       = 1;
      
        if($id)
        {
            $this->data['data']= $this->Gallery_type_model->get_galtype_detail($id);
            if(empty($this->data['data']))
            {
          $this->session->set_flashdata('requeststatus',['error'=>1,'message'=>'Projects Category not found']);
          redirect(base_url().'cms/gallery_type');
            } 
        }  
        if($this->input->post())
        {
            $this->data['data']= $this->input->post();

        }
       
        $this->form_validation->set_rules('type_name', 'type_name', 'required|max_length[250]');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                if($id)
                {
                     $update['galleries_type']['type_name']    = $this->input->post('type_name');
                     $update['galleries_type']['public']           = $this->input->post('public');
                     $update['galleries_type']['modified_on']      = date('Y-m-d H:i:s');
                     $update['galleries_type']['modified_by']      = $this->session->userdata['user_id'];
                     $condition                                          = array('id' => $id);
                    $response = $this->Gallery_type_model->_update($condition, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Gallery Type  successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['galleries_type']['type_name']      = $this->input->post('type_name');
                    $insert['galleries_type']['public']             = $this->input->post('public');
                    $insert['galleries_type']['created_on']         = date('Y-m-d H:i:s');
                    $insert['galleries_type']['created_by']         = $this->session->userdata['user_id'];
                    $insert['galleries_type']['modified_on']        = date('Y-m-d H:i:s');
                    $insert['galleries_type']['modified_by']        = $this->session->userdata['user_id'];
                  
                    $response   = $this->Gallery_type_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Gallery Type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/gallery_type');
            }//end post
          //  end validations
        }
     
         $this->data['content'] = $this->load->view('cms/gallery/form_type',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data); 


    }


    function delete($id='')
    {
      
        validate_permissions('Gallery_type','delete',$this->config->item('method_for_delete'));
       
        $condition  = array('id' => $id  );
        $post=$this->Gallery_type_model->get_galtype_detail($id);

        if(!empty($post))
        {
        $response = $this->Gallery_type_model->_delete($condition);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Gallery Type not found.']);
        }
            redirect(base_url().'cms/Gallery_type');
    }
}


?>                             