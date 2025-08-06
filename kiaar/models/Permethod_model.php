<?php
/**
 * Created by kiaar Team.
 * User: kiaar
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.kiaar.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Permethod_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function view_permethod()
    {
        $this->db->select("*");
        $this->db->from('user_permission_method');
        $this->db->join('user_module',"user_module.module_id=user_permission_method.pm_module_id","left");
        $this->db->order_by('user_permission_method.pm_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_permethod($id)
    {
        $this->db->select('*');
        $this->db->from('user_permission_method');
        $this->db->where('pm_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function add_permethod($data,$id=null)
    {
        $this->db->trans_start();

        if($id!=null) // update
        {
            $this->db->where('pm_id',$id);
            $this->db->update('user_permission_method',$data);
        }
        else    //add
        {
            $this->db->insert('user_permission_method',$data);
            $id=$this->db->insert_id();

        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function getControllerMethods($controllername)
    { 
        $this->load->library('controllerlist');
        $controller = $controllername;
        $this->controllerlist->getControllers($controller);
        $methods = get_class_methods( str_replace( '.php', '', $controller ) );
        return $methods;
    }

}