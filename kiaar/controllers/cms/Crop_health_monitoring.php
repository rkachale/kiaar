<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crop_health_monitoring extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nabard/Crop_health_monitoring_model', 'crop_model');
        $this->load->model('cms/nabard/Farmers_model', 'farmers_model');
        $user_id = $this->session->userdata['user_id'];      
    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "crop_health_monitoring";
        $this->data['child_menu_type']      = "crop_health_monitoring";
        $this->data['sub_child_menu_type']  = "";

        validate_permissions('Crop_health_monitoring', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->crop_model->get_crop_health_monitoring_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/crop_health_monitoring/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "crop_health_monitoring";
        $this->data['child_menu_type']      = "crop_health_monitoring";
        $this->data['sub_child_menu_type']  = "";
        $this->data['data']                 = [];
        $this->data['crop_id']              = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Crop_health_monitoring', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['data'] = $this->input->post();
        }

        $this->form_validation->set_rules('farmer_id', 'Farmer ID', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $all_existing_image_array = array();

                if(isset($_POST['existing_image_id']))
                {
                    $gal_image_id = $_POST['existing_image_id'];
                    $gal_image_name = $_POST['existing_image_name'];
                    $gal_image_description = $_POST['existing_image_description'];

                    
                    foreach ( $gal_image_id as $idx => $val ) {
                        //$all_existing_image_array[] = [ $val, $gal_image_name[$idx], $gal_image_description[$idx] ];
                        $all_existing_image_array[] = [
                                            'image_id' => $val,
                                            'image_name' => $gal_image_name[$idx],
                                            'image_description' => $gal_image_description[$idx],
                                        ];
                    }
                }
                
                $images = [];
                $imagedata = [];
                if(isset($_POST['images']))
                {   
                    $folderName = $_POST['farmer_id']."_".$_POST['year_month'];
                    $pathToUpload = './upload_file/crop_health_upload/' . $folderName;
                    if ( ! file_exists($pathToUpload) )
                    {
                        $create = mkdir($pathToUpload);
                        chmod("$pathToUpload", 0777);
                    }
                    $this->load->library('customlib');
                    foreach ($_POST['images'] as $key => $value) 
                    {
                        $image = $this->customlib->base64_image_upload($value, $pathToUpload);
                        $images['image'] = $image;
                        $images['name'] = $_POST['image_name'][$key];
                        $images['description'] = $_POST['image_description'][$key];
                        $imagedata[] = $images;
                    }
                }

                if($id)
                {   
                    $crop_health_monitoring                         = [];
                    $crop_health_monitoring['FARMER_ID']            = $this->input->post('farmer_id');
                    $crop_health_monitoring['year_month']           = $this->input->post('year_month');
                    $crop_health_monitoring['status']               = $this->input->post('status');
                    $crop_health_monitoring['modified_on']          = date('Y-m-d H:i:s');
                    $crop_health_monitoring['modified_by']          = $this->session->userdata['user_id'];
                    
                    // $response = $this->crop_model->_update('crop_id', $id, $update);
                    $response = $this->crop_model->update_upload_image($id,$crop_health_monitoring,$imagedata,$all_existing_image_array);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Crop health monitoring successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $crop_health_monitoring                         = [];
                    $crop_health_monitoring['FARMER_ID']            = $this->input->post('farmer_id');
                    $crop_health_monitoring['year_month']           = $this->input->post('year_month');
                    $crop_health_monitoring['status']               = $this->input->post('status');
                    $crop_health_monitoring['created_on']           = date('Y-m-d H:i:s');
                    $crop_health_monitoring['created_by']           = $this->session->userdata['user_id'];

                    // $response                 = $this->crop_model->_insert($insert);
                    $response =  $this->crop_model->upload_image($crop_health_monitoring,$imagedata);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Crop health monitoring successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/crop_health_monitoring/');
            }
        }

        if($id!='')
        {   $this->data['gallery_data_image']   = $this->crop_model->get_data_image($id);
            $crop_health_monitoring         = $this->crop_model->get_crop_health_monitoring_list(['e.crop_id' => $id]);
            $this->data['data']        = isset($crop_health_monitoring[0]) ? $crop_health_monitoring[0] : [];
            
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Crop health monitoring not found']);
                redirect(base_url()."cms/crop_health_monitoring/");
            }
        }

        $this->data['farmers_list']         = $this->farmers_model->get_farmers_list();
        $this->data['content']              = $this->load->view('cms/nabard/crop_health_monitoring/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function delete($id='')
    {    
        validate_permissions('Crop_health_monitoring', 'delete', $this->config->item('method_for_delete'));
             
        // $crop_health_monitoring = $this->crop_model->get_crop_health_monitoring_list(['e.crop_id' => $id]);

        // if(!empty($crop_health_monitoring))
        // {
        //     $response = $this->crop_model->_delete('crop_id', $id);
        //     $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        // }
        // else
        // {
        //     $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Crop health monitoring not found.']);
        // }

        $this->db->delete('nabard_crop_health_monitoring_images', array('crop_id' => $id));
        $this->db->delete('nabard_crop_health_monitoring', array('crop_id' => $id));
        $response= $this->db->trans_complete();
        if(isset($response) && $response == '1')
        {
            $msg = ['error' => 0, 'message' => 'Crop health monitoring data successfully deleted'];
        }
        else
        {
            $msg = ['error' => 0, 'message' => $response['message']];
        }
                
        $this->session->set_flashdata('requeststatus', $msg);
        
        redirect(base_url().'cms/crop_health_monitoring/');
    }

    function deleteimage()
    {
        $deleteid  = $this->input->post('image_id');
        $this->db->delete('nabard_crop_health_monitoring_images', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function ajax_check()
    {   
        if($this->input->post())
        {
            $result = $this->unique_graph();
            echo $result;exit;
        }
    }

    function unique_graph()
    {   
        $id                         = isset($_POST['id']) ? $_POST['id'] : '';
        $farmer_id                  = isset($_POST['farmer_id']) ? $_POST['farmer_id'] : '';
        $year_month                 = isset($_POST['year_month']) ? $_POST['year_month'] : '';

        $errormessage               = 'Farmer data for this Year and Month is already exist.';
        $this->form_validation->set_message('unique_graph', $errormessage);

        if(!empty($id))
        {
            $content = $this->common_model->custom_query('Select * FROM nabard_crop_health_monitoring WHERE FARMER_ID = "'.$farmer_id.'" AND `year_month` like "'.$year_month.'" AND crop_id != "'.$id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM nabard_crop_health_monitoring WHERE FARMER_ID = "'.$farmer_id.'" AND `year_month` like "'.$year_month.'"');
        }
        // echo "<pre>"; print_r($content);exit();
        if(isset($content) && !empty($content))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    function get_farmername_options_url()
    {
        $options        = '<option value="">-- Select Farmer --</option>';
        $group_list     = $this->farmers_model->get_farmers_list();

            if(!empty($group_list))
            {
                foreach ($group_list as $key => $value) {
                    $selected           = '';
                    // if($value['group_id'] == $group_id)
                    // {
                    //     $selected       = 'selected="selected"';
                    // }
                    $name = ucwords(strtolower($value['FIRST_NAME']))." ".ucwords(strtolower($value['MIDDLE_NAME']))." ".ucwords(strtolower($value['LAST_NAME']));
                    $options            .= '<option value="'.$value['FARMER_ID'].'" '.$selected.'>'.$name.'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function get_year_options_url()
    {
        $options        = '<option value="">-- Select Year --</option>';
        $group_list     = $this->crop_model->get_year();

            if(!empty($group_list))
            {
                foreach ($group_list as $key => $value) {
                    $selected           = '';
                    // if($value['group_id'] == $group_id)
                    // {
                    //     $selected       = 'selected="selected"';
                    // }
                    $options            .= '<option value="'.$value['year'].'" '.$selected.'>'.$value['year'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }


    function get_month_options_url()
    {
        $options        = '<option value="">-- Select Month --</option>';
        $group_list     = $this->crop_model->get_month();

            if(!empty($group_list))
            {
                foreach ($group_list as $key => $value) {
                    $selected           = '';
                    // if($value['group_id'] == $group_id)
                    // {
                    //     $selected       = 'selected="selected"';
                    // }
                    $options            .= '<option value="'.$value['month'].'" '.$selected.'>'.$value['month'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }


    function farmer_ajax_list()
    {
            $condition          = '';
            $list               = $this->crop_model->get_farmer_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            // echo "<pre>";print_r($list);exit;

            foreach ($list as $key => $value) {
                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['farmer_name']                             = $value->farmer_name;
                $row['year_month']                              = $value->year_month;
                $row['status']                                  = $value->status;
                //$row['status']                                  = '<i class="fa "'.$value->status==1.'"?fa-check":"fa-minus-circle"></i>';
                
               

                $edit                                           = '<a data-toggle="tooltip" class="btn btn-sm btn-primary m-r-5" href="'.base_url().'cms/crop_health_monitoring/edit/'.$value->crop_id.'" title="Edit"><i class="icon-pencil"></i></a>';
                $delete                                         = '<a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete" onclick="change_status('.$value->crop_id.');"><i class="icon-trash"></i></a>';
                $row['action']                                  = '<div class="wd-130-px m-0-auto">'.$edit.$delete.'</div>';
                
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->crop_model->get_farmer_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );
            // echo "<pre>"; print_r($output);exit();
            echo json_encode($output);
        
    }
}