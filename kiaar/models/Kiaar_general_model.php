<?php
/**
 * Created by Kiaar Team.
 * User: Kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Kiaar
 * Website: http://www.somaiya.com
 */
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Kiaar_general_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    
    // Select from "setting" table
    function getWebsiteInfo()
    {
        $this->db->select('*');
        $this->db->from('setting');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select setting's options in one language from "setting_options_per_lang" table 
    function getWebsiteInfoOptions($language_id=null)
    {
        $this->db->select('*');
        $this->db->from('setting_options_per_lang');
        if($language_id!=null)
            $this->db->where('language_id',$language_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a list from "menu" table
    function getMenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->join('page',"page.page_id=menu.page_id","left");
        $this->db->join('titles',"titles.relation_id=menu_id");
        $this->db->where('titles.data_type',"menu");
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('menu.public',1);
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "languages" table
    function getLanguages()
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('public',1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a row with "code" field from "languages" table
    function getLanguageByCode($code)
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('public',1);
        $this->db->where('code',$code);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a row from "languages" table (main condition: default = 0)
    function getLanguageDefault()
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('public',1);
        $this->db->where('default',1);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a list from "pages" table if preview = 1
    function getPreviewPages()
    {
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('titles',"titles.relation_id=page_id");
        $this->db->where('titles.data_type',"page");
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('preview',1);
        $this->db->where('public',1);
        $this->db->order_by('page_order',"ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "extensions" table
    function getExtensionsByPageId($page_id,$order_by="extension_order",$sort="DESC",$limit=null,$offset=0)
    {
        $this->db->select('*');
        $this->db->from('extensions');
        $this->db->where("relation_id",$page_id);
        $this->db->where('data_type',"page");
        $this->db->where('extensions.language_id',$_SESSION["language"]["language_id"]);
        //$this->db->where('status',1);
        $this->db->where('public',1);
        $this->db->order_by($order_by,$sort);
        if($limit!=null) $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "extensions" table
    function getExtensionRelated($page_id,$extension_id,$order_by="created_date",$sort="DESC",$limit=null,$offset=0)
    {
        $this->db->select('*');
        $this->db->from('extensions');
        $this->db->where("relation_id",$page_id);
        $this->db->where('data_type',"page");
        $this->db->where('extensions.language_id',$_SESSION["language"]["language_id"]);
        //$this->db->where('status',1);
        $this->db->where('public',1);
        $this->db->where('extension_id != '.$extension_id);
        $this->db->order_by($order_by,$sort);
        if($limit!=null) $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a row from "extensions" table with extension_id
    function getExtensionByExtensionId($id)
    {
        $this->db->select('*,extensions.image');
        $this->db->from('extensions');
        $this->db->join('users', 'extensions.user_id = users.user_id',"left");
        $this->db->join('page', 'page.page_id = extensions.relation_id');
        $this->db->join('languages', 'languages.language_id = extensions.language_id',"left");
        $this->db->join('titles', 'page.page_id = titles.relation_id');
        $this->db->where('extensions.data_type',"page");
        $this->db->where('titles.data_type',"page");
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        // $this->db->where('extensions.status',1);
        $this->db->where('extensions.public',1);
        $this->db->where('extensions.extension_id',$id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a row from "page" table with page_id OR by slug
    function getPageDetail($slug)
    {   
        
        $this->db->select('*,page.slug');
        $this->db->from('page');
     //   $this->db->join('titles', "relation_id=page_id");
        $this->db->where('slug', $slug);
      //  $this->db->where('data_type', 'page');
      //  $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    function getPageSlug($id1)
    {
        $this->db->select('*,page.slug');
        $this->db->from('page');
        $this->db->join('titles', "relation_id=page_id");
        $this->db->where('page_id', $id1);
        $this->db->where('data_type', 'page');
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }
    
    function getEventhome()
    {
        $this->db->select('*');
        $this->db->from('event_new e');
        $this->db->join('eventcontents_new ec','e.event_id = ec.event_id','left');
        $this->db->where('e.public',1);
        $this->db->order_by('e.to_date',"DESC");
        $this->db->limit(3);
        $query = $this->db->get();
        return $query->result_array();
    }

      function getnews_events()
    {
        $this->db->select('*');
        $this->db->from('event_new e');
        $this->db->join('eventcontents_new ec','e.event_id = ec.event_id','left');
        $this->db->where('e.public',1);
        $this->db->order_by('e.to_date',"DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function getGalleries()
    {
        $this->db->select('*,COUNT(photos.image) as gcount');
        $this->db->from('galleries');
        $this->db->join('photos',"photos.g_id=galleries.g_id",'left');
        $this->db->join('galleries_type',"galleries_type.id=galleries.type_id",'left');
        $this->db->where('galleries.public',1);
        $this->db->group_by('photos.g_id');
        $this->db->order_by('galleries.g_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    function getGalleries_images($g_id)
    {
        $this->db->select("*");
        $this->db->from('photos');
        $this->db->where('g_id', $g_id);
        $this->db->order_by('g_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /***** NABARD FARMERS *******/


    function Villages()
    {
        $this->db->select("DISTINCT(nabard_farmers_master.VILLAGE_NAME) as village_name");
        $this->db->from('nabard_farmers_master');
        $this->db->where('nabard_farmers_master.VILLAGE_NAME IS NOT NULL');
        $this->db->order_by('nabard_farmers_master.VILLAGE_NAME', 'ASC');
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE; 
        return $result;
    }

    function Cluster()
    {
        $this->db->select("DISTINCT(nabard_farmers_master.CLUSTER_NAME) as cluster_name");
        $this->db->from('nabard_farmers_master');
        $this->db->where('nabard_farmers_master.CLUSTER_NAME IS NOT NULL');
        $this->db->order_by('nabard_farmers_master.CLUSTER_NAME', 'ASC');
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE; 
        return $result;
    }

    // function Farmers()
    // {
    //     $this->db->select("DISTINCT(nabard_farmers_master.FARMER_ID) as farmer_id, CONCAT(nabard_farmers_master.FIRST_NAME , ' ', nabard_farmers_master.MIDDLE_NAME, ' ', nabard_farmers_master.LAST_NAME ) as farmer_name");
    //     $this->db->from('nabard_farmers_master');
    //     $this->db->where('nabard_farmers_master.FARMER_ID IS NOT NULL');
    //     $this->db->order_by('nabard_farmers_master.FIRST_NAME', 'ASC');
    //     $query = $this->db->get();
    //     // echo "<pre>";print_r($this->db->last_query());exit;
    //     $result= ($query->num_rows() > 0)?$query->result_array():FALSE; 
    //     return $result;
    // }


    function nabard_farmers($params = array())
    {
        $farmer_name        = $params['search']['farmer_name'];
        $cluster            = $params['search']['cluster'];
        $farmer_id          = $params['search']['farmer_id'];
        $village            = $params['search']['village'];
        $lang1              = $params['search']['lang'];

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        if(!empty($farmer_name) AND $farmer_name != 'undefined')
        {
            $this->db->like('nabard_farmers_master.FIRST_NAME', $params['search']['farmer_name']);
            $this->db->or_like('nabard_farmers_master.MIDDLE_NAME', $params['search']['farmer_name']);
            $this->db->or_like('nabard_farmers_master.LAST_NAME', $params['search']['farmer_name']);
        }

        if(!empty($farmer_id) AND $farmer_id != 'undefined')
        {
            $this->db->or_like('nabard_farmers_master.FARMER_ID', $params['search']['farmer_id']);
        }

        if(!empty($cluster) AND $cluster!='undefined'){
            $this->db->where("FIND_IN_SET(`nabard_farmers_master`.`CLUSTER_NAME`, ('$cluster'))");
        }
        if(!empty($village) AND $village!='undefined') {
            $this->db->where("FIND_IN_SET(`nabard_farmers_master`.`VILLAGE_NAME`, ('$village'))");
        }
        
        $this->db->select('*,GROUP_CONCAT(DISTINCT(nabard_farmers_master.CLUSTER_NAME)) AS CLUSTER_NAME, GROUP_CONCAT(DISTINCT(nabard_farmers_master.VILLAGE_NAME)) AS VILLAGE_NAME');
        $this->db->from('nabard_farmers_master');
        $this->db->group_by("nabard_farmers_master.id");
        $this->db->order_by('nabard_farmers_master.FIRST_NAME', 'DESC');
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        } 
        return $result;     
    }


    function check_mobile($mobile) 
    {   
        $this->db->where(['MOBILE_NO' => $mobile]);
        $query  = $this->db->get('nabard_farmers_master');
        $result = $query->num_rows();
        return $result;
    }

    function select_values($farmer_id) 
    {   
        $this->db->where(['FARMER_ID' => $farmer_id]);
        $query  = $this->db->get('nabard_farmers_master');
        return $query->result_array();
        // $result = $query->num_rows();
        // return $result;
    }

    function update_otp($mobile, $data) 
    {   
        return $this->db->update('nabard_farmers_master', $data, ["MOBILE_NO"=>$mobile]);
    }

    function verify($mobile, $otp) 
    {
        $data = [];
        // $this->db->where(['nabard_farmers_master' => $mobile, otp => $otp]);
        $this->db->where('nabard_farmers_master.MOBILE_NO', $mobile);
        $this->db->where('nabard_farmers_master.otp', $otp);
        $query = $this->db->get('nabard_farmers_master');
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        $result = $query->row();
        if($result) {
            $data = [
                'login_id'  => $result->FARMER_ID,
                // 'login_name'    => $result->name,
                'login_mobile'  => $result->MOBILE_NO,
                'login_status'  => TRUE,
                'login_by'  => 'Mobile',
            ];
        }
        return $data;
    }

    function farmers_details($farmer_id)
    {
        $this->db->select("*,nabard_farmers_master.FARMER_ID as FARMER_ID,DATE_FORMAT(test_tran_head.test_date,'%d-%m-%Y') AS date, DATE_FORMAT(test_tran_head.sample_date,'%d-%m-%Y') AS sampledate");
        $this->db->from('nabard_farmers_master');
        $this->db->join('test_tran_head',"test_tran_head.FARMER_ID=nabard_farmers_master.FARMER_ID",'left');
        $this->db->where('nabard_farmers_master.FARMER_ID', $farmer_id);
        $this->db->order_by('test_tran_head.test_tran_ID',"DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    /******* START **************/
    /* New Farmer details on 29-02-2024 on stage*/

    function farmers_details_new($farmer_id)
    {
        $this->db->select("*,nabard_farmers_master.FARMER_ID as FARMER_ID,DATE_FORMAT(soil_master.test_date,'%d-%m-%Y') AS date, DATE_FORMAT(soil_master.sample_date,'%d-%m-%Y') AS sampledate, soil_master.id as soilID");
        $this->db->from('nabard_farmers_master');
        $this->db->join('soil_master',"soil_master.FARMER_ID=nabard_farmers_master.FARMER_ID",'left');
        $this->db->join('plot_master',"plot_master.FARMER_ID=nabard_farmers_master.FARMER_ID",'left');
        $this->db->where('nabard_farmers_master.FARMER_ID', $farmer_id);
        $this->db->order_by('soil_master.id',"DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function soil_master_details($farmer_id)
    {
        $this->db->select("soil_master.*,nabard_farmers_master.FARMER_ID as FARMER_ID,DATE_FORMAT(soil_master.test_date,'%d-%m-%Y') AS date, DATE_FORMAT(soil_master.sample_date,'%d-%m-%Y') AS sampledate, soil_master.id as soilID");
        $this->db->from('nabard_farmers_master');
        $this->db->join('soil_master',"soil_master.FARMER_ID=nabard_farmers_master.FARMER_ID",'left');
        $this->db->join('plot_master',"plot_master.FARMER_ID=nabard_farmers_master.FARMER_ID",'left');
        $this->db->where('nabard_farmers_master.FARMER_ID', $farmer_id);
        $this->db->group_by("soil_master.id");
        $this->db->order_by('soil_master.id',"DESC");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function get_reports($soilID)
    {
        $this->db->select("smrl.*");
        $this->db->from('soil_master_report_links smrl');
        $this->db->where('smrl.soil_master_id', $soilID);
        $this->db->order_by('smrl.link_order',"ASC");
        $query = $this->db->get();
        return $query->result_array();
    }
    /******* END **************/

    function get_crop_images($crop_id)
    {
        $this->db->select("*");
        $this->db->from('nabard_crop_health_monitoring_images');
        $this->db->where('crop_id', $crop_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function farmers_soil_values($farmer_id)
    {
        $this->db->select("*");
        $this->db->from('nabard_soil_test_results');
        $this->db->where('nabard_soil_test_results.FARMER_ID', $farmer_id);
        $this->db->where("nabard_soil_test_results.status = 1");
        $this->db->order_by('nabard_soil_test_results.soil_id',"DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_crops($farmer_id)
    {
        $this->db->select("*");
        $this->db->from('nabard_crop_health_monitoring');
        $this->db->where('nabard_crop_health_monitoring.FARMER_ID', $farmer_id);
        $this->db->group_by("nabard_crop_health_monitoring.year_month");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_crops_year($farmer_id)
    {
        $this->db->select("Distinct(LEFT(`year_month`,LOCATE('-',`year_month`) - 1)) as year");
        $this->db->from('nabard_crop_health_monitoring');
        $this->db->where('FARMER_ID', $farmer_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCrops_by_filter($params = array())
    {
        $year      = $params['search']['year'];       
        $farmer_id      = $params['search']['farmer_id'];
        $where          = '1=1';
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        if(!empty($year) AND $year!='undefined') { 
            $this->db->where('c.year_month LIKE("%'.$year.'-%")');   
        } 
       
        $this->db->select("c.*,cp.image,RIGHT(`year_month`,LOCATE('-',`year_month`) - 3) as month, LEFT(`year_month`,LOCATE('-',`year_month`) - 1) as year");
        $this->db->from('nabard_crop_health_monitoring c');
        $this->db->join('nabard_crop_health_monitoring_images cp',"cp.crop_id=c.crop_id",'left');
        $this->db->where($where);
        $this->db->where('c.FARMER_ID', $farmer_id);
        $this->db->where("c.status = 1");
        $this->db->group_by("c.crop_id");
        $this->db->order_by('c.year_month', 'ASC');
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        //echo "<br>---------------<br>";
        
      
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        }

        return $result; 
    }


    function get_crop_images_popup($crop_id,$month)
    {
        $this->db->select("*,RIGHT(nabard_crop_health_monitoring.`year_month`,LOCATE('-',nabard_crop_health_monitoring.`year_month`) - 3) as month, LEFT(nabard_crop_health_monitoring.`year_month`,LOCATE('-',nabard_crop_health_monitoring.`year_month`) - 1) as year");
        $this->db->from('nabard_crop_health_monitoring_images');
        $this->db->join('nabard_crop_health_monitoring',"nabard_crop_health_monitoring.crop_id=nabard_crop_health_monitoring_images.crop_id",'left');
        $this->db->where('nabard_crop_health_monitoring_images.crop_id', $crop_id);
        $this->db->where('nabard_crop_health_monitoring.year_month LIKE("%-'.$month.'%")');
        $query = $this->db->get();
        return $query->result_array();
    }

    function months_from_year($year,$farmer_id)
    {
        $this->db->select("Distinct(RIGHT(nabard_crop_health_monitoring.`year_month`,LOCATE('-',nabard_crop_health_monitoring.`year_month`) - 3)) as month_new");
        $this->db->from('nabard_crop_health_monitoring');
        $this->db->where('nabard_crop_health_monitoring.year_month LIKE("%'.$year.'-%")');
        $this->db->where('nabard_crop_health_monitoring.FARMER_ID', $farmer_id);
        $this->db->where('nabard_crop_health_monitoring.status', 1);   
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCrops_by_month($params = array())
    {
        $year      = $params['search']['year'];       
        $month     = $params['search']['month'];
        $farmer_id   = $params['search']['farmer_id'];
        $where          = '1=1';
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        if(!empty($year) AND $year!='undefined') { 
            $this->db->where('cp.year_month LIKE("%-'.$month.'%")');   
        } 
       
        $this->db->select("c.*,RIGHT(cp.`year_month`,LOCATE('-',cp.`year_month`) - 3) as month, LEFT(cp.`year_month`,LOCATE('-',cp.`year_month`) - 1) as year, cp.FARMER_ID");
        $this->db->from('nabard_crop_health_monitoring_images c');
        $this->db->join('nabard_crop_health_monitoring cp',"cp.crop_id=c.crop_id",'left');
        $this->db->where($where);
        $this->db->where('cp.year_month LIKE("%'.$year.'-%")');
        $this->db->where('cp.FARMER_ID', $farmer_id);
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        }

        return $result; 
    }

    function get_mobile_number($farmer_id)
    {
        $this->db->select("MOBILE_NO");
        $this->db->from('nabard_farmers_master');
        $this->db->where('FARMER_ID', $farmer_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function otp_verify($mobile,$farmer_id)
    {
        $this->db->select("otp_generated_on");
        $this->db->from('nabard_farmers_master');
        $this->db->where('MOBILE_NO', $mobile);
        $this->db->where('FARMER_ID', $farmer_id);
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function get_crop_health_monitoring_images($farmer_id,$year_id,$month_id)
    {
        $this->db->select("i.*");
        $this->db->from('nabard_crop_health_monitoring c');
        $this->db->join('nabard_crop_health_monitoring_images i',"c.crop_id = i.crop_id",'left');
        $this->db->where('c.FARMER_ID', $farmer_id);
        $this->db->where('c.year_month LIKE("%'.$year_id."-".$month_id.'%")');

        $query = $this->db->get();
        return $query->result_array();


    }

    function get_farmername_by_id($farmer_id)
    {
        $this->db->select("concat(FIRST_NAME, ' ', LAST_NAME) as farmer_name");
        $this->db->from('nabard_farmers_master');
        $this->db->where('FARMER_ID', $farmer_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_crophealth_monitoringImages($params = array())
    {
        $year      = $params['search']['year'];       
        $month     = $params['search']['month'];
        $farmer_id = $params['search']['farmer_id'];
        $where     = '1=1';
        
        //set start and limit
        /*if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }*/
        
        // if(!empty($year) AND $year!='undefined') { 
        //     $this->db->where('cp.year_month LIKE("%-'.$month.'%")');   
        // } 
       
        $this->db->select("c.*,RIGHT(cp.`year_month`,LOCATE('-',cp.`year_month`) - 3) as month, LEFT(cp.`year_month`,LOCATE('-',cp.`year_month`) - 1) as year, cp.FARMER_ID");
        $this->db->from('nabard_crop_health_monitoring_images c');
        $this->db->join('nabard_crop_health_monitoring cp',"cp.crop_id=c.crop_id",'left');
        $this->db->where($where);
        $this->db->where('cp.year_month LIKE("%'.$year.'-%")');
        $this->db->where('cp.FARMER_ID', $farmer_id);
        $this->db->where('cp.status', 1);
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        }

        return $result; 
    }

    function get_crophealth_image_by_id($crop_id)
    {
        // $this->db->select("*");
        // $this->db->from('nabard_crop_health_monitoring_images');
        // $this->db->where('id', $crop_id);
        // $query = $this->db->get();
        // return $query->result_array();

        $this->db->select("c.*,RIGHT(cp.`year_month`,LOCATE('-',cp.`year_month`) - 3) as month, LEFT(cp.`year_month`,LOCATE('-',cp.`year_month`) - 1) as year, cp.FARMER_ID");
        $this->db->from('nabard_crop_health_monitoring_images c');
        $this->db->join('nabard_crop_health_monitoring cp',"cp.crop_id=c.crop_id",'left');
        $this->db->where('c.id', $crop_id);

        $query = $this->db->get();
        return $query->result_array();

    }

    function get_test_values($test_id)
    {
        $this->db->select("*");
        $this->db->from('test_tran_tail');
        $this->db->join('test_template',"test_template.parameter_ID=test_tran_tail.parameter_ID",'left');
        $this->db->where('test_tran_ID', $test_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}