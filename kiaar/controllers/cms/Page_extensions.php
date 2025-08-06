<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page_extensions extends Kiaar_Controller
{
   // private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');

        $this->load->model('cms/page/Page_extensions_model', 'page_extensions_model');
        $this->load->model('cms/Kiaar_general_admin_model', 'Kiaar_general_admin_model');
        $this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
       
       
    }

 function index()
    {
exit();
        
    }


function extensions($id=null)
    {
       
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $pagedata = $this->get_pages($id);
        if(!empty($pagedata))
        {   
         //   $this->data['institutes_details']   = $this->Kiaar_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            $this->data['data_list']            = $this->get_page_content($id);
            $this->data['title']                = _l("page content", $this);
            $this->data['page']                 = "extensions";
            $this->data['relation_id']          = $id;
            $this->data['content']              =$this->load->view('cms/page/index_extensions',$this->data,true);
            //$this->load->view($this->mainTemplate.'/extensions',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Page content found']);
           // redirect(base_url().'admin/page/');
           redirect(base_url().'cms/page_extensions/extensions/');
        }
    }
    

    function get_page_content($page_id='', $contents_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT plc.*, l.language_name FROM extensions plc join languages l ON l.language_id = plc.language_id WHERE plc.relation_id = "'.$page_id.'" AND plc.public!=-1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND plc.'.$key.' = "'.$value.'"';
        }
        if($contents_id)
        {
            $sql .= '  AND plc.extension_id = "'.$contents_id.'"';//AND plc.public != '-1'
            
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY plc.extension_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;

    }

    function get_pages($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT pl.* FROM page pl WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND pl.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND pl.page_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY pl.page_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }



  function edit($page_id='', $contents_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $pagedata = $this->get_pages($page_id);
        if(!empty($pagedata))
        {
            $this->data['title']                    = _l("extensions", $this);
            $this->data['page']                     = "extensions";
            $this->data['data']                     = [];
            $this->data['extension_id']             = $contents_id;
            $this->data['relation_id']              = $page_id;
            $this->data['data']['public']           = 1;
            $this->data['languages']                = $this->Kiaar_general_admin_model->get_all_language();


            if($contents_id)
            {
                $pagedata = $this->get_page_content($page_id, $contents_id);
                $this->data['data'] = isset($pagedata[0]) ? $pagedata[0] : [];
                if(empty($this->data['data']))
                { 
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page content not found']);
                    redirect(base_url().'cms/page_extensions/extensions/'.$page_id);
                }
            }

            if($this->input->post())
            {
                $this->data['data'] = $this->input->post();
            }

            $this->form_validation->set_rules('name', 'Content Name', 'required|max_length[250]');
            $this->form_validation->set_rules('public', 'Public', '');

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('extensions');
                    if($contents_id)
                    {
                        $update['name']             = $this->input->post('name');
                        $update['language_id']      = $this->input->post('language_id');
                        $update['description']      = $this->input->post('description');
                        $update['meta_title']       = $this->input->post('meta_title');
                        $update['meta_description'] = $this->input->post('meta_description');
                        $update['meta_keywords']    = $this->input->post('meta_keywords');
                        $update['meta_image']       = $this->input->post('meta_image');
                        $update['public']           = $this->input->post('public');
                        $update['updated_date']     = date('Y-m-d H:i:s');
                        $update['user_id']          = $this->session->userdata['user_id'];

                        $response = $this->page_extensions_model->save($page_id, $contents_id, $update);
                         if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Page content successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['name']             = $this->input->post('name');
                        $insert['description']      = $this->input->post('description');
                        $insert['relation_id']      = $page_id;
                        $insert['language_id']      = $this->input->post('language_id');
                        $insert['public']           = $this->input->post('public');
                        $insert['meta_title']       = $this->input->post('meta_title');
                        $insert['meta_description'] = $this->input->post('meta_description');
                        $insert['meta_keywords']    = $this->input->post('meta_keywords');
                        $insert['meta_image']       = $this->input->post('meta_image');
                        $insert['data_type']        = $this->input->post('data_type');
                        $insert['created_date']     = date('Y-m-d H:i:s');
                        $insert['updated_date']     = date('Y-m-d H:i:s');
                        $insert['user_id']          = $this->session->userdata['user_id'];

                        $response = $this->page_extensions_model->save($page_id, $contents_id, $insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Page content successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    $this->session->set_flashdata('requeststatus', $msg);
                    redirect(base_url().'cms/page_extensions/extensions/'.$page_id);
                }
            }
            $this->data['content']  = $this->load->view('/cms/page/form_extensions',$this->data,true);//  $this->load->view($this->mainTemplate.'/extension_edit',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Page found']);
            redirect(base_url().'admin/page/');
        }
    }

// delete start here

 function delete($page_id='', $contents_id='', $language_id='')
    {   
        if($language_id != 1)
        {
            $this->common_model->set_table('extensions');
            $response = $this->page_extensions_model->_delete($page_id, $contents_id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            redirect(base_url().'cms/page_extensions/extensions/'.$page_id);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'You can not delete default page content']);
            redirect(base_url().'cms/page_extensions/extensions/'.$page_id);
        }
    }
//end delete function
}


?>