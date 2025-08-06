<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event_type extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/event/Event_type_model', 'event_type_model');
        $user_id = $this->session->userdata['user_id'];
    

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event";
        $this->data['child_menu_type']      = "event_type";
        $this->data['sub_child_menu_type']  = "";



        validate_permissions('Event_type', 'index', $this->config->item('method_for_view'));
        
      
        $this->data['data_list']            = $this->event_type_model->get_event_type_list();
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/event/event_type/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event_type";
        $this->data['child_menu_type']      = "save_post";
        $this->data['sub_child_menu_type']  = "";
        $this->data['event_type_data']      = [];
        $this->data['event_type_id']        = $id;

        // echo "<pre>";
        // print_r($this->data);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Event_type', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['event_type_data'] = $this->input->post();
        }

        
        $this->form_validation->set_rules('event_type_name', 'Event Type', 'required|max_length[250]');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {                                                   
                if($id)
                {
                  
                    $update['event_type_name']     = $this->input->post('event_type_name');
                    $update['public']              = $this->input->post('public');
                    $update['modified_on']         = date('Y-m-d H:i:s');
                    $update['modified_by']         = $this->session->userdata['user_id'];
                    
                    // echo"<pre>";
                    // print_r($update);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response = $this->event_type_model->_update('event_type_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$event_type_id                       = $id;
                        $msg = ['error' => 0, 'message' => 'event_type successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                   
                    $insert['event_type_name']     = $this->input->post('event_type_name');
                    $insert['public']              = $this->input->post('public');
                    $insert['created_on']          = date('Y-m-d H:i:s');
                    $insert['created_by']          = $this->session->userdata['user_id'];
                    
                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                       = $this->event_type_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $entyty_type_id           	= $response['id'];
                        $msg = ['error' => 0, 'message' => 'Event type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/event_type/');
            }
        }

        if($id!='')
        {
            $event_type = $this->event_type_model->get_event_type_list(['event_type_id' => $id, 'public !=' => '-1']);
            $this->data['event_type_data']     = isset($event_type[0]) ? $event_type[0] : [];
            
            if(empty($this->data['event_type_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'event_type not found']);
                redirect(base_url()."cms/event_type/");
            }
        }

        $this->data['content']              = $this->load->view('cms/event/event_type/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        
            
        validate_permissions('Event_type', 'delete', $this->config->item('method_for_delete'));
             
        $event_type = $this->event_type_model->get_event_type_list(['event_type_id' => $id]);

        if(!empty($event_type))
        {
            $response = $this->event_type_model->_delete('event_type_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/event_type/');
    }

}
