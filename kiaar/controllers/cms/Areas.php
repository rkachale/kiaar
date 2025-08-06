<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Areas extends Kiaar_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/areas/Areas_model', 'areas');
       
    }

    function index()
    {
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "areas";
        $this->data['child_menu_type']      = "areas";
        $this->data['sub_child_menu_type']  = "areas";
         validate_permissions('Areas', 'index', $this->config->item('method_for_view'));
        $this->data['data_list']            = $this->areas->get_all_areas();
        $this->data['title']                = 'Areas';
        $this->data['page']                 = "Areas";
        $this->data['content']              = $this->load->view('cms/areas/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   

        $this->data['title']                = 'Areas';
        $this->data['module']               = 'Areas';
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "areas";
        $this->data['child_menu_type']      = "save_areas";
        $this->data['sub_child_menu_type']  = "save_areas";
        $this->data['post_data']            = [];
        $this->data['area_id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Areas', 'edit', $per_action);

        if($id)
        {
            $this->data['data_image']           = $this->areas->get_all_banner_images($id);
            $this->data['consultancy_offered']  = $this->areas->get_all_consultancy_offered($id);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Areas not found']);
                redirect(base_url().'cms/areas/index/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
      
        }

        $this->form_validation->set_rules('name', 'Area Name', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                $path       = './upload_file/areas_upload/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);

                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                
                $pathToUpload = './upload_file/areas_upload/';
                $files = $_FILES;
                $count = count($_FILES['userfile']['name']);
                if (isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])) 
                { 
                    for($i=0; $i<$count; $i++)
                    {   
                        //print_r($_FILES['userfile']['name']);exit();
                        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                        $config11['upload_path'] = $pathToUpload;
                        $config11['allowed_types'] = 'gif|jpg|png|jpeg|mp4|mpeg|mpg|avi|mov';
                        $config11['max_size'] = '8000000';
                        $config11['remove_spaces'] = true;
                        $config11['overwrite'] = false;
                        $config11['max_width'] = '';
                        $config11['max_height'] = '';
                        $fileName12 = $_FILES['userfile']['name'];
                        $fileName = str_replace(' ', '_', $fileName12);
                        $images[] = $fileName;
                        $this->load->library('upload', $config11);
                        $this->upload->initialize($config11);
                        $this->upload->do_upload();
                    }
                    $fileName = implode(',',$images);
                }

                $response = $this->areas->manage_areas($this->input->post(), $id,$thumbnail,$fileName);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Areas successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/areas/');
            }
        }
        if($id!='')
        {
            $areas                            = $this->areas->get_all_areas(['f.area_id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($areas[0]) ? $areas[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'areas not found']);
                redirect(base_url()."cms/areas/");
            }
        }
       // $this->data['institutes_list']  = $this->Kiaar_general_admin_model->get_all_institute();
        $this->data['content']          = $this->load->view('cms/areas/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);        
    }


    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/areas_upload/';
        
        if(!empty($image_data))
        {   
            $image_parts    = explode(";base64,", $image_data);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $image_name     = uniqid().'.'.$image_type;
            $file           = $path.'/'.$image_name;
            file_put_contents($file, $image_base64);
        }
        return ['thumbnail' => $image_name];
    }


    function delete($id='')
    {
        validate_permissions('Areas', 'delete', $this->config->item('method_for_delete'));
        
        $areas                          = $this->areas->get_all_areas(['f.area_id' => $id, 'f.status !=' => '-1']);

        if(!empty($areas))
        {
            $this->common_model->set_table('areas');
            $response = $this->common_model->_delete('area_id', $id);

            $this->common_model->set_table('area_banner_images');
            $response = $this->common_model->_delete('area_id', $id);

            $this->common_model->set_table('area_consultancy_offered');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Areas not found.']);
        }
        redirect(base_url().'cms/areas');
    }


    function delete_banner_image($id=0)
    {
        $response =  $this->db->delete('area_banner_images', array('id' => $id, 'type' => 'area_banner_images'));

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/areas/edit/'.$id);
    }


    function delete_consultancy_offered()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('area_consultancy_offered', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

}
