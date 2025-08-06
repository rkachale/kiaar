<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends Kiaar_Controller
{
  //  private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');

        $this->load->model('cms/page/Page_model', 'page_model');
        $this->load->model('cms/Kiaar_general_admin_model', 'Kiaar_general_admin_model');
        $this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        
       
    }

 function index()
    {
exit();
    	
    }


function page($id=null)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";
        validate_permissions('Page', 'page', $this->config->item('method_for_view'));
        $public    =-1;
        $this->load->library('spyc');
        $this->data['page_type']            = spyc_load_file(getcwd()."/page_type.yml") ;
        $this->data['data_list']            = $this->page_model->get_all_page_institute($public);
        $this->data['title']                = 'page';
        $this->data['page']                 = 'page';
        $this->data['content']              =$this->load->view('cms/page/index',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }
    

    function edit($id='',$contents_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "save_page";
        $this->data['sub_child_menu_type'] = "";

    
    
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_page_permissions($id, $per_action);

        $this->load->library('spyc');
     
           $this->data['page_type'] = spyc_load_file(getcwd()."/page_type.yml") ; 
       

        $titles = array();
        $data_titles = $this->Kiaar_general_admin_model->get_all_titles("page",$id);
        if(count($data_titles)!=0){
            foreach ($data_titles as $value) {
                $titles[$value["language_id"]] = $value;
            }
        }
        $this->data['titles']               = $titles;
        $this->data['languages']            = $this->Kiaar_general_admin_model->get_all_language();
        $this->data['gallery']              = $this->Kiaar_general_admin_model->get_all_galleryids();
        $this->data['title']                = 'Page';
        $this->data['page']                 = 'Page';
        $this->data['data']                 = [];
        $this->data['page_id']              = $id;
        $this->data['data']['public']       = 1;

        if($id)
        {
            $this->data['data']    = $this->page_model->get_page($id);

            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page not found']);
                  redirect(base_url().'cms/page/page/');
            }else{
           

            }
        }

        if($this->input->post())
        {
            $this->data['data']     = $this->input->post();
        }

        $this->form_validation->set_rules('page_name', 'Page Name', 'required|max_length[250]');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   //when click on submit button


            	 if($id)
                {
                    $update['page']['page_name']                         = $this->input->post('page_name');
                    $update['page']['slug']                   = $this->input->post('slug');
                    $update['page']['page_type']                     = $this->input->post('page_type');
                    $update['page']['gallery_id']         = $this->input->post('gallery_id');
                    $update['page']['video_url']                          = $this->input->post('video_url');
                    $update['page']['public']                        = $this->input->post('public');
                     $update['extensions']['extension_id']           = $this->input->post('extension_id');
                    $update['extensions']['name']           = $this->input->post('page_name');
                    $update['extensions']['meta_title']                 = $this->input->post('meta_title');
                    $update['extensions']['description']           = $this->input->post('description');
                    $update['extensions']['language_id']           = $this->input->post('language_id');
                    $update['extensions']['public']                = $this->input->post('public');
                    $update['extensions']['meta_description']               = $this->input->post('meta_description');
                    $update['extensions']['meta_keywords']          = $this->input->post('meta_keywords');
                    $update['extensions']['meta_image']          = $this->input->post('meta_image');
                    $update['extensions']['image']          = $this->input->post('image');
                    $update['extensions']['data_type']          = $this->input->post('data_type');

                    $response = $this->page_model->_update('page_id', $id, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                    $msg = ['error' => 0, 'message' => 'Page successfully updated'];
                    }
                    else
                    { $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['page']['page_name']          = $this->input->post('page_name');
                    $insert['page']['slug']               = $this->input->post('slug');
                    $insert['page']['page_type']          = $this->input->post('page_type');
                    $insert['page']['gallery_id']         = $this->input->post('gallery_id');
                    $insert['page']['public']             = $this->input->post('public');
                    $insert['page']['video_url']          = $this->input->post('video_url');
                    $insert['page']['created_date']       = date('Y-m-d H:i:s');
                    $insert['extensions']['name']                 = $this->input->post('page_name');
                    $insert['extensions']['description']           = $this->input->post('description');
                    $insert['extensions']['language_id']           = $this->input->post('language_id');
                    $insert['extensions']['public']                = $this->input->post('public');
                    $insert['extensions']['meta_title']               = $this->input->post('meta_title');
                    $insert['extensions']['meta_description']             = $this->input->post('meta_description');
                    $insert['extensions']['meta_keywords']                = $this->input->post('meta_keywords');
                    $insert['extensions']['meta_image']               = $this->input->post('meta_image');
                    $insert['extensions']['image']             = $this->input->post('image');
                    $insert['extensions']['data_type']                = $this->input->post('data_type');            
                    $insert['extensions']['created_date']          = date('Y-m-d H:i:s');
                    $insert['extensions']['updated_date']          = date('Y-m-d H:i:s');
                    $insert['extensions']['user_id']               = $this->session->userdata['user_id'];
                    $response= $this->page_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Page successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
               $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/page/page/');



            
            }
        }

        //only edit
        $this->data['content']  =$this->load->view('/cms/page/form',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }



// delete start here

    function delete($id=null)
    {

         validate_permissions('Page', 'delete', $this->config->item('method_for_delete'));
        $public    =-1;
        $condition                                 = array('page_id' => $id  );

        $post      = $this->page_model->get_page($id, $public);

        if(!empty($post))
        {
        $response = $this->page_model->_delete($condition);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page  not found.']);
        }
            redirect(base_url().'cms/page/page/'  );
    }


//end delete function
}


?>