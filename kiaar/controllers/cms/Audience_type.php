<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Audience_type extends Kiaar_Controller
{
  
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/event/Audience_type_model', 'audience_type_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
     

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event";
        $this->data['child_menu_type']      = "audience_type";
        $this->data['sub_child_menu_type']  = "";

     

        validate_permissions('Audience_type', 'index', $this->config->item('method_for_view'));
        $this->data['data_list']            = $this->audience_type_model->get_audience_type_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/event/audience_type/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "audience_type";
        $this->data['child_menu_type']      = "save_post";
        $this->data['sub_child_menu_type']  = "";
        $this->data['audience_type_data']      = [];
        $this->data['audience_type_id']        = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Audience_type', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['audience_type_data'] = $this->input->post();
        }

        
        $this->form_validation->set_rules('audience_type_name', 'Audience Type', 'required|max_length[250]');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {                                                   
                if($id)
                {
                    //$update['institute_id']        = $this->data['institute_id'];
                    $update['audience_name']     = $this->input->post('audience_type_name');
                    $update['public']              = $this->input->post('public');
                    $update['modified_on']         = date('Y-m-d H:i:s');
                    $update['modified_by']         = $this->session->userdata['user_id'];
                    
                    // echo"<pre>";
                    // print_r($update);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response = $this->audience_type_model->_update('audience_type_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$audience_type_id                       = $id;
                        $msg = ['error' => 0, 'message' => 'audience_type successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    //$insert['institute_id']        = $this->data['institute_id'];
                    $insert['audience_name']     = $this->input->post('audience_type_name');
                    $insert['public']              = $this->input->post('public');
                    $insert['created_on']          = date('Y-m-d H:i:s');
                    $insert['created_by']          = $this->session->userdata['user_id'];
                    
                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                       = $this->audience_type_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $entyty_type_id           	= $response['id'];
                        $msg = ['error' => 0, 'message' => 'Audience type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/audience_type/');
            }
        }

        if($id!='')
        {
            $audience_type = $this->audience_type_model->get_audience_type_list(['audience_type_id' => $id, 'public !=' => '-1']);
            $this->data['audience_type_data']     = isset($audience_type[0]) ? $audience_type[0] : [];
            
            if(empty($this->data['audience_type_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'audience_type not found']);
                redirect(base_url()."cms/audience_type/");
            }
        }

        $this->data['content']              = $this->load->view('cms/event/audience_type/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
       
            
        validate_permissions('Audience_type', 'delete', $this->config->item('method_for_delete'));
             
        $audience_type = $this->audience_type_model->get_audience_type_list(['audience_type_id' => $id]);

        if(!empty($audience_type))
        {
            $response = $this->audience_type_model->_delete('audience_type_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/audience_type/');
    }

}
