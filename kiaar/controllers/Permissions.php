<?php
/**
 * Created by Kiaar Team.
 * User: Kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.Kiaar.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Permissions extends Kiaar_Controller {
    private $permission_method_ids;
    private $permission_page_ids;

    function __construct()
    {
        parent::__construct('backend');
        // $permissions = $this->Kiaar_general_admin_model->get_session_permissions($this->session->userdata['group_id'], $this->session->userdata['user_id']);
        $this->permission_method_ids    = [];
        $this->permission_page_ids      = [];
    }

    function view_permissions()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "application_permissions";
        $this->data['child_menu_type'] = "application_permissions";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Permissions', 'view_permissions', $this->config->item('method_for_view'));

        $this->data['data_list']=$this->Permissions_model->view_permission();
        $this->data['title'] = _l("Permissions",$this);
        $this->data['page'] = "Permissions";
        $this->data['content']=$this->load->view('permissions'.'/permissions',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit_permissions($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "application_permissions";
        $this->data['child_menu_type'] = "application_permissions";
        $this->data['sub_child_menu_type'] = "";

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Permissions', 'edit_permissions', $per_action);

        $this->data['permissions']      = [];
        $this->data['select_all_data']  = [];

        if($id!='')
        {
            $this->data['data']         = $this->Permissions_model->edit_permission($id);
            $group=$this->data['data']['pr_group_id'];
            $instituteid=$this->data['data']['pr_inst_id'];
            if($this->data['data']==null)
            {
                $msg                    = ['error' => 0, 'message' => 'Permission not found'];
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url()."permissions/view_permissions");
            }

            if(isset($this->data['data']['permissions']) && !empty($this->data['data']['permissions']))
            {
                $this->data['permissions'] = explode(',', $this->data['data']['permissions']);
            }
            $this->data['select_all_data'] = explode(',', $this->data['data']['select_all']);
        }
        // echo "<pre>";print_r($this->data['select_all_data']);exit;

        $this->data['title']            = _l("Permissions",$this); 
        $this->data['module']           = $this->Usermodule_model->view_usermodule();
        $this->data['groups']           = $this->Kiaar_general_admin_model->get_all_groups();
        $this->data['institutes_list']  = $this->Kiaar_general_admin_model->get_all_institute();
        $this->permission_method_ids    = [];
        $this->data['methods']          = $this->get_nested_modules();

        if($this->input->post())
        {
            $allowed_method_ids         = [];
            $save_data                  = [];
            $save_data['pr_group_id']   = isset($_POST['pr_group_id']) ? $_POST['pr_group_id'] : '';
            $save_data['pr_inst_id']    = isset($_POST['pr_inst_id']) ? $_POST['pr_inst_id'] : '';
            $save_data['select_all']    = implode(',', array_values(array_filter($this->input->post('selectall'))));

            foreach ($this->permission_method_ids as $key => $value) {
                if(isset($_POST['method-'.$value['pm_id']]) && $_POST['method-'.$value['pm_id']] == 1)
                {
                    $allowed_method_ids[] = $value['pm_id'];
                }
                // $save_data['methods'][$value['pm_id']] = isset($_POST['method-'.$value['pm_id']]) ? $_POST['method-'.$value['pm_id']] : 0;
            }

            $save_data['permissions']   = !empty($allowed_method_ids) ? implode(',', $allowed_method_ids) : '';

            $sql = 'SELECT pr_id FROM user_permissions WHERE 1=1 AND pr_group_id="'.$save_data['pr_group_id'].'" AND pr_inst_id="'.$save_data['pr_inst_id'].'"';
            $result = $this->common_model->custom_query($sql);
            if(isset($result[0]['pr_id']) && !empty($result[0]['pr_id']))
            {
                $id                          = $result[0]['pr_id'];
            }

            if($this->Permissions_model->add_permission($save_data, $id))
            {
                $msg                    = ['error' => 0, 'message' => 'Permissions successfully saved'];
            }
            else
            {
                $msg                    = ['error' => 0, 'message' => 'Unable to save permissions'];
            }
            $this->session->set_flashdata('requeststatus', $msg);
            redirect(base_url().'permissions/view_permissions/');
        }

        $this->data['content']=$this->load->view('permissions'.'/permissions_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function get_nested_modules($parent = 0) {
        $items      = array();
        $results    = $this->common_model->custom_query('Select * from user_module where parent_id="'.$parent.'" order by module_id ASC');
        foreach($results as $result) {
            $child_array        = $this->get_nested_modules($result['module_id']);
            $result['methods']  = $this->get_permission_methods($result['module_id']);

            // echo "<pre>";print_r($result['methods']);//exit;

            if(!empty($result['methods']))
            {
                foreach ($result['methods'] as $mkey => $mvalue) {
                    $this->permission_method_ids[$mvalue['pm_id']] = ['pm_id' => $mvalue['pm_id'], 'pm_method' => $mvalue['pm_method']];
                }
                // $pm_id          = array_column($result['methods'], 'pm_id');
                // $this->permission_method_ids = array_merge($this->permission_method_ids, $pm_id);
            }

            if(sizeof($child_array) == 0) {
                $result['sub_module'] = [];
                array_push($items, $result);
            } else {
                $result['sub_module'] = $child_array;
                array_push($items, $result);
            }
        }
        return $items;
    }

    function get_permission_methods($module_id='')
    {
        $results        = [];
        if($module_id)
        {
            $results    = $this->common_model->custom_query('Select * from user_permission_method where pm_module_id="'.$module_id.'" order by pm_order ASC');
        }
        return $results;
    }

    function add_permissions($id=null)
    {
        if ($this->Permissions_model->add_permission($_POST["data"],$id))
        {
            $this->session->set_flashdata('success', _l('Updated Permission',$this));
        }
        else
        {
            $this->session->set_flashdata('error', _l('Updated Permission error. Please try later',$this));
        }
        redirect(base_url()."permissions/view_permissions/");
    }

    function appenduser()
    { 
        $group_id = $_POST['pr_group_id'];

        $query=$this->db->query("SELECT u.user_id,u.fullname FROM users u LEFT JOIN groups g ON u.group_id=g.group_id WHERE u.group_id=".$group_id."");
        $rowCount = $query->num_rows();
            
        if($rowCount > 0){
            echo '<option value="">Select Group</option>';
            foreach ($query->result() as $row) { 
                echo '<option value="'.$row->user_id.'">'.$row->fullname.'</option>';
            }
        }else{
            echo '<option value="">Users not available</option>';
        }
    }

    function appendpages()
    { 
        $institute_id = $_POST['pr_inst_id'];

        $query=$this->db->query("SELECT p.page_id,p.page_name FROM page p LEFT JOIN edu_institute_dir i ON p.institute_id=i.INST_ID WHERE i.INST_ID=".$institute_id."");
        $rowCount = $query->num_rows();
            
        if($rowCount > 0){
            echo '<option value="">Select Group</option>';
            foreach ($query->result() as $row) { 
                echo '<option value="'.$row->page_id.'">'.$row->page_name.'</option>';
            }
        }else{
            echo '<option value="">Pages not available</option>';
        }
    }

    function custom_unique_permissions($post, $func)
    {
        $this->form_validation->set_message('custom_unique_username', "Username already exist");

        $result = TRUE;
        if(!empty($post))
        {
            $pr_id          = isset($post['pr_id']) ? $post['pr_id'] : '';
            $pr_group_id    = isset($post['pr_group_id']) ? $post['pr_group_id'] : '';
            $pr_inst_id     = isset($post['pr_inst_id']) ? $post['pr_inst_id'] : '';
            $pr_user_id     = isset($post['pr_user_id']) ? $post['pr_user_id'] : '';
            $pr_valid_from  = isset($post['pr_valid_from']) ? $post['pr_valid_from'] : '';
            $pr_valid_upto  = isset($post['pr_valid_upto']) ? $post['pr_valid_upto'] : '';

            $sql            = 'SELECT * FROM user_permissions WHERE 1=1';

            if(!empty($pr_group_id))
            {
                $sql .= ' AND pr_group_id="'.$pr_group_id.'"';
            }
            if(!empty($pr_inst_id))
            {
                $sql .= ' AND pr_inst_id="'.$pr_inst_id.'"';
            }
            if(!empty($pr_user_id))
            {
                $sql .= ' AND pr_user_id="'.$pr_user_id.'"';
            }
            if(!empty($pr_id))
            {
                $sql .= ' AND pr_id != "'.$pr_id.'"';
            }
            $result = $this->common_model->custom_query($sql);

            if(isset($result[0]) && !empty($result[0]))
            {
                $result = FALSE;
            }
            else
            {
                $result = TRUE;
            }
        }
        return $result;
    }

    function ajax_check_permissions()
    {
        if($this->input->post())
        {
            $result = $this->custom_unique_permissions($this->input->post(), '');
            echo $result;exit;
        }
    }

    function delete_permissions($id=0)
    {
        $this->common_model->set_table('user_permissions');
        $response = $this->common_model->_delete('pr_id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url()."permissions/view_permissions/");
    }

    function view_page_permissions()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "page_permissions";
        $this->data['child_menu_type'] = "page_permissions";
        $this->data['sub_child_menu_type'] = "";

        $this->data['data_list']    = $this->Permissions_model->view_page_permissions();
        $this->data['title']        = _l("Page Permissions",$this);
        $this->data['page']         = "Page Permissions";
        $this->data['content']      = $this->load->view('permissions'.'/page_permissions',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function edit_page_permissions($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "page_permissions";
        $this->data['child_menu_type'] = "page_permissions";
        $this->data['sub_child_menu_type'] = "";
        
        if($this->input->post())
        {
            $edit_permissions   = [];
            $delete_permissions = [];
            $view_permissions   = [];
            foreach ($this->input->post('page_id') as $key => $page_id) {
                if(isset($_POST['editval-'.$page_id]) && $_POST['editval-'.$page_id] == 1)
                {
                    $edit_permissions[]     = $page_id;
                }
                if(isset($_POST['deleteval-'.$page_id]) && $_POST['deleteval-'.$page_id] == 1)
                {
                    $delete_permissions[]   = $page_id;
                }
                if(isset($_POST['viewval-'.$page_id]) && $_POST['viewval-'.$page_id] == 1)
                {
                    $view_permissions[]     = $page_id;
                }
            }

            $save_data['pr_group_id']        = $this->input->post('pr_group_id');
            $save_data['pr_inst_id']         = $this->input->post('pr_inst_id');
            $save_data['add_permissions']    = $this->input->post('add_page_method');
            $save_data['edit_permissions']   = implode(',', $edit_permissions);
            $save_data['delete_permissions'] = implode(',', $delete_permissions);
            $save_data['view_permissions']   = implode(',', $view_permissions);
            $save_data['select_all']         = implode(',', array_values(array_filter($this->input->post('selectall'))));

            $sql = 'SELECT pr_id FROM user_page_permissions WHERE 1=1 AND pr_group_id="'.$save_data['pr_group_id'].'" AND pr_inst_id="'.$save_data['pr_inst_id'].'"';
            $result = $this->common_model->custom_query($sql);
            if(isset($result[0]['pr_id']) && !empty($result[0]['pr_id']))
            {
                $id                          = $result[0]['pr_id'];
            }

            if($this->Permissions_model->save_page_permission($save_data, $id))
            {
                $msg                    = ['error' => 0, 'message' => 'Page permissions successfully saved'];
            }
            else
            {
                $msg                    = ['error' => 0, 'message' => 'Unable to save page permissions'];
            }
            $this->session->set_flashdata('requeststatus', $msg);
            redirect(base_url().'permissions/view_page_permissions/');
        }

        $this->data['group_id']             = '';
        $this->data['institute_id']         = '';

        if($id!='')
        {
            $this->data['pagedata']             = $this->Permissions_model->edit_page_permission($id);
            if($this->data['pagedata']==null)
            {
                $msg                    = ['error' => 0, 'message' => 'Page permission not found'];
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url()."permissions/view_page_permissions");
            }
            $this->data['group_id']             = $this->data['pagedata']['pr_group_id'];
            $this->data['institute_id']         = $this->data['pagedata']['pr_inst_id'];
        }

        $this->data['pr_id']            = $id;
        $this->data['title']            = _l("Page Permissions",$this);
        // $this->data['menu_data']        = $this->nested_menu(50);
        $this->data['groups']           = $this->Kiaar_general_admin_model->get_all_groups();
        $this->data['institutes_list']  = $this->Kiaar_general_admin_model->get_all_institute();
        // echo "<pre>";print_r($this->data['menu_data']);
        // exit;
        $this->data['content']      = $this->load->view('permissions'.'/page_permissions_form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function delete_page_permissions($id=0)
    {
        $this->common_model->set_table('user_page_permissions');
        $response = $this->common_model->_delete('pr_id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url()."permissions/view_page_permissions/");
    }

    function get_menu_table()
    {
        if($this->input->post('inst_id'))
        {
            $pr_id                              = $this->input->post('pr_id');
            $inst_id                            = $this->input->post('inst_id');
            $this->data['add_permissions']      = 0;
            $this->data['edit_permissions']     = [];
            $this->data['delete_permissions']   = [];
            $this->data['view_permissions']     = [];
            $this->data['select_all_data']      = [];

            if($pr_id!='')
            {
                $this->data['pagedata']             = $this->Permissions_model->edit_page_permission($pr_id);

                if(!empty($this->data['pagedata']))
                {
                    $this->data['add_permissions']      = isset($this->data['pagedata']['add_permissions']) ? $this->data['pagedata']['add_permissions'] : 0;
                    if(isset($this->data['pagedata']['edit_permissions']) && !empty($this->data['pagedata']['edit_permissions']))
                    {
                        $this->data['edit_permissions'] = explode(',', $this->data['pagedata']['edit_permissions']);
                    }
                    if(isset($this->data['pagedata']['delete_permissions']) && !empty($this->data['pagedata']['delete_permissions']))
                    {
                        $this->data['delete_permissions'] = explode(',', $this->data['pagedata']['delete_permissions']);
                    }
                    if(isset($this->data['pagedata']['view_permissions']) && !empty($this->data['pagedata']['view_permissions']))
                    {
                        $this->data['view_permissions'] = explode(',', $this->data['pagedata']['view_permissions']);
                    }
                    $this->data['select_all_data']      = explode(',', $this->data['pagedata']['select_all']);
                }
            }
            $menu_data               = $this->nested_menu($inst_id);
            $this->data['menu_data'] = $menu_data['menu_data'];
            $this->data['otherpage'] = $this->Permissions_model->get_other_page($menu_data['permission_page_ids'], $inst_id);
            $html                    = $this->load->view('permissions'.'/page_permissions_table', $this->data, true);
            echo $html;exit;
        }
    }

    function nested_menu($instituteId)
    {
        $result = [];
        $i = 0;
        $menu_data = $this->Kiaar_general_admin_model->get_all_menu_for_pages(array('sub_menu' => 0, 'sub_sub_menu' => 0, 'menu.institute_id' => $instituteId));

        foreach ($menu_data as $menukey => $menu) {
            if(!in_array($menu['page_id'], $this->permission_page_ids))
            {
                $this->permission_page_ids[] = $menu['page_id'];
            }

            $result['main_menu_data'][$i] = $menu;
            $j = 0;
            $child_menu_data = [];
            $rowspan = 0;
            $child_rowspan = 0;
            $sub_menu_data = $this->Kiaar_general_admin_model->get_all_menu_for_pages(array('sub_menu' => $menu['menu_id'], 'sub_sub_menu' => 0, 'institute_id' => $instituteId));
            foreach ($sub_menu_data as $submenukey => $sub_menu) {
                if(!in_array($sub_menu['page_id'], $this->permission_page_ids))
                {
                    $this->permission_page_ids[] = $sub_menu['page_id'];
                }

                $result['main_menu_data'][$i]['sub_menu_data'][$j] = $sub_menu;
                $child_menu_data = $this->Kiaar_general_admin_model->get_all_menu_for_pages(array('sub_menu' => $sub_menu['menu_id'], 'sub_sub_menu' => 0, 'institute_id' => $instituteId));
                $page_id = array_column($child_menu_data, 'page_id');
                if(!empty($page_id))
                {
                    $this->permission_page_ids = array_merge($this->permission_page_ids, array_filter($page_id));
                }

                $result['main_menu_data'][$i]['sub_menu_data'][$j]['child_menu_data'] = $child_menu_data;
                $child_rowspan = $child_rowspan + count($child_menu_data);
                if(count($child_menu_data) > 0)
                {
                    $rowspan = $rowspan + count($child_menu_data);
                }
                else
                {
                    $rowspan = $rowspan + 1;
                }
                ++$j;
            }
            $result['main_menu_data'][$i]['rowspan'] = $rowspan;
            ++$i;
        }
        $permission_page_ids = array_values(array_filter($this->permission_page_ids));
        return ['menu_data' => $result, 'permission_page_ids' => $permission_page_ids];
    }
}
