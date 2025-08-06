<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post extends Kiaar_Controller
{


    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/post/Post_model', 'post_model');
        $this->load->model('cms/Kiaar_general_admin_model', 'Kiaar_general_admin_model');
        $this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
    

    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "post";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

    

        validate_permissions('Post', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->post_model->get_post_list();
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/post/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "post";
        $this->data['child_menu_type']      = "save_post";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['post_id']              = $id;

       // $this->data['category']             = $this->category_model->get_all_category();
        $this->data['languages']            = $this->Kiaar_general_admin_model->get_all_language();
       // $this->data['location']             = $this->Kiaar_general_admin_model->get_all_locations();
        // echo "<pre>";
        // print_r($this->data['category']);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Post', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('post_name', 'Post Name', 'required');      
        $this->form_validation->set_rules('publish_date', 'Publish Date', 'required');
        //$this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                $path  = './upload_file/post_upload/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);
                //$files      = $this->file_upload();

                $image  = isset($filesnew['image']) ? $filesnew['image'] : 'default.png';

                $meta_img_path  = './upload_file/post_upload/';
                $metafilesnew   = $this->base64_to_image($this->input->post('meta_image'), $meta_img_path);
                //$files      = $this->file_upload();

                $meta_image  = isset($metafilesnew['image']) ? $metafilesnew['image'] : 'default.png';

                //echo "meta image : ".$meta_image;exit();
                                                
                if($id)
                {
                   
                   // $update['post']['location_id']          = $this->input->post('location');
                  //  $update['post']['category_id']          = $this->input->post('category_id');
                    $update['post']['post_name']            = $this->input->post('post_name');
                   // $update['post']['person_name']          = $this->input->post('person_name');
                   // $update['post']['designation']          = $this->input->post('designation');
                  //  $update['post']['paper']                = $this->input->post('paper');
                    $update['post']['publish_date']         = $this->input->post('publish_date');

                    $update['post']['meta_title']           = $this->input->post('meta_title');
                    $update['post']['meta_description']     = $this->input->post('meta_description');
                    $update['post']['meta_keywords']        = $this->input->post('meta_keywords');
                    
                   // $update['post']['whats_new']            = $this->input->post('whats_new');
                   // $update['post']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                  //  $update['post']['html_slider']          = $this->input->post('html_slider');
                    $update['post']['public']               = $this->input->post('public');
                    $update['post']['modified_on']          = date('Y-m-d H:i:s');
                    $update['post']['modified_by']          = $this->session->userdata['user_id'];


                    if(!empty($image))
                    {
                        $update['post']['image']            = $image;
                    }
                    if(!empty($meta_image))
                    {
                        $update['post']['meta_image']       = $meta_image;
                    }
                    

                    $update['contents']['contents_id']      = $this->input->post('contents_id');
                    $update['contents']['language_id']      = $this->input->post('language_id');
                    $update['contents']['public']           = 1; // 1 = active
                    $update['contents']['name']             = $this->input->post('post_name');
                    $update['contents']['description']      = $this->input->post('description');
                    
                    $update['contents']['modified_on']      = date('Y-m-d H:i:s');
                    $update['contents']['modified_by']      = $this->session->userdata['user_id'];

                    //$update['slug']                       = $slug;
                    
                    // echo"<pre>";
                    // print_r($update);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response = $this->post_model->_update('post_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Post successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                   
                   // $insert['post']['location_id']          = $this->input->post('location');
                    //$insert['post']['category_id']          = $this->input->post('category_id');
                    $insert['post']['post_name']            = $this->input->post('post_name');
                  //  $insert['post']['person_name']          = $this->input->post('person_name');
                   // $insert['post']['designation']          = $this->input->post('designation');
                   // $insert['post']['paper']                = $this->input->post('paper');
                    $insert['post']['publish_date']         = $this->input->post('publish_date');

                    $insert['post']['meta_title']           = $this->input->post('meta_title');
                    $insert['post']['meta_description']     = $this->input->post('meta_description');
                    $insert['post']['meta_keywords']        = $this->input->post('meta_keywords');
                    
                   // $insert['post']['whats_new']            = $this->input->post('whats_new');
                   // $insert['post']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                  //  $insert['post']['html_slider']          = $this->input->post('html_slider');
                    $insert['post']['public']               = $this->input->post('public');
                    $insert['post']['created_on']           = date('Y-m-d H:i:s');
                    $insert['post']['created_by']           = $this->session->userdata['user_id'];
                    $insert['post']['image']                = $image;                
                    $insert['post']['meta_image']           = $meta_image;
                    
                    

                    $insert['contents']['contents_id']      = $this->input->post('contents_id');
                    $insert['contents']['language_id']      = $this->input->post('language_id');
                    $insert['contents']['public']           = 1; // 1 = active
                    $insert['contents']['name']             = $this->input->post('post_name');
                    $insert['contents']['description']      = $this->input->post('description');
                    
                    $insert['contents']['created_on']      = date('Y-m-d H:i:s');
                    $insert['contents']['created_by']      = $this->session->userdata['user_id'];

                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                       = $this->post_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Post successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/post/');
            }
        }

        if($id!='')
        {
            $post                           = $this->post_model->get_post_list(['p.post_id' => $id, 'p.public !=' => '-1']);
           // $this->data['post_images']      = $this->post_model->get_table_data('contents', ['relation_id' => $id]);
            $this->data['post_data']        = isset($post[0]) ? $post[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'post not found']);
                redirect(base_url()."cms/post/");
            }
        }

        $this->data['content']              = $this->load->view('cms/post/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/post_upload/';
        
        if(!empty($image_data))
        {   
            $image_parts    = explode(";base64,", $image_data);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $image_name     = uniqid().'.'.$image_type;
            $file           = $path.'/'.$image_name;
            file_put_contents($file, $image_base64);
        }
        return ['image' => $image_name];
    }

    function deleteimage()
    {
        // echo "hello";
        // exit();
        $deleteid  = $this->input->post('post_id');
        $update['image']                   = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->post_model->delete_image($deleteid, $update);
        echo true;

    }

    function deletemetaimage()
    {
        // echo "hello";
        // exit();
        $deleteid  = $this->input->post('post_id');
        $update['meta_image']              = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->post_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
       
            
        validate_permissions('Post', 'delete', $this->config->item('method_for_delete'));
             
        $post = $this->post_model->get_post_list(['p.post_id' => $id, 'p.public !=' => '-1']);

        if(!empty($post))
        {
            $response = $this->post_model->_delete('post_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/post/');
    }

    function save_post_order()
    {   
        $post_id = $_POST["post_id_array"];

         for($i=0; $i<count($post_id); $i++)
        { 
            $query=$this->db->query("UPDATE post_new SET post_order = '".$i."' where post_id = '".$post_id[$i]."'");
        }
        echo 'Post Order has been updated';exit();
    }
}