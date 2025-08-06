<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Soil_test_results extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nabard/Soil_test_results_model', 'soil_model');
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

        validate_permissions('Soil_test_results', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->soil_model->get_soil_test_results_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/soil_test_results/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "soil_test_results";
        $this->data['child_menu_type']      = "save_soil_test_results";
        $this->data['sub_child_menu_type']  = "";
        $this->data['data']                 = [];
        $this->data['soil_id']              = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Soil_test_results', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['data'] = $this->input->post();
        }

        $this->form_validation->set_rules('farmer_id', 'Farmer ID', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                if($id)
                {
                  
                    $update['soil_test_results']['FARMER_ID']            = $this->input->post('farmer_id');
                    $update['soil_test_results']['date']                 = $this->input->post('date');
                    $update['soil_test_results']['ph']                   = $this->input->post('ph');
                    $update['soil_test_results']['ec']                   = $this->input->post('ec');
                    $update['soil_test_results']['oc']                   = $this->input->post('oc');
                    $update['soil_test_results']['n']                    = $this->input->post('n');
                    $update['soil_test_results']['p']                    = $this->input->post('p');
                    $update['soil_test_results']['k']                    = $this->input->post('k');
                    $update['soil_test_results']['s']                    = $this->input->post('s');
                    $update['soil_test_results']['ca']                   = $this->input->post('ca');
                    $update['soil_test_results']['mg']                   = $this->input->post('mg');
                    $update['soil_test_results']['zn']                   = $this->input->post('zn');
                    $update['soil_test_results']['fe']                   = $this->input->post('fe');
                    $update['soil_test_results']['mn']                   = $this->input->post('mn');
                    $update['soil_test_results']['cu']                   = $this->input->post('cu');
                    $update['soil_test_results']['bulk_densilty']        = $this->input->post('bulk_densilty');
                    $update['soil_test_results']['sic']                  = $this->input->post('sic');
                    $update['soil_test_results']['soc']                  = $this->input->post('soc');
                    $update['soil_test_results']['toc']                  = $this->input->post('toc');
                    $update['soil_test_results']['status']               = $this->input->post('status');
                    $update['soil_test_results']['modified_on']          = date('Y-m-d H:i:s');
                    $update['soil_test_results']['modified_by']          = $this->session->userdata['user_id'];
                    
                    $response = $this->soil_model->_update('soil_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Soil test results successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['soil_test_results']['FARMER_ID']            = $this->input->post('farmer_id');
                    $insert['soil_test_results']['date']                 = $this->input->post('date');
                    $insert['soil_test_results']['ph']                   = $this->input->post('ph');
                    $insert['soil_test_results']['ec']                   = $this->input->post('ec');
                    $insert['soil_test_results']['oc']                   = $this->input->post('oc');
                    $insert['soil_test_results']['n']                    = $this->input->post('n');
                    $insert['soil_test_results']['p']                    = $this->input->post('p');
                    $insert['soil_test_results']['k']                    = $this->input->post('k');
                    $insert['soil_test_results']['s']                    = $this->input->post('s');
                    $insert['soil_test_results']['ca']                   = $this->input->post('ca');
                    $insert['soil_test_results']['mg']                   = $this->input->post('mg');
                    $insert['soil_test_results']['zn']                   = $this->input->post('zn');
                    $insert['soil_test_results']['fe']                   = $this->input->post('fe');
                    $insert['soil_test_results']['mn']                   = $this->input->post('mn');
                    $insert['soil_test_results']['cu']                   = $this->input->post('cu');
                    $insert['soil_test_results']['bulk_densilty']        = $this->input->post('bulk_densilty');
                    $insert['soil_test_results']['sic']                  = $this->input->post('sic');
                    $insert['soil_test_results']['soc']                  = $this->input->post('soc');
                    $insert['soil_test_results']['toc']                  = $this->input->post('toc');
                    $insert['soil_test_results']['status']               = $this->input->post('status');
                    $insert['soil_test_results']['created_on']           = date('Y-m-d H:i:s');
                    $insert['soil_test_results']['created_by']           = $this->session->userdata['user_id'];

                    $response                 = $this->soil_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Soil test results successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/soil_test_results/');
            }
        }

        if($id!='')
        {
            $soil_test_results         = $this->soil_model->get_soil_test_results_list(['e.soil_id' => $id]);
            $this->data['data']        = isset($soil_test_results[0]) ? $soil_test_results[0] : [];
            
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Soil test results not found']);
                redirect(base_url()."cms/soil_test_results/");
            }
        }

        $this->data['farmers_list']         = $this->farmers_model->get_farmers_list();
        $this->data['content']              = $this->load->view('cms/nabard/soil_test_results/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function delete($id='')
    {
        validate_permissions('Soil_test_results', 'delete', $this->config->item('method_for_delete'));
             
        $soil_test_results = $this->soil_model->get_soil_test_results_list(['e.soil_id' => $id]);

        if(!empty($soil_test_results))
        {
            $response = $this->soil_model->_delete('soil_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Soil test results not found.']);
        }
        redirect(base_url().'cms/soil_test_results/');
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


    function farmer_ajax_list()
    {
            $condition          = '';
            $list               = $this->soil_model->get_farmer_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            // echo "<pre>";print_r($list);exit;

            foreach ($list as $key => $value) {
                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['farmer_name']                             = $value->farmer_name;
                $row['date']                                    = $value->date;
                $row['status']                                  = $value->status;
                //$row['status']                                  = '<i class="fa "'.$value->status==1.'"?fa-check":"fa-minus-circle"></i>';
                
               

                $edit                                           = '<a data-toggle="tooltip" class="btn btn-sm btn-primary m-r-5" href="'.base_url().'cms/soil_test_results/edit/'.$value->soil_id.'" title="Edit"><i class="icon-pencil"></i></a>';
                $delete                                         = '<a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete" onclick="change_status('.$value->soil_id.');"><i class="icon-trash"></i></a>';
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
}