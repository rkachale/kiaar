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
class Kiaar_admin_sign extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model("Kiaar_general_admin_model");
        $this->load->model("Kiaar_admin_sign_model");
        $banner = @reset($this->Kiaar_general_admin_model->get_website_info());
        $_SESSION['language'] = $language = $this->Kiaar_general_admin_model->get_language_detail($banner["language_id"]);
        $this->lang->load($language["code"], $language["language_name"]);

    //load google login library
        //$this->load->library('google');
    }

    function index()
    {
      //google login url
    	
      //$data['loginURL'] = $this->google->loginURL();

        if ($this->session->userdata('logged_in_status') == TRUE)
        {
            redirect('/admin/');
        }
        else
        {
            $this->load->view('kiaar_admin_login',$data);
        }


    }

    function login()
    {

       $username = $this->security->xss_clean($this->input->post('username'));
       $password = md5($this->input->post('password'));
       $pass = $this->security->xss_clean($this->input->post('password'));
       // echo "<pre>"; print_r($pass);
       $passa = $pass;
       $this->load->model('Kiaar_admin_sign_model');
       $data['records']=$this->Kiaar_admin_sign_model->check_pass($username);
       $p = $data['records'][0];
       // echo "<pre>"; print_r($p);
       $pp = "'".$p['password']."'";
       //$pp = implode(" ",$p); 
       // echo "==========".$pp;
       //$password = password_verify($pass, $pp);
       // $passa2 = '6WRh4%$)';
       $passa = '$2y$10$PDMi4n5tN0ZYsE4qwGyVyeSioQSrvOorBqAeG0XqwbROggOE5XCmu';
      $verify = password_verify($pass, $passa);
                
      // if ($verify) {
      //    echo 'Hello';exit();
      // } else {
      //    echo 'Not Working';exit();
      // }

       if($verify) {
            $result=$this->Kiaar_admin_sign_model->check_login($username);
            $tam =  $result;            
            $datauser = $this->session->set_userdata($tam[0]);
            if(isset($data['user_id'])) {
            $_SESSION['Session_Admin'] = $data['user_id'];
          }
            redirect(base_url().'admin/');
        } else {
          $this->session->set_flashdata('message', _l('Incorrect Username or Password',$this));
           redirect(base_url().'admin-sign');
        }
    }


    function login_old()
    {

      $username = $this->security->xss_clean($this->input->post('username'));
      $password = md5($this->input->post('password'));
      $pass = $this->security->xss_clean($this->input->post('password'));
      $this->load->model('Kiaar_admin_sign_model');
      $data['records']=$this->Kiaar_admin_sign_model->check_pass($username);
      $p = $data['records'][0];
      $pp = implode(" ",$p); 
      $new= $pp . "<br>".$password;
  
      $password = password_verify($password, $pp);
      echo "<pre>"; print_r($password);
      if($password)
      {
        echo "<pre>";print_r("inside if");exit;
      }
      else
      {
        echo "<pre>";print_r("inside else");exit;
      }
       // if(1) {
       //      $result=$this->Kiaar_admin_sign_model->check_login($username);
       //      $tam =  $result;            
       //      $datauser = $this->session->set_userdata($tam[0]);
       //      if(isset($data['user_id'])) {
       //      $_SESSION['Session_Admin'] = $data['user_id'];
       //    }
       //      redirect(base_url().'admin/');
       //  } else {
       //    $this->session->set_flashdata('message', _l('Incorrect Username or Password',$this));
       //     redirect(base_url().'admin-sign');
       //  }

        // if($password==true) {
        //     $result=$this->Arigel_admin_sign_model->check_login($username);
        //     $tam =  $result;            
        //     $datauser = $this->session->set_userdata($tam[0]);
        //     if(isset($data['user_id'])) {
        //     $_SESSION['Session_Admin'] = $data['user_id'];
        //   }
        //     redirect(base_url().'admin/');
        // } else {
        //   $this->session->set_flashdata('message', _l('Incorrect Username or Password',$this));
        //    redirect(base_url().'admin-sign');
        // }
        
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('logged_in_status');
        redirect(base_url().'admin-sign');
    }
}
