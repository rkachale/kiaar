<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    function get_group_and_institutes($inst_id='')
    {
        $ci =& get_instance();
        $user_id = $ci->session->userdata['user_id'];

        $ci->db->select("group_id, institute_id");
        $ci->db->from("user_groups_institute");
        $ci->db->where("user_id", $user_id);
        if($inst_id)
        {
            $ci->db->where("institute_id", $inst_id);
        }
        $query = $ci->db->get();
        return $query->result_array();
    }

    function get_method_id($controller, $method, $action)
    {
        $ci =& get_instance();
        $ci->db->select("pm_id");
        $ci->db->from('user_permission_method');
        $ci->db->where('pm_controller_name', $controller);
        $ci->db->where('pm_method', $method);
        $ci->db->where('pm_order', $action);
        $query = $ci->db->get();
        return isset($query->result_array()[0]['pm_id']) ? $query->result_array()[0]['pm_id'] : '';
    }

    if(!function_exists('validate_permissions'))
    {
        function validate_permissions($controller, $method, $action, $inst_id='')
        {
            // echo "<pre>";print_r($_SESSION);exit;
            $ci      =& get_instance();
            $allowed = false;
            $user_id = $ci->session->userdata['user_id'];

            if($user_id == 1)
            {
                $allowed              = true;
            }
            else
            {
                $groups_institutes    = get_group_and_institutes($inst_id);

                if(!empty($groups_institutes))
                {
                    if($inst_id)
                    {
                        $akey = array_search($inst_id, array_column($groups_institutes, 'institute_id'));
                        if(isset($groups_institutes[$akey]['group_id']) && $groups_institutes[$akey]['group_id'] == 1)
                        {
                            return true;
                        }
                    }

                    $pm_id = get_method_id($controller, $method, $action);

                    if($pm_id)
                    {
                        $orconditions = [];
                        foreach ($groups_institutes as $key => $value) {
                            $orconditions[] = '(up.pr_group_id = "'.$value['group_id'].'" AND up.pr_inst_id = "'.$value['institute_id'].'")';
                        }
                        $or_condition = "(".implode(' OR ', $orconditions).")";

                        $sql          = 'SELECT count(up.pr_id) as allowed FROM `user_permissions` `up` WHERE FIND_IN_SET("'.$pm_id.'", (up.permissions)) AND '.$or_condition;
                        $query        = $ci->db->query($sql);
                        $permissions  = $query->row_array();
                        if(isset($permissions['allowed']) && !empty($permissions['allowed']))
                        {
                            $allowed  = true;
                        }
                        else
                        {
                            $allowed  = false;
                        }
                    }
                    else
                    {
                        $allowed      = false;
                    }
                }
                else
                {
                    $allowed          = false;
                }
            }

            if($allowed)
            {
                return true;
            }
            else
            {
                $ci->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Access Denied.']);
                redirect(base_url()."admin/");
            }
        }
    }

    if(!function_exists('validate_page_permissions'))
    {
        function validate_page_permissions($page_id='', $action, $inst_id='')
        {
            $ci      =& get_instance();
            $allowed = false;
            $user_id = $ci->session->userdata['user_id'];
            $columns =  [
                            2 => 'edit_permissions',
                            3 => 'delete_permissions',
                            4 => 'view_permissions'
                        ];
            // echo "<pre>page_id";print_r($page_id);//exit;
            // echo "<pre>action";print_r($action);//exit;
            // echo "<pre>inst_id";print_r($inst_id);exit;

            if($user_id == 1)
            {
                $allowed              = true;
            }
            else
            {
                $groups_institutes    = get_group_and_institutes($inst_id);

                if(!empty($groups_institutes))
                {
                    if($inst_id)
                    {
                        $akey = array_search($inst_id, array_column($groups_institutes, 'institute_id'));
                        if(isset($groups_institutes[$akey]['group_id']) && $groups_institutes[$akey]['group_id'] == 1)
                        {
                            return true;
                        }
                    }
                    
                    $orconditions = [];
                    foreach ($groups_institutes as $key => $value) {
                        $orconditions[] = '(up.pr_group_id = "'.$value['group_id'].'" AND up.pr_inst_id = "'.$value['institute_id'].'")';
                    }
                    $or_condition = "(".implode(' OR ', $orconditions).")";

                    if($action == $ci->config->item('method_for_add'))
                    {
                        $sql      = 'SELECT count(up.pr_id) as allowed FROM `user_page_permissions` `up` WHERE up.add_permissions = 1 AND '.$or_condition;
                    }
                    else
                    {
                        $columnn  = $columns[$action];
                        $sql      = 'SELECT count(up.pr_id) as allowed FROM `user_page_permissions` `up` WHERE FIND_IN_SET("'.$page_id.'", (up.'.$columnn.')) AND '.$or_condition;
                    }

                    $query        = $ci->db->query($sql);
                    $permissions  = $query->row_array();
                    if(isset($permissions['allowed']) && !empty($permissions['allowed']))
                    {
                        $allowed  = true;
                    }
                    else
                    {
                        $allowed  = false;
                    }
                }
                else
                {
                    $allowed          = false;
                }
            }

            if($allowed)
            {
                return true;
            }
            else
            {
                $ci->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Access Denied.']);
                redirect(base_url()."admin/");
            }
        }
    }