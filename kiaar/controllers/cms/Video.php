<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Video extends Kiaar_Controller
{
  
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/video/Video_model', 'video_model');
        //$this->load->model('cms/Kiaar_general_admin_model', 'Kiaar_general_admin_model');
        //$this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
       

    }

    function index()
    {
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "video";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

     

        validate_permissions('Video', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->video_model->get_video_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/video/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "video";
        $this->data['child_menu_type']      = "save_video";
        $this->data['sub_child_menu_type']  = "";
        $this->data['video_data']          = [];
        $this->data['video_id']            = $id;

     
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Video', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['video_data'] = $this->input->post();
        }

        
        $this->form_validation->set_rules('video_title', 'Video Title', 'required|max_length[250]');
        $this->form_validation->set_rules('video_url', 'Video Url', 'required'); 
        $this->form_validation->set_rules('video_description', 'Video Description', 'required'); 
        $this->form_validation->set_rules('embed_code', 'Video Embed code', 'required');      
        $this->form_validation->set_rules('video_date', 'Video Date', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                                                
                if($id)
                {
                  
                    $update['video_text']           = $this->input->post('video_title');
                    $update['video_description']    = $this->input->post('video_description');
                    $update['date']                 = $this->input->post('video_date');
                    $update['video_url']            = $this->input->post('video_url');
                    $update['embed_code']           = $this->input->post('embed_code');
                    $update['spotlight_video']      = $this->input->post('spotlight_video');
                    $update['featured_video']       = $this->input->post('featured_video');
                    $update['public']               = $this->input->post('public');
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata['user_id'];
                    
                    $response = $this->video_model->_update('video_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $bammer_id                       = $id;
                        $msg = ['error' => 0, 'message' => 'Video successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                   
                    $insert['video_text']           = $this->input->post('video_title');
                    $insert['video_description']    = $this->input->post('video_description');
                    $insert['date']                 = $this->input->post('video_date');
                    $insert['video_url']            = $this->input->post('video_url');
                    $insert['embed_code']           = $this->input->post('embed_code');
                    $insert['spotlight_video']      = $this->input->post('spotlight_video');
                    $insert['featured_video']       = $this->input->post('featured_video');
                    $insert['public']               = $this->input->post('public');
                    $insert['created_on']           = date('Y-m-d H:i:s');
                    $insert['created_by']           = $this->session->userdata['user_id'];

                    $response                       = $this->video_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Video successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/video/');
            }
        }

        if($id!='')
        {
            $video = $this->video_model->get_video_list(['video_id' => $id]);
            $this->data['video_data']     = isset($video[0]) ? $video[0] : [];
            
            if(empty($this->data['video_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Video not found']);
                redirect(base_url()."cms/video/");
            }
        }

        $this->data['content']              = $this->load->view('cms/video/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        
            
        validate_permissions('Video', 'delete', $this->config->item('method_for_delete'));
             
        $video = $this->video_model->get_video_list(['video_id' => $id]);

        if(!empty($video))
        {
            $response = $this->video_model->_delete('video_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/video/');
    }

}