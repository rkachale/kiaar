<?php
/**
 * Created by Arigel Team.
 * User: Arigel
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.arigel.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all_category()
    {
        $this->db->select("*");
        $this->db->from('category');
        $this->db->order_by('category_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_category_detail($id)
    {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function category_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }
        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id!=null) // update
        {
            $this->db->where('category_id',$id);
            $this->db->update('category',$data);
        }
        else    //add
        {
            //$data['created_date']=time();
            $this->db->insert('category',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"category"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"category"));
            }
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
    function get_search_category($data)
    {
        $this->db->select("*");
        $this->db->from('category');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('category','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

}
