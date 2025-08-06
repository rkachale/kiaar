<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends Kiaar_Controller
{
     function __construct()
    {
    

          parent::__construct('backend');
          $this->load->model('cms/category/Category_load_model', 'Category_load_model');
        $user_id = $this->session->userdata['user_id'];
     
    }

 function index()
    {

        
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "category";
        $this->data['child_menu_type']      = "category";
        $this->data['sub_child_menu_type']  = "category";
       
       
        $status   =-1;
        validate_permissions('Category', 'index', $this->config->item('method_for_view'));
        $this->data['data_list']    = $this->Category_load_model->get_category($status);
        $this->data['title']        = 'Category';
        $this->data['page']         = 'Category';
        $this->data['content']      = $this->load->view('cms/category/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }


   function edit($id='')
    {

        $this->data['main_menu_type']      = "masters";
        $this->data['sub_menu_type']       = "category";
        $this->data['child_menu_type']     = "category";
        $this->data['sub_child_menu_type'] = "category";
       
        $save_data                 = [];
       
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Category', 'edit', $per_action);
        $status      =-1;
        $this->data['title']                = 'category';
        $this->data['page']                 = 'category';
        $this->data['data']                 = [];
        $this->data['category_id']      = $id;
        $this->data['data']['public']       = 1;
      
        if($id)
        {
            $this->data['data']= $this->Category_load_model->get_category_details($id,$status);
            if(empty($this->data['data']))
            {
          $this->session->set_flashdata('requeststatus',['error'=>1,'message'=>' Category not found']);
          redirect(base_url().'cms/category');
            } 
        }  
        if($this->input->post())
        {
            $this->data['data']= $this->input->post();
        }
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                if($id)
                {
                     $update['category']['category_name']    = $this->input->post('name');
                     $update['category']['public']           = $this->input->post('status');
                     $update['category']['modified_on']      = date('Y-m-d H:i:s');
                     $update['category']['modified_by']      = $this->session->userdata['user_id'];
                     $condition                                          = array('category_id' => $id  );
                    $response = $this->Category_load_model->_update($condition, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => ' Category  successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['category']['category_name']      = $this->input->post('name');
                    $insert['category']['public']             = $this->input->post('status');
                    $insert['category']['created_on']         = date('Y-m-d H:i:s');
                    $insert['category']['created_by']         = $this->session->userdata['user_id'];
                    $insert['category']['modified_on']        = date('Y-m-d H:i:s');
                    $insert['category']['modified_by']        = $this->session->userdata['user_id'];
                    $response   = $this->Category_load_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => ' Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/category');
            }//end post
          //  end validations
        }
     
         $this->data['content'] = $this->load->view('cms/category/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data); 
    }

//delete start here

    function delete($id='')
    {
        
        validate_permissions('Category','delete',$this->config->item('method_for_delete'));
        $status     =-1;
        $condition  = array('category_id' => $id  );
        $post=$this->Category_load_model->get_category_details($id, $status);

        if(!empty($post))
        {
        $response = $this->Category_load_model->_delete($condition);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => ' Category not found.']);
        }
            redirect(base_url().'cms/category');
    }
}


?>