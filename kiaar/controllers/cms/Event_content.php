<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event_content extends Kiaar_Controller
{


    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/event/Event_model', 'event_model');
        $this->load->model('cms/event/Event_content_model', 'event_content_model');
        //$this->load->model('cms/Kiaar_general_admin_model', 'Kiaar_general_admin_model');
        //$this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
       

    }

    function index()
    {
        echo "hello";
        exit();
    }
    
    function contents($event_id='')
    {
        // echo "event content index method called".$event_id;
        // exit();
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

    

        validate_permissions('Event_content', 'index', $this->config->item('method_for_view'));
        
        //echo "event id : ".$event_id;
        $contents = $this->event_content_model->get_event_contents($event_id);
        // echo "<pre>";
        // print_r($contents);
        // exit();

        if(!empty($contents))
        {   
            $this->data['content_list']         = $contents;
            $this->data['title']                = _l("event content", $this);
            $this->data['page']                 = "eventcontent";
            $this->data['event_id']              = $event_id;
            $this->data['content']              = $this->load->view('cms/event/event_content/index',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No event found']);
            redirect(base_url().'cms/event/');
        }

        // $this->data['title']                = _l("Module",$this);
        // $this->data['page']                 = "Module";
        // $this->data['content']              = $this->load->view('cms/event/event_content/index',$this->data,true);
        // $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($event_id='',$id='')
    {
        // echo "event id : ".$event_id. " and contents id :".$id;
        // exit();
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

    

        $this->data['contents_id']          = $id;
        $this->data['event_id']             = $event_id;
        $this->data['languages']            = $this->Kiaar_general_admin_model->get_all_language();
        $this->data['event_content_data']   = [];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Event_content', 'edit', $per_action);

        //if(!empty($event_id) && !empty($id))
        if(!empty($event_id))
        {
            //echo "test one";//exit();
            $this->form_validation->set_rules('name', 'Name', 'required');      
            //$this->form_validation->set_rules('description', 'Description', 'required');

            if($this->input->post())
            {
                $this->data['event_content_data']      = $this->input->post();
            }
            else
            {
                $this->data['event_content_data']      = $this->event_content_model->get_details($event_id, $id);                
            }
            // exit();
            // echo "<pre>";
            // print_r($this->data['event_content_data']);
            // exit();
            // if(!empty($this->data['event_content_data']))
            // {
                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {

                        // echo "<pre>";
                        // print_r($this->input->post());
                        // echo "<br>----------<br>";
                        // exit();
                        $msg = $this->save($event_id, $id, $this->input->post());
                        $this->session->set_flashdata('status', $msg);
                        redirect(base_url().'cms/event_content/contents/'.$event_id);
                    }
                }

                $this->data['title']                = _l("Module",$this);
                $this->data['page']                 = "Module";
                $this->data['content']              = $this->load->view('cms/event/event_content/form',$this->data,true);
                $this->load->view($this->mainTemplate,$this->data);
            // }
            // else
            // {
            //     $this->session->set_flashdata('status', ['error' => 1, 'message' => 'No event content found']);
            //     redirect(base_url().'cms/event');
            // }

        }
        else
        {
            //echo "test two";exit();
            $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Invalid request']);
            redirect(base_url().'cms/event');
        } 
    }

    public function save($event_id, $id='', $event_content_data=[])
    {
        $msg         = array('error' => 1, 'message' => 'Access denied');

        if(!empty($event_content_data))
        {
            //if($event_data['language'] == 'en' && $event_data['status'] < 1)
            if($event_content_data['language_id'] == 1 && $event_content_data['public'] < 1) // language_id=1 is default english lang
            {
                $msg = array('error' => 1, 'message' => 'Setting default english language content to in-active state is not allowed');
            }
            else
            {
                $save['event_id']                   = $event_id;
                $save['language_id']                = $event_content_data['language_id'];
                $save['name']                       = $event_content_data['name'];
                $save['description']                = $event_content_data['description'];
                $save['public']                     = $event_content_data['public'];
                $msg                                = $this->event_content_model->save($event_id, $id, $save);
            }
        }
        return $msg;
    }

    public function check_content_by_lang()
    {
        //echo "hello";exit();
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        if(!empty($this->input->post()))
        {
            $event_id = $this->input->post('event_id');
            $event_content_id = $this->input->post('event_content_id');
            $language_id = $this->input->post('language_id');

            $count = $this->event_content_model->check_content_by_lang($event_id, $event_content_id, $language_id);
            // echo "count : ".$count;
            // exit();
            if($count == 0)
            {
               $result = "true";
            }
            else
            {
                $result = "false";
            }

            echo $result;
        }
        
    }

    function delete($event_id='', $id='')
    {
   
            
        validate_permissions('Event_content', 'delete', $this->config->item('method_for_delete'));
             
        $event_contents = $this->event_content_model->get_details($event_id, $id);

        if(!empty($event_contents))
        {
            $response = $this->event_content_model->_delete($event_id, $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/event_content/contents/'.$event_id);

    }



    
}