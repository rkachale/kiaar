<?php
/**
 * Created by Kiaar Team.
 * User: Kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Permission_method extends Kiaar_Controller {
    function __construct()
    {
        parent::__construct('backend');
        validate_permissions('', '', '', 'notallowed');
    }

    function view_permission_method()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "methods";
        $this->data['child_menu_type'] = "methods";
        $this->data['sub_child_menu_type'] = "";

        // validate_permissions('Permission_method', 'view_permission_method', $this->config->item('method_for_view'));

        $this->data['data_list']=$this->Permethod_model->view_permethod();
        $this->data['title'] = _l("Permission Method",$this);
        $this->data['page'] = "Permission Method";
        $this->data['content']=$this->load->view('permission_method'.'/permethod',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit_permission_method($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "methods";
        $this->data['child_menu_type'] = "methods";
        $this->data['sub_child_menu_type'] = "";
        
        // $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        // validate_permissions('Permission_method', 'edit_permission_method', $per_action);

        if($id!='')
        {
            $this->data['data']=$this->Permethod_model->edit_permethod($id);
            $controllername=$this->data['data']['pm_controller_name'];
            $this->data['controller_method']=$this->Permethod_model->getControllerMethods($controllername);
            if($this->data['data']==null)
            redirect(base_url()."permission_method/edit_permission_method");
        }

        $this->data['title'] = _l("Permission Method",$this); 
        $this->data['module'] = $this->Usermodule_model->view_usermodule();
        $this->data['institutes_list'] = $this->Kiaar_general_admin_model->get_all_institute();

        $controllers = array();
        $this->load->helper('file');

        $files = get_dir_file_info(APPPATH.'controllers', FALSE);

        // Loop through file names removing .php extension
        foreach (array_keys($files) as $file)
        {
        $controllers[] = str_replace('.php', '', $file);
        }
        $this->data['controller'] = $controllers;

        $this->load->library('controllerlist');
        $this->data['data_list']=$this->controllerlist->getControllers();
        $this->data['content']=$this->load->view('permission_method'.'/permethod_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function appendmethod()
    { 
        $this->load->library('controllerlist');
        $controller = $_POST['controller'];
        $this->controllerlist->getControllers($_POST['controller']);
        $methods = get_class_methods( str_replace( '.php', '', $controller ) );

        $rowCount = print_r(array_count_values($methods));

        if($rowCount > 0){
        echo '<option value="">Select Methods</option>';
        foreach ($methods as $row) { echo "<pre>"; print_r($row);
            echo '<option value="'.$row.'">'.$row.'</option>';
        }
        }else{
            echo '<option value="">Method not available</option>';
        }

    }

    function add_permission_method($id=null)
    {
        if ($this->Permethod_model->add_permethod($_POST["data"],$id))
        {
            $this->session->set_flashdata('success', _l('Updated Module',$this));
        }
        else
        {
            $this->session->set_flashdata('error', _l('Updated Module error. Please try later',$this));
        }
        redirect(base_url()."permission_method/view_permission_method/");
    }

    function delete_permission_method($id=0)
    {   
        // validate_permissions('Permission_method', 'delete_permission_method', $this->config->item('method_for_delete'));
        
        $this->db->trans_start();
        $this->db->delete('user_permission_method', array('pm_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted Module',$this));
        redirect(base_url()."permission_method/view_permission_method/");
    }

}
