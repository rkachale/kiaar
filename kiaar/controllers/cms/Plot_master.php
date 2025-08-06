<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plot_master extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nabard/Plot_master_model', 'soil_model');
        $this->load->model('cms/nabard/Farmers_model', 'farmers_model');
        $user_id = $this->session->userdata['user_id'];      
    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "plot_master";
        $this->data['child_menu_type']      = "plot_master";
        $this->data['sub_child_menu_type']  = "";

        validate_permissions('Plot_master', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->soil_model->get_plot_master_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/plot_master/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "plot_master";
        $this->data['child_menu_type']      = "save_plot_master";
        $this->data['sub_child_menu_type']  = "";
        $this->data['data']                 = [];
        $this->data['id']                   = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Plot_master', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['data'] = $this->input->post();
            // echo "<pre>";print_r($this->data['data']);exit;
        }

        $this->form_validation->set_rules('farmer_id', 'Farmer ID', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $response = $this->soil_model->manage_plot_master($this->input->post(), $id);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Data successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/plot_master/');
            }
        }

        if($id!='')
        {
            $plot_master         = $this->soil_model->get_plot_master_list(['e.id' => $id]);
            $this->data['data']        = isset($plot_master[0]) ? $plot_master[0] : [];
            
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data not found']);
                redirect(base_url()."cms/plot_master/");
            }
        }

        $this->data['farmers_list']         = $this->farmers_model->get_farmers_list();
        $this->data['content']              = $this->load->view('cms/nabard/plot_master/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function delete($id='')
    {
        validate_permissions('Plot_master', 'delete', $this->config->item('method_for_delete'));
             
        $plot_master = $this->soil_model->get_plot_master_list(['e.id' => $id]);

        if(!empty($plot_master))
        {
            $response = $this->soil_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data not found.']);
        }
        redirect(base_url().'cms/plot_master/');
    }

}