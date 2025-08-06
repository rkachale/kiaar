<?php
/**
 * Created by kiaar Team.
 * User: kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.kiaar.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Usermanagement_module extends Kiaar_Controller {
    function __construct()
    {
        parent::__construct('backend');

        validate_permissions('', '', '', 'notallowed');
    }

    function view_module()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "modules";
        $this->data['child_menu_type'] = "modules";
        $this->data['sub_child_menu_type'] = "";

        // validate_permissions('Usermanagement_module', 'view_module', $this->config->item('method_for_view'));
        
        $this->data['data_list']=$this->Usermodule_model->view_usermodule();
        $this->data['title'] = _l("Module",$this);
        $this->data['page'] = "Module";
        $this->data['content']=$this->load->view('usermanagement_module'.'/module',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit_module($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "modules";
        $this->data['child_menu_type'] = "modules";
        $this->data['sub_child_menu_type'] = "";
        
        // $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        // validate_permissions('Usermanagement_module', 'edit_module', $per_action);

        if($id!='')
        {
            $this->data['data']=$this->Usermodule_model->edit_usermodule($id);
            if($this->data['data']==null)
            redirect(base_url()."usermanagement_module/edit_module");
        }

        $this->data['title'] = _l("category",$this);
        $this->data['module'] = $this->Usermodule_model->view_usermodule();            
        $this->data['content']=$this->load->view('usermanagement_module'.'/module_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function add_module($id=null)
    {
        if ($this->Usermodule_model->add_usermodule($_POST["data"],$id))
        {
            $this->session->set_flashdata('success', _l('Updated Module',$this));
        }
        else
        {
            $this->session->set_flashdata('error', _l('Updated Module error. Please try later',$this));
        }
        redirect(base_url()."usermanagement_module/view_module/");
    }

    function delete_module($id=0)
    {   
        // validate_permissions('Usermanagement_module', 'delete_module', $this->config->item('method_for_delete'));

        $this->db->trans_start();
        $this->db->delete('user_module', array('module_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted Module',$this));
        redirect(base_url()."usermanagement_module/view_module/");
    }

}
