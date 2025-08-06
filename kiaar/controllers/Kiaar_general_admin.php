<?php
/**
 * Created by kiaar Team.
 * User: kiaar
 * Date: 9/16/2015
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Kiaar_general_admin extends Kiaar_Controller 
{
    function __construct()
    {
        parent::__construct('backend');
        
        //load google login library
        //$this->load->library('google');
        
        //google login url
        //$data['loginURL'] = $this->google->loginURL();
        $user_id = $this->session->userdata['user_id'];

    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type'] = "dashboard";
        $this->data['sub_menu_type'] = "dashboard";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $this->data['languages'] = $this->Kiaar_general_admin_model->get_all_language();
        foreach($this->data['languages'] as &$item){
            $item["content_percent"] = $this->Kiaar_general_admin_model->count_extensions(array("language_id"=>$item["language_id"]))!=0?(($this->Kiaar_general_admin_model->count_extensions(array("language_id"=>$item["language_id"])) * 100) / $extension_count):0;
        }
        
        $this->data['content']=$this->load->view($this->mainTemplate.'/main',$this->data,true);
        $this->data['title'] = "home";
        $this->data['page'] = "home";
        $this->load->view($this->mainTemplate,$this->data);
    }



    /** SETTINGS **/

    function settings($sub_page='general')
    {
        $this->data['main_menu_type'] = "settings";
        $this->data['sub_menu_type'] = "settings";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Kiaar_general_admin', 'settings', $this->config->item('method_for_view'), $this->default_institute_id);

        if(isset($_POST['data'])){
                $data = $this->input->post('data');
                if(isset($data["options"])){
                    foreach($data["options"] as $key=>$value){
                        if($this->Kiaar_general_admin_model->check_setting_options($key)){
                            $this->Kiaar_general_admin_model->edit_setting_options($key,$value);
                        }else{
                            $this->Kiaar_general_admin_model->insert_setting_options($key,$value);
                        }
                    }
                    unset($data["options"]);
                }
                $this->Kiaar_general_admin_model->edit_setting($data);
                $this->session->set_flashdata('success', _l("Your Setting has been updated successfully!",$this));
            redirect(base_url('admin/settings/'.$sub_page));
        }

        $data_options = array();
        $setting_options = $this->Kiaar_general_admin_model->get_all_setting_options();
        foreach($setting_options as $value){
            $data_options[$value["language_id"]] = $value;
        }
        $this->data['options'] = $data_options;
        $this->data['languages'] = $this->Kiaar_general_admin_model->get_all_language();
        if($sub_page=='general'){
            $this->data['title'] = _l('General settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting',$this->data,true);
        }elseif($sub_page=='seo'){
            $this->data['title'] = _l('SEO optimise',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_seo',$this->data,true);
        }elseif($sub_page=='contact'){
            $this->data['title'] = _l('Contact settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_contact',$this->data,true);
        }elseif($sub_page=='mail'){
            $this->data['public_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Site Email',$this),'value'=>'[--$smail--]'),
                array('label'=>_l('Date',$this),'value'=>'[--$date--]'),
            );
            $this->data['register_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Username',$this),'value'=>'[--$username--]'),
                array('label'=>_l('Email address',$this),'value'=>'[--$email--]'),
                array('label'=>_l('User activate URL',$this),'value'=>'[--$refurl--]'),
                array('label'=>_l('Date',$this),'value'=>'[--$date--]'),
                array('label'=>_l('User created date',$this),'value'=>'[--$cdate--]'),
            );
            $this->data['activate_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Username',$this),'value'=>'[--$username--]'),
                array('label'=>_l('Email address',$this),'value'=>'[--$email--]'),
                array('label'=>_l('Date',$this),'value'=>'[--$date--]'),
            );
            $this->data['reset_pass_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Username',$this),'value'=>'[--$username--]'),
                array('label'=>_l('Email address',$this),'value'=>'[--$email--]'),
                array('label'=>_l('Make new password URL',$this),'value'=>'[--$refurl--]'),
            );
            $this->data['title'] = _l('Send mail settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_mail',$this->data,true);
        }elseif($sub_page=='media_source'){
            $this->data['title'] = _l('Media source settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_media_source',$this->data,true);
        }
        $this->data['page'] = "setting";
        $this->load->view($this->mainTemplate,$this->data);
    }


    /** USER MODULE CODE **/

    function user()
    {
        $this->data['data_list']=$this->Kiaar_general_admin_model->get_all_user();
        $this->data['title'] = _l("User",$this);
        $this->data['page'] = "user";
        $this->data['content']=$this->load->view($this->mainTemplate.'/user',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edituser($id='')
    {
            if($id!='')
            {
                $this->data['data']=$this->Kiaar_general_admin_model->get_user_detail($id);
                if($this->data['data']==null)
                    redirect(base_url()."admin/user");
            }

            //$this->form_validation->set_rules('login_type', 'Login Type', 'required');

            // if(isset($_POST['login_type']) && !empty($_POST['login_type']))
            // {
            //     if($_POST['login_type'] == '1')
            //     {
            //         //$this->form_validation->set_rules('username', 'Username', 'required|callback_custom_unique_username[username]');
            //         if(isset($_POST['email']) && !empty($_POST['email']))
            //         {
            //             // $this->form_validation->set_rules('email', 'Email', 'callback_custom_unique_email[email]');
            //         }
            //     }
            //     else if($_POST['login_type'] == '2')
            //     {
            //         //$this->form_validation->set_rules('email', 'Email', 'required|callback_custom_unique_email[email]');
            //     }
            // }

            // if($this->form_validation->run($this) === TRUE)
            // {
                if($this->input->post())
                {
                    if($this->Kiaar_general_admin_model->user_manipulate($_POST, $id))
                    {
                        $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'User saved successfully']);
                    }
                    else
                    {
                        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Unable to save an user']);
                    }
                    redirect(base_url()."admin/");
                }
            // }

            $this->data['title'] = _l("User",$this);
            $this->data['page'] = "user";
            $this->data['content']=$this->load->view($this->mainTemplate.'/user_edit',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
    }

    function user_manipulate($id=null)
    {
        if($this->Kiaar_general_admin_model->user_manipulate($_POST["data"], $id))
        {
            $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'User saved successfully']);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Unable to save an user']);
        }
        redirect(base_url()."admin/user/");
    }

}