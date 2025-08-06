<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Soil_testing_recommendation extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nabard/Soil_testing_recommendation_model', 'soil_model');
        $this->load->model('cms/nabard/Farmers_model', 'farmers_model');
        $user_id = $this->session->userdata['user_id'];      
    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "soil_test_results";
        $this->data['child_menu_type']      = "soil_test_results";
        $this->data['sub_child_menu_type']  = "";

        validate_permissions('Soil_testing_recommendation', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->soil_model->get_soil_test_results_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/soil_testing_recommendation/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "soil_test_results";
        $this->data['child_menu_type']      = "save_soil_test_results";
        $this->data['sub_child_menu_type']  = "";
        $this->data['data']                 = [];
        $this->data['test_tran_ID']         = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Soil_testing_recommendation', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['data'] = $this->input->post();
            // echo "<pre>";print_r($this->data['data']);exit;
        }

        $this->form_validation->set_rules('farmer_id', 'Farmer ID', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $response = $this->soil_model->manage_soil_recommendation($this->input->post(), $id);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Soil testing recommendation successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/soil_testing_recommendation/');
            }
        }

        if($id!='')
        {
            $soil_test_results         = $this->soil_model->get_soil_test_results_list(['e.test_tran_ID' => $id]);
            $this->data['data']        = isset($soil_test_results[0]) ? $soil_test_results[0] : [];
            
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Soil test results not found']);
                redirect(base_url()."cms/soil_testing_recommendation/");
            }
        }

        $this->data['test_names']           = $this->soil_model->get_soil_test_name_list();
        $test_count                         = $this->data['test_names'][0]['test_count'];
        $test_name                          = $this->data['test_names'][0]['test_name'];
        $test_id                            = $this->data['test_names'][0]['testID'];
        if($test_count == 1)
        {
            $this->data['test_results']         = $this->soil_model->get_soil_test_results($test_id);
        }
        else
        {
            $this->data['test_results']         = $this->soil_model->get_soil_test_results();
        }
        $this->data['farmers_list']         = $this->farmers_model->get_farmers_list();
        $this->data['test_list']            = $this->soil_model->get_test_list();
        $this->data['content']              = $this->load->view('cms/nabard/soil_testing_recommendation/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function delete($id='')
    {
        validate_permissions('Soil_testing_recommendation', 'delete', $this->config->item('method_for_delete'));
             
        $soil_test_results = $this->soil_model->get_soil_test_results_list(['e.test_tran_ID' => $id]);

        if(!empty($soil_test_results))
        {
            $response = $this->soil_model->_delete('test_tran_ID', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Soil test results not found.']);
        }
        redirect(base_url().'cms/soil_testing_recommendation/');
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


    function ajax_list()
    {
            $condition          = '';
            $list               = $this->soil_model->get_farmer_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['farmer_name']                             = $value->farmer_name;
                $row['test_date']                               = $value->test_date;
                $row['sample_date']                             = $value->sample_date;
                

                $edit                                           = '<a data-toggle="tooltip" class="btn btn-sm btn-primary m-r-5" href="'.base_url().'cms/soil_testing_recommendation/edit/'.$value->test_tran_ID.'" title="Edit"><i class="icon-pencil"></i></a>';
                $delete                                         = '<a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete" onclick="change_status('.$value->test_tran_ID.');"><i class="icon-trash"></i></a>';
                $row['action']                                  = '<div class="wd-130-px m-0-auto">'.$edit.$delete.'</div>';
                
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->soil_model->get_farmer_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );
            // echo "<pre>"; print_r($output);exit();
            echo json_encode($output);
        
    }


    function get_menu_table()
    {
        // if($this->input->post('test_id'))
        // {
            $pr_id                              = $this->input->post('pr_id');
            $test_id                            = $this->input->post('test_id');

            if($pr_id!='')
            {
                $this->data['links']             = $this->soil_model->edit_page_permission($pr_id);
                // echo "<pre>";print_r($this->data['links']);exit;
            }
            else
            {
                $this->data['otherpage'] = $this->soil_model->get_other_page($test_id);
                // echo "<pre>";print_r($this->data['otherpage']);exit;
            }
            $html                    = $this->load->view('cms/nabard/soil_testing_recommendation/links', $this->data, true);
            echo $html;exit;
        //}
    }

}