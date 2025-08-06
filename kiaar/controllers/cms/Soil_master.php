<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Soil_master extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nabard/Soil_master_model', 'soil_model');
        $this->load->model('cms/nabard/Farmers_model', 'farmers_model');
        $user_id = $this->session->userdata['user_id'];      
    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "soil_master";
        $this->data['child_menu_type']      = "soil_master";
        $this->data['sub_child_menu_type']  = "";

        validate_permissions('Soil_master', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->soil_model->get_soil_master_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/soil_master/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "soil_master";
        $this->data['child_menu_type']      = "save_soil_master";
        $this->data['sub_child_menu_type']  = "";
        $this->data['data']                 = [];
        $this->data['id']                   = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Soil_master', 'edit', $per_action);

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
                    $data                              = [];
                    $data['FARMER_ID']                 = $this->input->post('farmer_id');
                    $data['plot_no']                   = $this->input->post('plot_no');
                    $data['sample_date']               = $this->input->post('sample_date');
                    $data['test_date']                 = $this->input->post('test_date');
                    $data['report_name']               = $this->input->post('report_name');
                    $data['report_link']               = $this->input->post('report_link');
                    $data['status']                    = $this->input->post('status');
                    $data['modified_on']               = date('Y-m-d H:i:s');
                    $data['modified_by']               = $this->session->userdata('user_id');

                    $response = $this->soil_model->soil_edit($id, $data, $_POST);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Data successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $data                             = [];
                    $data['FARMER_ID']                = $this->input->post('farmer_id');
                    $data['plot_no']                  = $this->input->post('plot_no');
                    $data['sample_date']              = $this->input->post('sample_date');
                    $data['test_date']                = $this->input->post('test_date');
                    $data['report_name']              = $this->input->post('report_name');
                    $data['report_link']              = $this->input->post('report_link');
                    $data['status']                   = $this->input->post('status');
                    $data['created_on']               = date('Y-m-d H:i:s');
                    $data['created_by']               = $this->session->userdata('user_id');
                    $data['modified_on']              = date('Y-m-d H:i:s');
                    $data['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->soil_model->soil_edit($id, $data, $_POST);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Data successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/soil_master/');
            }
        }

        if($id!='')
        {   
            // $this->data['links']        = $this->soil_model->get_all_links($id);
            $soil_master                = $this->soil_model->get_soil_master_list(['e.id' => $id]);
            $this->data['data']         = isset($soil_master[0]) ? $soil_master[0] : [];
            
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data not found']);
                redirect(base_url()."cms/soil_master/");
            }
        }

        $this->data['farmers_list']         = $this->farmers_model->get_farmers_list();
        $farmerId                           = $this->soil_model->get_farmer($id);
        if($id)
        {
            $this->data['plot_list']            = $this->soil_model->get_plot_list($farmerId[0]['FARMER_ID']);
        }
        else
        {
            $this->data['plot_list']            = $this->soil_model->get_plot_list($farmerId='');
        }
        // $this->data['plot_list']            = $this->soil_model->get_plot_list();
        $this->data['content']              = $this->load->view('cms/nabard/soil_master/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function delete($id='')
    {
        validate_permissions('Soil_master', 'delete', $this->config->item('method_for_delete'));
             
        $soil_master = $this->soil_model->get_soil_master_list(['e.id' => $id]);

        if(!empty($soil_master))
        {
            $response = $this->soil_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data not found.']);
        }
        redirect(base_url().'cms/soil_master/');
    }

    function delete_links()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('soil_master_report_links', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function save_links_order()
    {   
        $programme_id = $_POST["programme_id_array"];
        // echo "<pre>";
        // print_r($programme_id);
        // exit();
        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE soil_master_report_links SET link_order = '".$i."' where id = '".$v."'");


            $i++;
        }

        echo 'Notice urls order has been updated';
    }


    public function send_credential_to_user($id='') 
    {   
        // send sms on mobile number
        $details = $this->soil_model->get_farmers_details($id);
        // echo "<pre>";print_r($details);exit;
        $message = "ಹಲೋ, ನಿಮ್ಮ ಮಣ್ಣಿನ ವಿಶ್ಲೇಷಣೆ ವರದಿಯನ್ನು ವೀಕ್ಷಿಸಲು ಕೆಳಗಿನ ಲಿಂಕ್ ಅನ್ನು ಕ್ಲಿಕ್ ಮಾಡಿ. LINK ಹೆಚ್ಚಿನ ಮಾಹಿತಿಗಾಗಿ https://kiaar.org/en ಗೆ ಭೇಟಿ ನೀಡಿ. - ಸೋಮಯ್ಯ ಕಿಯಾರ್";
        // $message = "ಹಲೋ, ನಿಮ್ಮ ಮಣ್ಣಿನ ವಿಶ್ಲೇಷಣೆ ವರದಿಯನ್ನು ವೀಕ್ಷಿಸಲು ಕೆಳಗಿನ ಲಿಂಕ್ ಅನ್ನು ಕ್ಲಿಕ್ ಮಾಡಿ. <a href=".$details[0]['report_link'].">".$details[0]['report_name']."</a> ಹೆಚ್ಚಿನ ಮಾಹಿತಿಗಾಗಿ https://kiaar.org/en ಗೆ ಭೇಟಿ ನೀಡಿ. - ಸೋಮಯ್ಯ ಕಿಯಾರ್";
        $this->send_sms($details[0]['MOBILE_NO'], $message);
        $this->session->set_flashdata('success', 'true');
        redirect(base_url().'cms/soil_master/');    
    }

    public function send_sms($phone, $body) 
    {
        //Account details
        $apiKey = urlencode('OGEyZDAyMDdlZTlmYzQyZmU0NmU0MDAwMmZhM2NhOGU=');
        
        // Message details
        // $numbers = urlencode($phone);
        $number = array($phone);
        $sender = urlencode('SOMAIY');
        $message    = rawurlencode($body);
        $numbers = implode(',', $number); 
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        // echo "<pre>";print_r($data);exit;
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        echo "<pre>";print_r($response);exit;
        curl_close($ch);
        
        // //Process your response here
        // echo $response;

    }

}