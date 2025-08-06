<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 10/05/2018
 * Time: 2:22 PM
 * Project: Somaiya Vidyavihar
 * Website: https://www.somaiya.edu
 */

// defined('BASEPATH') OR exit('No direct script access allowed');
class Errors extends Kiaar_Controller {

    function __construct(){
        parent::__construct('frontend');
    }
    public function error404(){
    	// echo "<pre>";print_r('Page not found');exit;
    	$this->load->view("/common/404");
    }
}
