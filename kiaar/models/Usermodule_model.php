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
class Usermodule_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function view_usermodule()
    {
        $this->db->select("*");
        $this->db->from('user_module');
        $this->db->order_by('module_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_usermodule($id)
    {
        $this->db->select('*');
        $this->db->from('user_module');
        $this->db->where('module_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function add_usermodule($data,$id=null)
    {
        $this->db->trans_start();

        if($id!=null) // update
        {
            $this->db->where('module_id',$id);
            $this->db->update('user_module',$data);
        }
        else    //add
        {
            $this->db->insert('user_module',$data);
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

}