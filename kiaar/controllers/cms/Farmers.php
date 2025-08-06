<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Farmers extends Kiaar_Controller
{
    

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nabard/Farmers_model', 'farmers_model');
        $this->load->model('cms/Kiaar_general_admin_model', 'Kiaar_general_admin_model');
        $user_id = $this->session->userdata['user_id'];      
    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "farmers";
        $this->data['child_menu_type']      = "farmers";
        $this->data['sub_child_menu_type']  = "";

        validate_permissions('Farmers', 'index', $this->config->item('method_for_view'));
        
        $this->data['data_list']            = $this->farmers_model->get_farmers_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/farmers/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function add_farmer()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "farmers";
        $this->data['child_menu_type']      = "farmers";
        $this->data['sub_child_menu_type']  = "";
        validate_permissions('Farmers', 'add_farmer', $this->config->item('method_for_view'));
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nabard/farmers/add_farmer',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function add_farmer_api()
    {   
        $farmer_id                          = $this->input->post('farmer_id');
        // $api_link = "http://hewfapp.mobi/KIAAR/v1/FarmerDetails/".$farmer_id;
        $api_link = "http://35.154.191.66/KIAAR/v1/FarmerDetails/".$farmer_id;

        $post_data = array();

        $ch = curl_init($api_link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        $oracle_response = curl_exec($ch);
        $fetch_oracle_response = json_decode($oracle_response,true);
        $status = $fetch_oracle_response['Status'];
        $firstname = ucwords(strtolower($fetch_oracle_response[0]['FIRST_NAME']));
        $middlename = ucwords(strtolower($fetch_oracle_response[0]['MIDDLE_NAME']));
        $lastname = ucwords(strtolower($fetch_oracle_response[0]['LAST_NAME']));
        $query          = $this->db->query("SELECT FARMER_ID FROM nabard_farmers_master WHERE FARMER_ID=".$farmer_id."");
        $row            = $query->row()->FARMER_ID;

        $this->load->library('S3'); //load S3 library
        $message='';
        $name = $fetch_oracle_response[0]['IMAGE_FILE_NAME'];
 
        if(strlen($name) > 0)
        {
            include('/var/www/html/kiaar/kiaar/config/config_s3.php');
            //Rename image name.
            // $url = 'http://182.74.145.93/gblagri/public/Images/'.$fetch_oracle_response[0]['IMAGE_FILE_NAME'];
            $url = 'http://182.74.145.93/public/farmer_images/'.$fetch_oracle_response[0]['IMAGE_FILE_NAME'];
            $img = '/var/www/html/kiaar/assets/kiaar-web/images/farmers-img/';
            // $img = 'assets/kiaar-web/images/farmers-img/';
            file_put_contents($img.$fetch_oracle_response[0]['IMAGE_FILE_NAME'], file_get_contents($url));

            $upload_folder   = 'kiaar-farmers';  //folder name
            try {
                $client->putObject(array(
                    'Bucket'=>$bucket,
                    'Key' =>  'kiaar-farmers/'.$fetch_oracle_response[0]['IMAGE_FILE_NAME'],
                    'Body' => fopen($img.$fetch_oracle_response[0]['IMAGE_FILE_NAME'], 'rb')
                    // 'SourceFile' => $tmp,
                    // 'StorageClass' => 'REDUCED_REDUNDANCY'
                ));
                $message = "S3 Upload Successful.";
                $s3file='http://'.$bucket.'.s3.amazonaws.com/'.$upload_folder.'/'.$fetch_oracle_response[0]['IMAGE_FILE_NAME'];
                echo "<img src='$s3file'/>";
                echo 'S3 File URL:'.$s3file;
                // exit();
            } catch (S3Exception $e) {
            // Catch an S3 specific exception.
            echo $e->getMessage();
            }
        }

        if($status == 'SUCCESS')
        {
            if(empty($row))
            {   
                if($fetch_oracle_response[0]['MOBILE_NO'] == null OR $fetch_oracle_response[0]['MOBILE_NO'] == '')
                {
                    $mobile = 0;
                }
                else
                {
                    $mobile = $fetch_oracle_response[0]['MOBILE_NO'];
                }
                $saveData = $this->farmers_model->farmer_data_save('',array('FARMER_ID'=>$fetch_oracle_response[0]['FARMER_ID'], 'LAST_NAME'=>$lastname, 'MIDDLE_NAME'=>$middlename, 'FIRST_NAME'=>$firstname, 'MOBILE_NO'=>$mobile, 'CLUSTER_CD'=>$fetch_oracle_response[0]['CLUSTER_CD'], 'CLUSTER_NAME'=>$fetch_oracle_response[0]['CLUSTER_NAME'], 'VILLAGE_CD'=>$fetch_oracle_response[0]['VILLAGE_CD'], 'VILLAGE_NAME'=>$fetch_oracle_response[0]['VILLAGE_NAME'], 'AADHAAR_CARD_NO'=>$fetch_oracle_response[0]['AADHAAR_CARD_NO'], 'IMAGE_FILE_NAME'=>$s3file, 'created_on'=>date('Y-m-d H:i:s'), 'created_by'=>1));
                if($mobile == null OR $mobile == '' AND $saveData != FALSE)
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'mandatory data missing for this farmer']);
                    redirect(base_url()."cms/farmers/");
                }
                if($saveData == FALSE)
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data Not Inserted']);
                    redirect(base_url()."cms/farmers/");
                }
                else
                {                   
                    $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'Farmer Data Successfully Added']);
                    redirect(base_url()."cms/farmers/");
                }    

            }
            else
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data for this farmer is already exist']);
                redirect(base_url()."cms/farmers/");
            }
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Farmer ID is invalid']);
            redirect(base_url()."cms/farmers/");
        }       
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "farmers";
        $this->data['child_menu_type']      = "save_farmers";
        $this->data['sub_child_menu_type']  = "";
        $this->data['data']                 = [];
        $this->data['id']                   = $id;

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Farmers', 'edit', $per_action);

        if($this->input->post())
        {
            $this->data['data'] = $this->input->post();
        }

        $this->form_validation->set_rules('FARMER_ID', 'FARMER_ID', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                if($id)
                {
                    $update['farmers']['FARMER_ID']            = $this->input->post('FARMER_ID');
                    $update['farmers']['FIRST_NAME']           = $this->input->post('FIRST_NAME');
                    $update['farmers']['MIDDLE_NAME']          = $this->input->post('MIDDLE_NAME');
                    $update['farmers']['LAST_NAME']            = $this->input->post('LAST_NAME');
                    $update['farmers']['MOBILE_NO']            = $this->input->post('MOBILE_NO');
                    $update['farmers']['CLUSTER_CD']           = $this->input->post('CLUSTER_CD');
                    $update['farmers']['CLUSTER_NAME']         = $this->input->post('CLUSTER_NAME');
                    $update['farmers']['VILLAGE_CD']           = $this->input->post('VILLAGE_CD');
                    $update['farmers']['VILLAGE_NAME']         = $this->input->post('VILLAGE_NAME');
                    $update['farmers']['AADHAAR_CARD_NO']      = $this->input->post('AADHAAR_CARD_NO');
                    $update['farmers']['pincode']              = $this->input->post('pincode');
                    $update['farmers']['modified_on']          = date('Y-m-d H:i:s');
                    $update['farmers']['modified_by']          = $this->session->userdata['user_id'];
                    
                    $response = $this->farmers_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Farmer successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                // else
                // {
                //     $insert['farmers']['FIRST_NAME']           = $this->input->post('FIRST_NAME');
                //     $insert['farmers']['MIDDLE_NAME']          = $this->input->post('MIDDLE_NAME');
                //     $insert['farmers']['LAST_NAME']            = $this->input->post('LAST_NAME');
                //     $insert['farmers']['MOBILE_NO']            = $this->input->post('MOBILE_NO');
                //     $insert['farmers']['CLUSTER_CD']           = $this->input->post('CLUSTER_CD');
                //     $insert['farmers']['CLUSTER_NAME']         = $this->input->post('CLUSTER_NAME');
                //     $insert['farmers']['VILLAGE_CD']           = $this->input->post('VILLAGE_CD');
                //     $insert['farmers']['VILLAGE_NAME']         = $this->input->post('VILLAGE_NAME');
                //     $insert['farmers']['AADHAAR_CARD_NO']      = $this->input->post('AADHAAR_CARD_NO');
                //     $insert['farmers']['created_on']           = date('Y-m-d H:i:s');
                //     $insert['farmers']['created_by']           = $this->session->userdata['user_id'];

                //     $response                 = $this->farmers_model->_insert($insert);

                //     if(isset($response['status']) && $response['status'] == 'success')
                //     {
                //         $msg = ['error' => 0, 'message' => 'Farmer successfully added'];
                //     }
                //     else
                //     {
                //         $msg = ['error' => 0, 'message' => $response['message']];
                //     }
                // }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/farmers/');
            }
        }

        if($id!='')
        {
            $farmers                     = $this->farmers_model->get_farmers_list(['e.id' => $id]);
            $this->data['data']        = isset($farmers[0]) ? $farmers[0] : [];
            
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'farmers not found']);
                redirect(base_url()."cms/farmers/");
            }
        }

        $this->data['content']              = $this->load->view('cms/nabard/farmers/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function delete($id='')
    {
       
            
        validate_permissions('Farmers', 'delete', $this->config->item('method_for_delete'));
             
        $farmers = $this->farmers_model->get_farmers_list(['e.id' => $id]);

        if(!empty($farmers))
        {
            $response = $this->farmers_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'farmers not found.']);
        }
        redirect(base_url().'cms/farmers/');
    }
}