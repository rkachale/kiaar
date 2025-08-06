<?php
/**
 * Created by Kiaar Team.
 * User: Kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Kiaar
 * Website: http://www.somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Kiaar_general extends Kiaar_Controller {

    function __construct()
    {
        parent::__construct('frontend');
        $this->load->library('email');        
        $this->load->library("Ajax_pagination");
        $this->load->library('session');
        $this->perPage = 10;
    }

    // Set system language from URL
    public function preset($lang)
    {
        $language = $this->Kiaar_general_model->getLanguageByCode($lang);
        if($language!=0){
            $_SESSION["language"] = $language;
            $this->data["lang"] = $lang;
        }else{
            $language = $this->Kiaar_general_model->getLanguageDefault();
            if($language!=0){
                redirect(base_url().$language["code"]);
            }else{
                exit("Didn't found eny language!");
            }
        }
        $this->lang->load($lang, $language["language_name"]);
        $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(__FILE__)));
        $this->data['lang_url'] = $_SERVER["REQUEST_URI"];
        $this->data['action'] = $_SERVER["REQUEST_URI"];
        $this->data['redirect'] = $_SERVER["REQUEST_URI"];

        $this->data['settings'] =  $this->Kiaar_general_model->getWebsiteInfo();
        $this->data['settings']["options"] =  $this->Kiaar_general_model->getWebsiteInfoOptions($language["language_id"]);
        $this->data['settings']["company"] =  isset($this->data['settings']["options"]["company"])?$this->data['settings']["options"]["company"]:$this->data['settings']["company"];
        $_SESSION['settings']=$this->data['settings'];

        
        $this->data['languages'] = $this->Kiaar_general_model->getLanguages();
        foreach ($this->data['languages'] as &$value) 
        {
            $url_array = explode("/",$this->data["lang_url"]);
            $url_array[array_search($lang,$url_array)]=$value["code"];
            $value["lang_url"] = implode("/",$url_array);
        }

        $this->data['link_contact'] = base_url()."contact";
    }

    // Homepage
    function index($ln=null)
    {   
        $this->preset($ln);
        if($ln == '') 
        {
            if (!$this->input->is_ajax_request())
            {
                //echo "cant access url directly";  
                show_404(); // Output "Page not found" error.
                exit();
            }
        } 
        $this->load->library('spyc');
        $page_type = spyc_load_file(getcwd()."/page_type.yml") ;
        $pages_render = array();
        $pages = $this->Kiaar_general_model->getPreviewPages();
        foreach ($pages as $item) 
        {
            $extension_data["page_data"] = $item;
            $extension_data["lang"] = $ln;
            $extension_data["settings"] = $this->data["settings"];
            $extension_data["preview_limit"] = $limit = get_extension_limit_preview($item["page_type"],$page_type);
            if(check_extension_order_preview($item["page_type"],$page_type))
            {
                $extension_data["data"] = $this->Kiaar_general_model->getExtensionsByPageId($item["page_id"],"extension_order","ASC",$limit!=0?$limit:null);
            }else{
                $extension_data["data"] = $this->Kiaar_general_model->getExtensionsByPageId($item["page_id"],"created_date","DESC",$limit!=0?$limit:null);
            }
            foreach ($extension_data["data"] as &$val) 
            {
                if(isset($val['extension_more'])) { $val['extension_more'] = spyc_load($val['extension_more']); }
            }

            $page_header = $item['title_caption'];
            $page_body = $this->load->view($page_type[$item["page_type"]]["theme_preview"],$extension_data,true);

            array_push($pages_render,array(
                "title"=>$page_header,
                "body"=>$page_body
            ));
        }

        $this->data['pages']            = $pages_render;

        $this->data['title']            = "Home";
        $this->data['keywords']         = isset($this->data['settings']["options"]["site_keyword"])?$this->data['settings']["options"]["site_keyword"]:"";
        $this->data['description']      = isset($this->data['settings']["options"]["site_description"])?$this->data['settings']["options"]["site_description"]:"";
        $this->data['event']            = $this->Kiaar_general_model->getEventhome();
        $this->data['content']          = $this->load->view($this->mainTemplate.'/home',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data,'');
    }

    // Pages content page
    function page($lang,$id=null)
    {
        $this->preset($lang);
        $this->load->library('spyc');
        $page_type = spyc_load_file(getcwd()."/page_type.yml");
         // If requested URL is in friendly URL format
        if($this->uri->segment(3))
        {
            $slug=$this->uri->segment(2)."/".$this->uri->segment(3);
        }
        else
        {
            $slug=$this->uri->segment(2);
        }

        // If requested URL is in /page/3 format
        $this->load->helper('url');

        if($this->uri->segment(2)=="page"){
            $id1 = $this->uri->segment(3);
            $page = $this->Kiaar_general_model->getPageSlug($id1);
            $slug=$page['slug'];
        
            // Redirect User to new formed URL : basepath()+lang()+$page
            redirect(base_url().$lang.'/'.$slug);
        }


        // $id1=$this->uri->segment(3);  
        $page = $this->Kiaar_general_model->getPageDetail($slug);
      //  print_r($page);exit;
        $id=$page['page_id'];
        if(!allowed_theme_page($page["page_type"],$page_type)){
            // show_404();
            $this->load->view('/common/404');
        }
        $order_by="created_date"; $sort="DESC";
        if(check_extension_order_preview($page["page_type"],$page_type)){ $order_by="extension_order"; $sort="ASC"; }
        if(isset($page_type[$page["page_type"]]["dynamic"])){
            $page["body"] = $this->Kiaar_general_model->getExtensionsByPageId($id,$order_by,$sort,10,(isset($_GET["offset"]) && is_numeric($_GET["offset"]))?$_GET["offset"]:0);
        }else{
            $page["body"] = $this->Kiaar_general_model->getExtensionsByPageId($id,$order_by,$sort);
        }
        $this->data['data']                             = $page;
        
        
        $this->data['title']=$page['title_caption'];
        $this->data['keyword'] = $this->Kiaar_general_model->getExtensionsByPageId($id);
        $this->data['event']            = $this->Kiaar_general_model->getEventhome();
        
        $this->data['gallery']            = $this->Kiaar_general_model->getGalleries();
        $j=0;
        foreach ($this->data['gallery'] as $key => $value) {
            $banner_images = $this->Kiaar_general_model->getGalleries_images($value['g_id']);

            $this->data['gallery'][$j]['banner_images'] = $banner_images;
            $j++;
        }

        // echo "<pre>"; print_r($this->data['gallery']);exit();

        if($this->uri->segment(2) == 'news-events')
        {
             $this->data['news_event']  = $this->Kiaar_general_model->getnews_events();
        }

       
        if(isset($_GET["ajax"]) && allowed_theme_page_ajax($page["page_type"],$page_type))
        {
            echo $this->load->view('flatlab/'.get_theme_page_ajax($page["page_type"],$page_type),$this->data,true);
        } 
        else 
        {
            $use_template = $this->mainTemplate;
            $this->data['view']=get_theme_page($page["page_type"],$page_type);
            $this->data['content']=$this->load->view($use_template.'/'.$this->data['view'],$this->data,true);
            $this->load->view($use_template,$this->data,'');
        }
    }

    // Sitemap 
    function siteMapXML()
    {
        header("Content-type: text/xml");
        $this->load->view('/kiaar_general/sitemap.xml');
    }

    function kiaar_contact_form_submit()
    {

        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }
        

        // echo json_encode($_POST); exit();
        // echo "<pre>";
        // print_r($_POST);
        // exit();
        $response = array();
        $post_submit = $this->input->post();

        if(!empty($post_submit))
        {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean',array('required'=>'First Name is required'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean',array('required'=>'Last Name is required'));
            $this->form_validation->set_rules('mobile_number', 'Mobile number', 'required|regex_match[/^[0-9]{10}$/]',array('required'=>'Mobile number is required','regex_match'=>'Please enter valid mobile number'));
            $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email|xss_clean',array('required'=>'Email Id is required', 'valid_email'=>'Please enter valid email id'));
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean',array('required'=>'Subject is required'));
            $this->form_validation->set_rules('user_message', 'Message', 'trim|required|xss_clean',array('required'=>'Message is required'));
            
            if($this->form_validation->run() == FALSE)
                {
                    $response['status'] = 'failure';
                    $response['message'] = 'Validation Error';
                    $response['error'] = array('first_name'=>strip_tags(form_error('first_name')),'last_name'=>strip_tags(form_error('last_name')),'mobile_number'=>strip_tags(form_error('mobile_number')), 'email_id'=>strip_tags(form_error('email_id')), 'subject'=>strip_tags(form_error('subject')), 'user_message'=>strip_tags(form_error('user_message')));
                }
                else
                {
                    // print_r($_POST);
                    // exit();

                    $first_name    = $this->security->xss_clean($this->input->post('first_name'));
                    $last_name     = $this->security->xss_clean($this->input->post('last_name'));
                    $mobile_number = $this->security->xss_clean($this->input->post('mobile_number'));
                    $email_id      = $this->security->xss_clean($this->input->post('email_id'));
                    $subject       = $this->security->xss_clean($this->input->post('subject'));
                    $user_message  = ($this->input->post('user_message') != '') ? $this->security->xss_clean($this->input->post('user_message')) : null;
                    
                    $to_email=array('patil.vc@somaiya.com');
                    //$to_email=array('admission.engg@somaiya.edu');
                    //echo "final check email : ".$to_email;exit();  
                    $from = 'noreply@somaiya.edu';

                    /*$msg = '{
                        "First Name":"'.$first_name.'",
                        "Last Name":"'.$last_name.'",
                        "Mobile Number":"'.$mobile_number.'",
                        "Email Id":"'.$email_id.'",
                        "Subject":"'.$subject.'",
                        "Message":"'.$user_message.'"
                        }';*/

                    $msg = "First Name : ".$first_name."<br>";
                    $msg .= "Last Name : ".$last_name."<br>";
                    $msg .= "Mobile Number : ".$mobile_number."<br>";
                    $msg .= "Email id : ".$email_id."<br>";
                    $msg .= "Subject : ".$subject."<br>";
                    $msg .= "Message : ".$user_message."<br>";

                    $to   = $to_email;
                    $this->load->config('email');
                    $this->load->library('email');
                    $this->email->clear();
                    $this->email->from($from, 'Kiaar Contact Data');
                    $list = $to;
                    $this->email->to($list);
                    $data = array();
                    $this->email->subject('Kiaar Contact - Data');
                    $this->email->message($msg);


                    if ($this->email->send()) {
                        // echo 'Your email was sent, thanks chamil.';
                    } else {
                        show_error($this->email->print_debugger());
                    }

                    $response['status'] = 'success';
                    $response['message']= 'Successfully Post Data';
                    $response['error']  = '';
                }
        }
        else
        {
            $response['status'] = 'failure';
            $response['message'] = 'Data Not Posted';
            $response['error']  = '';
                
        }

        echo json_encode($response);
    }


    /***Nabard Farmers AJAX Pagination with search filters ***/

    function nabard_farmers()
    { 
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }
        
        $conditions = array();

        //calc offset number
        $page2 = $this->security->xss_clean($this->input->post('page_no'));

        if(!$page2){
            $offset = 0;
        }else{
            $offset = $page2;
        }   

        //set conditions for search
        $farmer_name        = $this->security->xss_clean($this->input->post('farmer_name'));
        $cluster            = $this->security->xss_clean($this->input->post('cluster'));
        $farmer_id          = $this->security->xss_clean($this->input->post('farmer_id'));
        $village            = $this->security->xss_clean($this->input->post('village'));
        $lang1              = $this->security->xss_clean($this->input->post('lang'));

        if(!empty($farmer_name)){
            $conditions['search']['farmer_name']       = $farmer_name;
        }
        if(!empty($cluster)){
            $conditions['search']['cluster']           = $cluster;
        }
        if(!empty($farmer_id)){
            $conditions['search']['farmer_id']         = $farmer_id;
        }
        if(!empty($village)){
            $conditions['search']['village']           = $village;
        }
        if(!empty($lang1)){
            $conditions['search']['lang']               = $lang1;
        }

        
        $pp = $this->Kiaar_general_model->nabard_farmers($conditions);  
        if(!empty($pp)){$farmersCount = count($pp); }

        //pagination configuration
        $config['target']       = '#refined';
        $config['base_url']     = base_url().'en/nabard';
        $config['total_rows']   = $farmersCount;
        $config['per_page']     = $this->perPage;
        $config['link_func']    = 'searchFilter';

        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        if(!empty($farmer_name) OR !empty($cluster) OR !empty($farmer_id) OR !empty($village)){
            $this->data['farmers_count']=$farmersCount;
        }else {
            $this->data['farmers_count']=0;
        }   
 
        $this->data['nabard_farmers_listing'] = $this->Kiaar_general_model->nabard_farmers($conditions);
        // echo "<pre>";print_r($this->data['nabard_farmers_listing']);exit;

        $this->load->view($this->mainTemplate.'/'.'page_type/ajax-pagination-nabard-farmers',$this->data,false);
    }


    /** LOGIN FORM KIAAR FARMERS **/


    public function sign_in($lang) 
    {
        $this->preset($lang);
        $this->data['title'] = "Login";
        $this->data['content']=$this->load->view($this->mainTemplate.'/sign_in',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data,'sign_in');
        // $this->load->view('/kiaar_general/sign_in',$this->data,false);
    }

    public function login() 
    {   
        $mobile     = $this->input->post('mobile');
        $farmer_id  = $this->input->post('farmer_id');
        $user       = $this->Kiaar_general_model->check_mobile($mobile);
        $user_values       = $this->Kiaar_general_model->select_values($farmer_id);
        // echo "<pre>";print_r($user_values);exit;
        if($user) {

            // Generate OTP
            $otp = $this->generate_otp();
            $date = date("Y-m-d H:i:s");
            $data = [
                'otp'   => $otp,
                'otp_generated_on' => $date,
            ];

            // update otp in database
            $this->Kiaar_general_model->update_otp($mobile, $data);

            // send otp on mobile number
            // $message = $otp." is your OTP. Do not share with anyone.";
            $message = "Dear ".$user_values[0]['FIRST_NAME']." ".$user_values[0]['LAST_NAME'].", your OTP is ".$otp." Please enter this to verify your phone number, K J Somaiya Institute of Applied Agricultural Research";
            $this->send_sms($mobile, $message);

            $data['mobile'] = $mobile;
            $this->session->set_flashdata('success', 'true');
            redirect(base_url().'en/login?id='.$farmer_id);
            // $this->load->view('otp', $data);    

        } else {
            $this->session->set_flashdata('flsh_msg', 'Please enter your registered mobile no.');
            redirect(base_url().'en/login?id='.$farmer_id);
        }
    }


    public function resend_otp() 
    {   
        $mobile     = $this->input->post('mobile_number');
        $farmer_id  = $this->input->post('farmer_id');
        $user       = $this->Kiaar_general_model->check_mobile($mobile);
        $user_values       = $this->Kiaar_general_model->select_values($farmer_id);
        if($user) {

            // Generate OTP
            $otp = $this->generate_otp();
            $date = date("Y-m-d H:i:s");
            $data = [
                'otp'   => $otp,
                'otp_generated_on' => $date,
            ];

            // update otp in database
            $this->Kiaar_general_model->update_otp($mobile, $data);

            // send otp on mobile number
            // $message = $otp." is your OTP. Do not share with anyone.";
            $message = "Dear ".$user_values[0]['FIRST_NAME']." ".$user_values[0]['LAST_NAME'].", your OTP is ".$otp." Please enter this to verify your phone number, K J Somaiya Institute of Applied Agricultural Research";
            $this->send_sms($mobile, $message);

            $data['mobile'] = $mobile;
            $this->session->set_flashdata('success', 'true');
            redirect(base_url().'en/login?id='.$farmer_id);
            // $this->load->view('otp', $data);    

        } else {
            $this->session->set_flashdata('flsh_msg', 'Please enter your registered mobile no.');
            redirect(base_url().'en/login?id='.$farmer_id);
        }
    }


    public function send_sms($phone, $body) 
    {

        // // Your authentication key
        // $authKey    = 'OGEyZDAyMDdlZTlmYzQyZmU0NmU0MDAwMmZhM2NhOGU=';

        // // Multiple mobiles numbers separated by comma
        // $numbers = urlencode($phone);
        // // echo "<pre>";print_r($numbers);exit;

        // // Sender ID,While using route4 sender id should be 6 characters long.
        // $senderId   = 'CXSTEC';

        // // Your message to send, Add URL encoding here.
        // $message    = urlencode($body);

        // //Define route 
        // $route      = 'trans';

        // //Prepare you post parameters
        // $postData   = array(
        //     'apikey'   => $authKey,
        //     'mobiles'   => $numbers,
        //     'message'   => $message,
        //     'sender'    => $senderId,
        //     'route'     => $route
        // );  

        // //API URL
        // $url        = 'https://api.textlocal.in/send/';  

        // $ch = curl_init();
        // curl_setopt_array($ch, array(
        //     CURLOPT_URL             => $url,
        //     CURLOPT_RETURNTRANSFER  => true,
        //     CURLOPT_POST            => true,
        //     CURLOPT_POSTFIELDS      => $postData
        //     ));     

        // //Ignore SSL certificate verification
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // //get response
        // $output = curl_exec($ch);   
        // echo "<pre>";print_r($output);exit;
        // curl_close($ch);




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
     
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        // echo "<pre>";print_r($response);exit;
        curl_close($ch);
        
        // //Process your response here
        // echo $response;


    }

    public function generate_otp() 
    {
        $OTP    =   rand(1,9);
        $OTP    .=  rand(0,9);
        $OTP    .=  rand(0,9);
        $OTP    .=  rand(0,9);
        $OTP    .=  rand(0,9);
        $OTP    .=  rand(0,9);
        return $OTP;
    }

    public function verify() 
    {   
        $mobile     = $this->input->post('mobile_number');
        $farmer_id  = $this->input->post('farmer_id');
        $otp        = $this->input->post('otp');

        $otp_dbtime = $this->Kiaar_general_model->otp_verify($mobile,$farmer_id);
        // check for otp 
        $user = $this->Kiaar_general_model->verify($mobile, $otp);
        // echo "<pre>";print_r($user);exit;

        $date1 = date("Y-m-d H:i:s");
        $date2 = $otp_dbtime[0]['otp_generated_on'];
          
        // Use strtotime() function to convert
        // date into dateTimestamp
        $dateTimestamp1 = strtotime($date1);
        $dateTimestamp2 = strtotime($date2);

        // $diffrence = $dateTimestamp1 - $dateTimestamp2;
        $interval  = abs($dateTimestamp2 - $dateTimestamp1);
        $minutes   = round($interval / 60);
        //echo 'Diff. in minutes is: '.$minutes;exit;
        if($minutes > 10)
        {
            $this->session->set_flashdata('flsh_msg_user_otp', 'Your entered OTP is Expired!');
            redirect(base_url().'en/login?id='.$farmer_id);
        }
        if($user) {
            $this->session->set_flashdata('flsh_msg_after_login', 'You are successfully logged in!');
            $this->session->set_userdata($user);
            redirect(base_url().'en/soil-test-results?id='.$farmer_id);
        } else {
            $this->session->set_flashdata('flsh_msg_otp', 'Invalid OTP!');
            redirect(base_url().'en/login?id='.$farmer_id);
        }
    }


    function loginwithuser()
    {   
        if($this->input->post('loginwithuser'))
        {
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            $farmer_id=$this->input->post('farmer_id');
            $que=$this->db->query("select * from users_frontend where username='$username' and password='$password'");
            $row = $que->num_rows();
            if($row > 0)
            {   
                $session_data = array(  
                    'username'     =>     $username,
                    'login_by'  => 'Admin',
                );  
                $this->session->set_userdata($session_data);
                // redirect('User/dashboard');
                $this->session->set_flashdata('flsh_msg_after_login', 'You are successfully logged in!');
                redirect(base_url().'en/soil-test-results?id='.$farmer_id);
                // $this->data['content']=$this->load->view($this->mainTemplate.'/sign_in',$this->data,true);
                // $this->load->view($this->mainTemplate,$this->data,'sign_in');
            }
            else
            {   
                $this->session->set_flashdata('flsh_msg_user', 'Invalid Username or Password !');
                redirect(base_url().'en/login?id='.$farmer_id);
            }
        }
    }

    function soil_test($lang) 
    {   
        $this->preset($lang);
        $this->data['title'] = "Soil Test Results";
        $farmer_id = $_GET['id'];
        if($this->session->userdata('username') != '')  
        {   
            $farmer_id = $_GET['id'];
            // $farmer_id = $this->session->userdata('farmer_id');
            $this->data['farmers_details'] = $this->Kiaar_general_model->farmers_details($farmer_id);
            $j=0;
            foreach ($this->data['farmers_details'] as $key => $value) 
            {
                $crop_values = $this->Kiaar_general_model->get_crops($value['FARMER_ID']);
                $crop_values_year = $this->Kiaar_general_model->get_crops_year($value['FARMER_ID']);
                $this->data['farmers_details'][$j]['crop_values_year'] = $crop_values_year;
                $this->data['farmers_details'][$j]['crop_values'] = $crop_values;
                    $k=0;
                    foreach ($crop_values as $key2 => $value2) 
                    {   
                        $crop_images = $this->Kiaar_general_model->get_crop_images($value2['crop_id']);
                        $this->data['farmers_details'][$j]['crop_values'][$k]['crop_images'] = $crop_images;
                        $k++;
                    }
                $j++;
            }


            // echo "<pre>";print_r($this->data['farmers_details']);exit;
            // get graph data
            $graph_data = $this->Kiaar_general_model->farmers_soil_values($farmer_id);
            if(isset($graph_data) && !empty($graph_data))
            {   
                foreach ($graph_data as $key => $value) {
                    $graph_data_response[] =[
                        "ph" => $value['ph'],
                        "ec" => $value['ec'],
                        "oc" => $value['oc'],
                        "n" => $value['n'],
                        "p" => $value['p'],
                        "k" => $value['k'],
                        "s" => $value['s'],
                        "ca" => $value['ca'],
                        "mg" => $value['mg'],
                        "zn" => $value['zn'],
                        "fe" => $value['fe'],
                        "mn" => $value['mn'],
                        "cu" => $value['cu'],
                        "bulk_densilty" => $value['bulk_densilty'],
                        "sic" => $value['sic'],
                        "soc" => $value['soc'],
                        "toc" => $value['toc']
                    ];                
                }
            }
            else
            {
                $graph_data_response = [[
                "ph" => 0,
                "ec" => 0,
                "oc" => 0,
                "n" => 0,
                "p" => 0,
                "k" => 0,
                "s" => 0,
                "ca" => 0,
                "mg" => 0,
                "zn" => 0,
                "fe" => 0,
                "mn" => 0,
                "cu" => 0,
                "bulk_densilty" => 0,
                "sic" => 0,
                "soc" => 0,
                "toc" => 0
                ]];
            }

            $this->data['graph_data_response'] = $graph_data_response;
            // echo "<pre>";print_r($this->data['graph_data_response']);exit;
            $this->data['content']=$this->load->view($this->mainTemplate.'/soil-testing',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data,'soil-testing'); 
        }
        elseif($this->session->userdata('login_mobile') != '' && $this->session->userdata('login_by') == 'Mobile' && $this->session->userdata('login_id') == $farmer_id)  
        {   
            // $farmer_id = $this->session->userdata('farmer_id');
            $this->data['farmers_details'] = $this->Kiaar_general_model->farmers_details($farmer_id);
            $j=0;
            foreach ($this->data['farmers_details'] as $key => $value) 
            {
                $crop_values = $this->Kiaar_general_model->get_crops($value['FARMER_ID']);
                $crop_values_year = $this->Kiaar_general_model->get_crops_year($value['FARMER_ID']);
                $this->data['farmers_details'][$j]['crop_values_year'] = $crop_values_year;
                $this->data['farmers_details'][$j]['crop_values'] = $crop_values;
                    $k=0;
                    foreach ($crop_values as $key2 => $value2) 
                    {   
                        $crop_images = $this->Kiaar_general_model->get_crop_images($value2['crop_id']);
                        $this->data['farmers_details'][$j]['crop_values'][$k]['crop_images'] = $crop_images;
                        $k++;
                    }
                $j++;
            }


            // echo "<pre>";print_r($this->data['farmers_details']);exit;
            // get graph data
            $graph_data = $this->Kiaar_general_model->farmers_soil_values($farmer_id);
            if(isset($graph_data) && !empty($graph_data))
            {   
                foreach ($graph_data as $key => $value) {
                    $graph_data_response[] =[
                        "ph" => $value['ph'],
                        "ec" => $value['ec'],
                        "oc" => $value['oc'],
                        "n" => $value['n'],
                        "p" => $value['p'],
                        "k" => $value['k'],
                        "s" => $value['s'],
                        "ca" => $value['ca'],
                        "mg" => $value['mg'],
                        "zn" => $value['zn'],
                        "fe" => $value['fe'],
                        "mn" => $value['mn'],
                        "cu" => $value['cu'],
                        "bulk_densilty" => $value['bulk_densilty'],
                        "sic" => $value['sic'],
                        "soc" => $value['soc'],
                        "toc" => $value['toc']
                    ];                
                }
            }
            else
            {
                $graph_data_response = [[
                "ph" => 0,
                "ec" => 0,
                "oc" => 0,
                "n" => 0,
                "p" => 0,
                "k" => 0,
                "s" => 0,
                "ca" => 0,
                "mg" => 0,
                "zn" => 0,
                "fe" => 0,
                "mn" => 0,
                "cu" => 0,
                "bulk_densilty" => 0,
                "sic" => 0,
                "soc" => 0,
                "toc" => 0
                ]];
            }

            $this->data['graph_data_response'] = $graph_data_response;
            // echo "<pre>";print_r($this->data['graph_data_response']);exit;
            $this->data['content']=$this->load->view($this->mainTemplate.'/soil-testing',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data,'soil-testing'); 
        }  
        else  
        {  
            $farmer_id = $_GET['id'];
            redirect(base_url().'en/login?id='.$farmer_id);
        }  
    }

    function soil_test_stage($lang) 
    {   
        $this->preset($lang);
        $this->data['title'] = "Soil Test Results Stage";
        $farmer_id = $_GET['id'];
        if($this->session->userdata('username') != '')  
        {   
            $farmer_id = $_GET['id'];
            // $farmer_id = $this->session->userdata('farmer_id');
            $this->data['farmers_details'] = $this->Kiaar_general_model->farmers_details_new($farmer_id);
            $j=0;
            foreach ($this->data['farmers_details'] as $key => $value) 
            {   
                $crop_values = $this->Kiaar_general_model->get_crops($value['FARMER_ID']);
                $crop_values_year = $this->Kiaar_general_model->get_crops_year($value['FARMER_ID']);
                $this->data['farmers_details'][$j]['crop_values_year'] = $crop_values_year;
                $this->data['farmers_details'][$j]['crop_values'] = $crop_values;
                    $k=0;
                    foreach ($crop_values as $key2 => $value2) 
                    {   
                        $crop_images = $this->Kiaar_general_model->get_crop_images($value2['crop_id']);
                        $this->data['farmers_details'][$j]['crop_values'][$k]['crop_images'] = $crop_images;
                        $k++;
                    }
                $j++;
            }
            // echo "<pre>";print_r($this->data['farmers_details']);exit;
            $this->data['content']=$this->load->view($this->mainTemplate.'/soil-testing-stage',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data,'
                '); 
        }
        elseif($this->session->userdata('login_mobile') != '' && $this->session->userdata('login_by') == 'Mobile' && $this->session->userdata('login_id') == $farmer_id)  
        {   
            // $farmer_id = $this->session->userdata('farmer_id');
            $this->data['farmers_details'] = $this->Kiaar_general_model->farmers_details($farmer_id);
            $j=0;
            foreach ($this->data['farmers_details'] as $key => $value) 
            {
                $crop_values = $this->Kiaar_general_model->get_crops($value['FARMER_ID']);
                $crop_values_year = $this->Kiaar_general_model->get_crops_year($value['FARMER_ID']);
                $this->data['farmers_details'][$j]['crop_values_year'] = $crop_values_year;
                $this->data['farmers_details'][$j]['crop_values'] = $crop_values;
                    $k=0;
                    foreach ($crop_values as $key2 => $value2) 
                    {   
                        $crop_images = $this->Kiaar_general_model->get_crop_images($value2['crop_id']);
                        $this->data['farmers_details'][$j]['crop_values'][$k]['crop_images'] = $crop_images;
                        $k++;
                    }
                $j++;
            }
            $this->data['content']=$this->load->view($this->mainTemplate.'/soil-testing-stage',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data,'soil-testing'); 
        }  
        else  
        {  
            $farmer_id = $_GET['id'];
            redirect(base_url().'en/login?id='.$farmer_id);
        }  
    }

    function loginby()  
    {  
        if($this->session->userdata('login_mobile') != '' && $this->session->userdata('login_by') == 'Mobile')  
        {   
            $farmer_id = $this->session->userdata('login_id');
            redirect(base_url().'en/soil-test-results?id='.$farmer_id);
        }
        else
        {
            echo "you can not access this";
        }  
    }

    function logout()  
    {  
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('login_mobile');
        $this->session->unset_userdata('login_by');
        $this->session->unset_userdata('login_id');
        $this->session->set_flashdata('flsh_msg_after_logout', 'You are successfully logged out!');  
        redirect(base_url().'en/nabard/');  
    }

    // start following method used for notice page.
    
    function getCrops_by_filter()
    {
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        $conditions = array();

        //calc offset number
        $page2 = $this->security->xss_clean($this->input->post('page_no'));

        if(!$page2){
            $offset = 0;
        }else{
            $offset = $page2;
        }   

        //set conditions for search
        $year      = $this->security->xss_clean($this->input->post('year'));
        $farmer_id = $this->security->xss_clean($this->input->post('farmer_id'));
        $lang1     = $this->security->xss_clean($this->input->post('lang'));
        
        if(!empty($year)){
            $conditions['search']['year'] = $year;
        }     
        
        if(!empty($farmer_id)){
            $conditions['search']['farmer_id'] = $farmer_id;
        }

        if(!empty($lang1)){
            $conditions['search']['lang'] = $lang1;
        }
    
        $pp = $this->Kiaar_general_model->getCrops_by_filter($conditions);  

        $noticesCount = 0;

        if(!empty($pp)){$noticesCount = count($pp); }
        //pagination configuration
        $config['target']      = '#crop_data';
        $config['base_url']    = base_url().'/en/soil-test-results';
        $config['total_rows']  = $noticesCount;
        //$config['per_page']    = $this->perPage;
        $config['per_page']    = 10;
        $config['link_func']   = 'getCrops_by_filter';

            
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = 10;
        $this->data['notices_count']=$noticesCount;

        $this->data['yearly_crops'] = $this->Kiaar_general_model->getCrops_by_filter($conditions);
        // echo "<pre>";print_r($this->data['yearly_crops']);exit;
        $this->load->view($this->mainTemplate.'/'.'page_type/ajax-pagination-crops',$this->data,false);
    }


    function get_crop_details()
    {           
        $id = $this->security->xss_clean($this->input->post('id'));
        $month = $this->security->xss_clean($this->input->post('month'));
        $this->data['crop_images'] = $this->Kiaar_general_model->get_crop_images_popup($id,$month);
        $this->load->view($this->mainTemplate.'/'.'page_type/crop_images',$this->data,false);
    }


    function getCrops_by_month()
    {
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        $conditions = array();

        //calc offset number
        $page2 = $this->security->xss_clean($this->input->post('page_no'));

        if(!$page2){
            $offset = 0;
        }else{
            $offset = $page2;
        }   

        //set conditions for search
        $year       = $this->security->xss_clean($this->input->post('year'));
        $month      = $this->security->xss_clean($this->input->post('month'));
        $farmer_id    = $this->security->xss_clean($this->input->post('farmer_id'));
        $lang1      = $this->security->xss_clean($this->input->post('lang'));
        
        if(!empty($year)){
            $conditions['search']['year'] = $year;
        }     
        
        if(!empty($month)){
            $conditions['search']['month'] = $month;
        }

        if(!empty($farmer_id)){
            $conditions['search']['farmer_id'] = $farmer_id;
        }

        if(!empty($lang1)){
            $conditions['search']['lang'] = $lang1;
        }
    
        $pp = $this->Kiaar_general_model->getCrops_by_month($conditions);  

        $noticesCount = 0;

        if(!empty($pp)){$noticesCount = count($pp); }
        //pagination configuration
        $config['target']      = '#crop_data';
        $config['base_url']    = base_url().'/en/soil-test-results';
        $config['total_rows']  = $noticesCount;
        //$config['per_page']    = $this->perPage;
        $config['per_page']    = 10;
        $config['link_func']   = 'getCrops_by_month';

            
        $this->ajax_pagination->initialize($config);
        $conditions['start'] = $offset;
        $conditions['limit'] = 10;
        $this->data['notices_count']=$noticesCount;

        $this->data['monthly_crops'] = $this->Kiaar_general_model->getCrops_by_month($conditions);
        // echo "<pre>";print_r($this->data['monthly_crops']);exit;
        $this->load->view($this->mainTemplate.'/'.'page_type/ajax-pagination-crops-images',$this->data,false);
    }

    function carousel_slider_images()
    {   
        $year       = $this->security->xss_clean($this->input->post('year'));
        $month      = $this->security->xss_clean($this->input->post('month'));
        $farmer_id    = $this->security->xss_clean($this->input->post('farmer_id'));
        
        if(!empty($year)){
            $conditions['search']['year'] = $year;
        }     
        
        if(!empty($month)){
            $conditions['search']['month'] = $month;
        }

        if(!empty($farmer_id)){
            $conditions['search']['farmer_id'] = $farmer_id;
        }

        $this->data['crop_images'] = $this->Kiaar_general_model->getCrops_by_month($conditions);
        $this->load->view($this->mainTemplate.'/'.'page_type/carousal-crops-images',$this->data,false);
    }

    function crop_health_monitoring($lang)
    {
        $this->preset($lang);
        $this->data['title'] = "Crop Health Monitoring";
        $farmer_id = $this->uri->segment(3);
        $year_id   = $this->uri->segment(4);
        $month_id  = $this->uri->segment(5);

        if($this->session->userdata('username') != '')  
        {
            $farmer_id = $this->security->xss_clean($this->uri->segment(3));
            $year_id   = $this->security->xss_clean($this->uri->segment(4));
            $month_id  = $this->security->xss_clean($this->uri->segment(5));

            $this->data['farmer_id']    = $farmer_id;
            $this->data['year']         = $year_id;
            $this->data['month']        = $month_id;

            // get farmer name by id
            $this->data['farmer_name']    = $this->Kiaar_general_model->get_farmername_by_id($farmer_id);
            // get crop health images 
            $this->data['crop_health_monitoring_images'] = $this->Kiaar_general_model->get_crop_health_monitoring_images($farmer_id,$year_id,$month_id);
            $this->data['content'] = $this->load->view($this->mainTemplate.'/crop-health-monitoring',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data,'crop-health-monitoring'); 

        }
        else
        {
            redirect(base_url().'en/login?id='.$farmer_id);
        }
    }

    function get_crophealth_monitoringImages()
    {
        $year       = $this->security->xss_clean($this->input->post('year'));
        $month      = $this->security->xss_clean($this->input->post('month'));
        $farmer_id  = $this->security->xss_clean($this->input->post('farmer_id'));
        
        if(!empty($year)){
            $conditions['search']['year'] = $year;
        }     
        
        // if(!empty($month)){
        //     $conditions['search']['month'] = $month;
        // }

        if(!empty($farmer_id)){
            $conditions['search']['farmer_id'] = $farmer_id;
        }

        $crop_images_listing = $this->Kiaar_general_model->get_crophealth_monitoringImages($conditions);
        //$this->data['crop_images_listing_ajax1'] = $this->_group_by($crop_images_listing,'month');
        // following code to add all months in year
        $data_by_month_group = $this->_group_by($crop_images_listing,'month');
        $months = ['01','02','03','04','05','06','07','08','09','10','11','12'];

        foreach ($months as $value) {

            if(isset($data_by_month_group[$value]))
            {
                $search_month = array_search($value, array_column($data_by_month_group[$value], 'month'));

                if($search_month > -1)
                {
                    //echo "exit value<br>";
                    $finalArray[$value] = $data_by_month_group[$value];
                    
                }
                else
                {
                    //echo "non exit<br>";
                    $finalArray[$value] = [
                                        'id' => '',
                                        'crop_id'=>'',
                                        'image' => '',
                                        'name' => '',
                                        'description' => '',
                                        'month' => $value,
                                        'year' => '',
                                        'FARMER_ID' => '',
                                        'language' => 'en',
                                    ];

                }
            }
            else
            {
                $finalArray[$value] = [
                                        'id' => '',
                                        'crop_id'=>'',
                                        'image' => '',
                                        'name' => '',
                                        'description' => '',
                                        'month' => $value,
                                        'year' => '',
                                        'FARMER_ID' => '',
                                        'language' => 'en',
                                    ];
            }
            

        }

        $this->data['finalArray'] = $finalArray;
        $this->data['year'] = $year;
        $this->load->view($this->mainTemplate.'/'.'ajax-crophealth-monitoring-images',$this->data,false);
    }

    function _group_by($array, $key) {
        $return = array();
        //$array = (array)json_decode($array);
        foreach($array as $val) {
            //$return[$val[$key]][] = $val;
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    function get_crophealth_image_by_id()
    {
        $crop_id = $this->security->xss_clean($this->input->post('crop_id'));
        $year       = $this->security->xss_clean($this->input->post('year'));
        $month      = $this->security->xss_clean($this->input->post('month'));
        $farmer_id  = $this->security->xss_clean($this->input->post('farmer_id'));

        $cropimage_by_id = $this->Kiaar_general_model->get_crophealth_image_by_id($crop_id);

        // echo "<pre>";
        // print_r($cropimage_by_id);
        // exit();
        $crop_image_url = "/upload_file/crop_health_upload/".$cropimage_by_id[0]['FARMER_ID']."_".$cropimage_by_id[0]['year']."-".$cropimage_by_id[0]['month']."/".$cropimage_by_id[0]['image'];
        // echo "img url : ".$crop_image_url;
        $crop_img = "<img src=".$crop_image_url.">";
        echo $crop_img;
        exit();
    }

    function run_nabard_farmers_soiltest_results()
    {
        exit;
        $this->db->select('*');
        $this->db->from('test_tran_head');
        $this->db->where('is_synced', 0);
        $this->db->limit(100);
        $query              = $this->db->get();
        $result             = $query->result_array();
        foreach ($result as $key => $value) 
        {   
            $data = array(
                'FARMER_ID'     => isset($value['farmer_ID']) ? $value['farmer_ID'] : '',
                'plot_no'       => isset($value['plot_no']) ? $value['plot_no'] : '',
                'survey_no'     => isset($value['survey_no']) ? $value['survey_no'] : '',
                'area'          => isset($value['plot_area']) ? $value['plot_area'] : '',
                'future_crop'   => isset($value['future_crop']) ? $value['future_crop'] : '',
                'soil_type'     => isset($value['soil_type']) ? $value['soil_type'] : '',
                'status'        => isset($value['status']) ? $value['status'] : '1',
                'created_by'    => isset($value['created_by']) ? $value['created_by'] : '',
                'created_on'    => isset($value['created_on']) ? $value['created_on'] : '',
                'modified_by'   => isset($value['modified_by']) ? $value['modified_by'] : '',
                'modified_on'   => isset($value['modified_on']) ? $value['modified_on'] : '',
            );
            $this->db->insert('plot_master', $data);
            $insert_id = $this->db->insert_id();

            // $this->db->select('*');
            // $this->db->from('plot_master');
            // $this->db->limit(100);
            // $querynew           = $this->db->get();
            // $resultnew          = $querynew->result_array();

            // echo "<pre>";print_r($data);
            // if(!empty($insert) && !empty($contact_data))
            // {
                $this->db->insert('soil_master', [
                    'FARMER_ID'     => isset($value['farmer_ID']) ? $value['farmer_ID'] : '',
                    'plot_no'       => isset($value['plot_no']) ? $value['plot_no'] : '',
                    'test_date'     => isset($value['test_date']) ? $value['test_date'] : '',
                    'sample_date'   => isset($value['sample_date']) ? $value['sample_date'] : '',
                    'report_name'   => 'LINK',
                    'report_link'   => isset($value['s3_link']) ? $value['s3_link'] : '',
                    'status'        => isset($value['status']) ? $value['status'] : '1',
                    'created_by'    => isset($value['created_by']) ? $value['created_by'] : '',
                    'created_on'    => isset($value['created_on']) ? $value['created_on'] : '',
                    'modified_by'   => isset($value['modified_by']) ? $value['modified_by'] : '',
                    'created_on'    => isset($value['created_on']) ? $value['created_on'] : '',
                ]);

                if($this->db->affected_rows() > 0)
                {
                    $this->db->where('farmer_ID', $value['farmer_ID']);
                    $this->db->update('test_tran_head', ['is_synced' => 1]);
                }
            // }
        }
        echo "<pre>Cron job executed...";exit;
    }

}