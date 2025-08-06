<?php
/**
 * Created by kiaar Team.
 * User: kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Kiaar_general_admin_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_assigned_institute_list()
    {
        if($this->session->userdata['user_id'] != 1)
        {
            $this->db->select("ugi.institute_id, eid.INST_ID, eid.INST_NAME, eid.INST_SHORTNAME");
            $this->db->from('user_groups_institute ugi');
            $this->db->join('edu_institute_dir eid', 'ugi.institute_id = eid.INST_ID');
            $this->db->where('ugi.user_id', $this->session->userdata['user_id']);
        }
        else
        {
            $this->db->select("eid.*");
            $this->db->from('edu_institute_dir eid');
        }
        $this->db->order_by('eid.INST_ID','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_assigned_institute($INST_ID)
    {
        $this->db->select("eid.*");
        $this->db->from('edu_institute_dir eid');
        $this->db->where('eid.INST_ID', $INST_ID);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* SETTINGS CODE */

    function get_website_info()
    {
        $this->db->select('*');
        $this->db->from('setting');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_setting($data=null){
        $this->db->set('id', 1);
        $this->db->update('setting', $data);
        return true;
    }


    /* LANGUAGE CODE */


    function get_all_language()
    {
        $this->db->select("*");
        $this->db->from('languages');
        $this->db->order_by('sort_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_language_detail($id)
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('language_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function language_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if (!isset($data['rtl'])) {
            $data['rtl']=0;
        }
        if (!isset($data['public'])) {
            $data['public']=0;
        }
        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }
        if (!isset($data['default'])) {
            $data['default']=0;
        }

        if ($this->session->userdata('group') != 1 && isset($data['default'])) {
            unset($data['default']);
        }
        if ($this->session->userdata('group') != 1 && isset($data['public'])) {
            unset($data['public']);
        }

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if($id!=null) // update
        {
            $this->db->where('language_id',$id);
            $this->db->update('languages',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('languages',$data);
        }
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* MAIN MENU CODE */

     function get_all_subsubmenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->order_by('menu_order','ASC');     
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_submenu($conditions=null)
    {
        $this->db->select('menu_id,menu_name,sub_menu,menu_order,public');
        $this->db->from('menu');
        if($conditions!=null) $this->db->where($conditions);
        // $this->db->where('sub_menu!=0');
        $this->db->order_by('menu_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_menu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->order_by('menu_order','ASC');     
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_menu_for_pages($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('public', 1);
        $this->db->order_by('menu_order','ASC');     
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_menu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function menu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('menu');
        }

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }


        if(isset($data["target"]) && count($data["target"])!=0){
            $data["target"]=1;
        } else {
            $data["target"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('menu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('menu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"menu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"menu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* USER CODE */

    function get_user_detail($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function user_manipulate($data, $id=null)
    {   echo "<pre>"; print_r($data);
        $this->db->trans_start();

        // $institute      = $this->input->post('institute_id[]');
        $login_type     = $this->input->post('login_type');
        $username       = $this->input->post('username');
        $fullname       = $this->input->post('fullname');
        $email          = $this->input->post('email');
        $password       = '';
        if(isset($data['password']) && $data['password'] != "")
        {
            $password   = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        // if($login_type == 2)
        // {
        //     $username   = '';
        // }

        $processdata    = array(
                                'login_type'    => $login_type,
                                'username'      => $username,
                                'fullname'      => $fullname,
                                'email'         => $email,
                                'password'      => $password
                            );

        if(isset($processdata['password']) && $processdata["password"] == "")
        {
            unset($processdata['password']);
        }

        if($id!=null) // update
        {   
            //echo "i am here";exit();
            $this->db->where('user_id', $id);
            $this->db->update('users', $processdata);

            // $save = [];
            // $save_user_group = [];
            // foreach ($data['group_array'] as $key => $value) {
            //     $save['group_id'] = $value;
            //     $save['institute_id'] = $data['institute_array'][$key];
            //     $save['ugiid'] = $data['ugiid'][$key];
            //     $save_group_inst[] = $save;
            // }

            // // echo"<pre>";print_r($save_group_inst);

            // $relation_id = $this->input->post('relation_id');
            // $id2 = $this->input->post('ugiid');
            // // print_r($id2);exit();

            // if($id2 == ''){ 
            //     if(isset($data['user_array_check']) && $data['user_array_check'] == 1){ //echo"m in insert";exit();
            //         foreach($save_group_inst as $key => $result){ 
            //             $this->db->insert('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$id));
            //             // echo "<pre>";print_r($this->db->last_query());exit;
            //         }
            //     }
            // } 

            // if(isset($data['user_array_check']) && $data['user_array_check'] == 2){ //echo"m in update";exit();
            //     if (!empty($save_group_inst))  {  
            //         foreach($save_group_inst as $key => $result){ 
            //             if($result['ugiid'] == ''){
            //                 $this->db->insert('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$id));
            //             }
            //             $this->db->where('ugiid',$result['ugiid']);
            //             $this->db->update('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$relation_id)); 
            //             // echo "<pre>";print_r($this->db->last_query());exit;
            //         }
            //     }
            // }

        }
        else    //add
        {   
            $processdata['created_date'] = date('d/m/Y');
            $this->db->insert('users', $processdata);
            $id = $this->db->insert_id();

            // $save = [];
            // $save_user_group = [];
            // foreach ($data['group_array'] as $key => $value) {
            //     $save['group_id'] = $value;
            //     $save['institute_id'] = $data['institute_array'][$key];
            //     $save_group_inst[] = $save;
            // }

            // $i=0;
            // foreach($save_group_inst as $result){     
            //     $this->db->insert('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$id));
            //     $i++;    
            // } 
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_all_user()
    {

        $this->db->select("*");
        $this->db->from('users');
        $this->db->group_by("users.user_id");
        $this->db->order_by('users.user_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_uservalue($id)
    {
        $this->db->select('*');
        $this->db->from('user_groups_institute');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return  $query->result_array();
    }


    /* USER GROUPS CODE */


    function get_all_groups()
    {
        $this->db->select("*");
        $this->db->from('groups');
        $this->db->order_by('group_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_groups_detail($id)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where('group_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function groups_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if (isset($data['password']) && $data["password"]=="") {
            unset($data['password']);
        }elseif(isset($data['password']) && $data['password']!=""){
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if($id!=null) // update
        {
            $pname = $this->input->post('permissions[]');
            $vv = $this->input->post('value');
            $name = implode(',', $pname);
            $group_name = $this->input->post('data[group_name]');
            $data = array( 
            'group_name' =>  $group_name 
            //'permissions' => implode(",", $pname)       
            );
            $this->db->where('group_id',$id);
            $this->db->update('groups',$data);
        }
        else    //add
        {
            $pname = $this->input->post('permissions[]');
            $vv = $this->input->post('value');
            $name = implode(',', $pname);
            $group_name = $this->input->post('data[group_name]');
            $data = array( 
            'group_name' =>  $group_name
            //'permissions' => implode(",", $pname)       
            );
            $this->db->insert('groups',$data);
        }
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_session_permissions($group_id,$user_id)
    {
        $this->db->select("groups.permissions");
        $this->db->from('groups');
        $this->db->join('users', 'users.group_id=groups.group_id');
        $this->db->where('users.user_id', $user_id);
        $this->db->where('groups.group_id', $group_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_session_permissions_institute($user_id)
    {
        $this->db->select("users.institute_id,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_name");
        $this->db->from('users');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('users.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_session_permissions_institute_new($user_id)
    {
        $this->db->select("user_permissions.pr_inst_id,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_name");
        $this->db->from('user_permissions');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,user_permissions.pr_inst_id)",'left');
        $this->db->join('user_groups_institute',"FIND_IN_SET(user_groups_institute.institute_id,user_permissions.pr_inst_id)",'left');
        $this->db->where('user_groups_institute.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* PAGE CONTENTS CODE */

    function get_extension_user_detail($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }


    /* PAGE CODE */

    function get_all_page()
    {
        $this->db->select("*");
        $this->db->from('page');
        $this->db->order_by('page_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

     function get_all_page_institute($id)
    {
        $this->db->select("*, page.created_date as created_date ,page.public as public");
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id','left');
        $this->db->join('users', 'users.user_id=extensions.user_id','left');
        $this->db->join('edu_institute_dir', 'edu_institute_dir.INST_ID=page.institute_id','left');
        $this->db->where('page.institute_id', $id);
        $this->db->order_by('page.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_search_page($data)
    {
        $this->db->select("*");
        $this->db->from('page');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('page_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_page($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id');
        $this->db->where('page.page_id', $id);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }

    function manage_page($data=[], $id='')
    { 
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_page($id)))
            {
                $update['page_name']                = $data['page_name'];
                $update['slug']                     = $data['slug'];
                $update['page_type']                = $data['page_type'];
                $update['institute_id']             = $data['institute_id'];
                $update['gallery_id']               = $data['gallery_id'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $this->db->where('page_id', $id);
                $this->db->update('page', $update);

                $upd['name']                        = $this->input->post('page_name');
                $upd['language_id']                 = $this->input->post('language_id');
                $upd['description']                 = $this->input->post('description');
                $upd['meta_title']                  = $this->input->post('meta_title');
                $upd['meta_description']            = $this->input->post('meta_description');
                $upd['meta_keywords']               = $this->input->post('meta_keywords');
                $upd['meta_image']                  = $this->input->post('meta_image');
                $upd['image']                       = $this->input->post('image');
                $upd['public']                      = $this->input->post('public');
                $upd['updated_date']                = date('Y-m-d H:i:s');
                $upd['user_id']                     = $this->session->userdata['user_id'];
                $this->db->where('extension_id', $data['extension_id']);
                $this->db->update('extensions', $upd);

                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"page"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"page"));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Page successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Page'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Page not found'];
            }
        }
        else
        {   
            $insert['page_name']                = $data['page_name'];
            $insert['slug']                     = $data['slug'];
            $insert['page_type']                = $data['page_type'];
            $insert['institute_id']             = $data['institute_id'];
            $insert['gallery_id']               = $data['gallery_id'];
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $this->db->insert('page', $insert);
            $insert_id = $this->db->insert_id();

            $ins['name']             = $this->input->post('page_name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['meta_title']       = $this->input->post('meta_title');
            $ins['meta_description'] = $this->input->post('meta_description');
            $ins['meta_keywords']    = $this->input->post('meta_keywords');
            $ins['meta_image']       = $this->input->post('meta_image');
            $ins['image']            = $this->input->post('image');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('extensions', $ins);
            $ins_id = $this->db->insert_id();


            $name=$this->input->post('page_name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"page"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$name,"relation_id"=>$insert_id,"data_type"=>"page"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"page"));
                }
            }
            

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Page successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Page'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }


    function get_all_galleryids()
    {
       $this->db->select('*');
       $this->db->from('galleries');
       $this->db->order_by('galleries.g_id','DESC');
       $query = $this->db->get();
       return $query->result_array();
    }

    
    /* GALLERY CODE */

    function get_gallery($data_type=null,$relation_id=null)
    {
        $this->db->select("*");
        $this->db->from('gallery');
        $this->db->where('data_type',$data_type);
        $this->db->where('relation_id',$relation_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_gallery_detail($gallery_id)
    {
        $this->db->select("*");
        $this->db->from('gallery');
        $this->db->where('gallery_id',$gallery_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }
    function get_insert_gallery($data){
        $this->db->trans_start();
        $data['created_date']=time();
        $this->db->insert('gallery',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }
    function gallery_manipulate($data,$id=null)
    {
        $this->db->trans_start();
        if(!isset($data['status'])){
            $data['status']=0;
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id!=null && $id!=0) // update
        {
            $this->db->where('gallery_id',$id);
            $data['updated_date']=time();
            $this->db->update('gallery',$data);
        }
        else    //add
        {
            $data['user_id']=$this->session->userdata['user_id'];
            $data['created_date']=time();
            $this->db->insert('gallery',$data);
            $id=$this->db->insert_id();

        }
        $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"gallery"));
        if(isset($titles)){
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"gallery"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    function get_gallery_image($gallery_id)
    {
        $this->db->select("*");
        $this->db->from('gallery_image');
        $this->db->where('gallery_id',$gallery_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_gallery_image_detail($gallery_image_id)
    {
        $this->db->select("*");
        $this->db->from('gallery_image');
        $this->db->where('image_id',$gallery_image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }
    function get_insert_gallery_image($data){
        $this->db->trans_start();
        $data['created_date']=time();
        $this->db->insert('gallery_image',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }

    function get_all_images_modal(){
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_images($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_images_edit(){
       // $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert_image($data){
        $this->db->trans_start();
        $data['created_date']=time();
        $data['user_id']=$this->session->userdata['user_id'];
        $this->db->insert('images',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }
    function get_image_detail($image_id)
    {
        $this->db->select("*");
        $this->db->from('images');
        $this->db->where('image_id',$image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }
    function get_all_titles($data_type=null,$relation_id=null)
    {
        $this->db->select("*");
        $this->db->from('titles');
        $this->db->where('data_type',$data_type);
        $this->db->where('relation_id',$relation_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function count_extensions($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('extensions');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_comment($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('comments');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_page($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('page');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("public",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_gallery($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('gallery');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_gallery_image($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('gallery_image');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_uploaded_image($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('images');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_users($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('users');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function get_all_setting_options(){
        $this->db->select("*");
        $this->db->from('setting_options_per_lang');
        $query = $this->db->get();
        return $query->result_array();
    }
    function check_setting_options($language_id){
        $this->db->select("count(*)");
        $this->db->from('setting_options_per_lang');
        $this->db->where('language_id',$language_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function edit_setting_options($language_id,$data){
        $this->db->where('language_id',$language_id);
        $this->db->update('setting_options_per_lang', $data);
    }
    function insert_setting_options($language_id,$data){
        $data['language_id']= $language_id;
        $this->db->insert('setting_options_per_lang', $data);
    }
    function get_all_statistic(){
        $this->db->select("*");
        $this->db->from('statistic');
        $this->db->order_by('statistic_date','DESC');
        $this->db->limit(14);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_statistic_max_visitors(){
        $this->db->select("max(visitors)");
        $this->db->from('statistic');
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["max(visitors)"])?$result[0]["max(visitors)"]:0;
    }
    function get_statistic_total_visits(){
        $this->db->select("sum(visits)");
        $this->db->from('statistic');
        $query = $this->db->get();
        $result = $query->result_array();
        $return = isset($result[0]["sum(visits)"])?$result[0]["sum(visits)"]:0;
        $this->db->select("sum(count_view)");
        $this->db->from('visitors');
        $query = $this->db->get();
        $result = $query->result_array();
        $return += isset($result[0]["sum(count_view)"])?$result[0]["sum(count_view)"]:0;
        return $return;
    }
    function get_statistic_total_visitors(){
        $this->db->select("sum(visitors)");
        $this->db->from('statistic');
        $query = $this->db->get();
        $result = $query->result_array();
        $return = isset($result[0]["sum(visitors)"])?$result[0]["sum(visitors)"]:0;
        $this->db->select("count(*)");
        $this->db->from('visitors');
        $query = $this->db->get();
        $result = $query->result_array();
        $return += isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
        return $return;
    }

    /* FOOTER MENU CODE */

    function get_all_footermenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('footermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_footermenu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('footermenu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function footermenu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('footermenu');
        }

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if(isset($data["target"]) && count($data["target"])!=0){
            $data["target"]=1;
        } else {
            $data["target"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('footermenu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('footermenu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"footermenu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"footermenu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* SECONDARY FOOTER MENU */

    function get_all_secondary_footermenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('secondary_footermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_secondary_footermenu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('secondary_footermenu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function secondaryfootermenu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        // if ($this->session->userdata('group_id') != 1 && isset($data['default'])) {
        //     unset($data['default']);
        // }
        // if ($this->session->userdata('group_id') != 1 && isset($data['public'])) {
        //     unset($data['public']);
        // }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

          if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('secondary_footermenu');
        }



        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('secondary_footermenu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('secondary_footermenu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"secondary_footermenu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"secondary_footermenu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* HEADER MENU CODE */

    function get_all_headermenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('headermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_all_headermenu_institute($conditions=null)
    {
        $this->db->select('*');
        // $this->db->from('headermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_headermenu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('headermenu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
   
    function headermenu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('headermenu');
        }

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }


        if(isset($data["target"]) && count($data["target"])!=0){
            $data["target"]=1;
        } else {
            $data["target"]=0;
        }


        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('headermenu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('headermenu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"headermenu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"headermenu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    
    function get_view_user($user_id)
    {
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    /****LOCATION***/
    
    function get_all_locations()
    {
        $this->db->select("*");
        $this->db->from('locations');
        $this->db->order_by('location_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    // Unique to models with multiple tables
    function set_table($table) {
        $this->table = $table;
    }

    // Get table from table property
    function get_table() {
        return $this->table;
    }

     // Get where column id is ... return query
    function get_where($col, $val) {
        $table = $this->get_table();
        $this->db->where($col, $val);
        $query = $this->db->get($table);
        return $query->row_array();
    }
        
}