<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

   function view_data(){
        
            $query=$this->db->query("SELECT *,  ud.public as public
                                 FROM galleries ud 
                                
                                 LEFT JOIN galleries_type as gal 
                                 ON ud.type_id = gal.id 
                                 ORDER BY ud.date DESC");
            return $query->result_array();
     
    }
  function get_galdata($id){
      

          $this->db->select('*');
        $this->db->from('galleries');
        $this->db->where('g_id', $id);
        $this->db->where('public !=', '-1');
    
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];


    }

     function get_data_image($id){
        $query=$this->db->query("SELECT *
                                 FROM galleries ud 
                                 RIGHT JOIN photos as photo
                                 ON ud.g_id = photo.g_id 
                                 WHERE ud.g_id = $id");
        return $query->result_array();
    }

    function get_galtype()
    {
        $this->db->select("*");
        $this->db->from('galleries_type');
         $this->db->where('public','1');
        $this->db->order_by('id','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
 function get_galtype_detail($id)
    {
        $this->db->select('*');
        $this->db->from('galleries_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
 function get_gallerytype()
    {
        $this->db->select("*");
        $this->db->from('institute_galleries_type');
        $this->db->join('galleries_type',"FIND_IN_SET(galleries_type.id,institute_galleries_type.type_id)",'left');
        $this->db->order_by('institute_galleries_type.ig_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'video_management_new';
        
        $res                        = $this->db->insert($table, $data);
        
        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'video_management_new';
        
        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata);

        if($update)
        {
            $response['status']     = 'success';
            $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }

    function _delete($col, $val) {
            
        $update['public']       = -1;
        $update['modified_on']  = date('Y-m-d H:i:s');
        $update['modified_by']  = $this->session->userdata('user_id');

        $table      = 'video_management_new';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function upload_image($inputdata,$images)
    {  
      $this->db->insert('galleries', $inputdata); 
      $insert_id = $this->db->insert_id();


      // $this->db->where('g_id', $insert_id);
      // $this->db->update('galleries', array('featured_img' => $fileNamefeatured));

      if(!empty($images))
      {
        foreach($images as $file){
          $file_data = array(
          'image' => $file['image'],
          'image_name' => $file['name'],
          'image_description' => $file['description'],
          'g_id' => $insert_id
          );
          $this->db->insert('photos', $file_data);
        }
      }

      if($insert_id)
        {
            $response['status']     = 'success';
            $response['id']         = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;

    }

     function update_upload_image($user_id,$inputdata,$images)
    {
        $this->db->where('g_id', $user_id);
        $update  = $this->db->update('galleries', $inputdata);

        if(!empty($images)){
            foreach($images as $file){
                $file_data  =    array(
                                      'image' => $file['image'],
                                      'image_name' => $file['name'],
                                      'image_description' => $file['description'],
                                      'g_id' => $user_id
                                    );
                $this->db->insert('photos', $file_data);
            }
        }


   if($update)
        {
            $response['status']     = 'success';
         //   $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
       return $response;

    }


}