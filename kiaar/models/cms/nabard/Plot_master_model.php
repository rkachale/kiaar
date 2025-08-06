<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plot_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_plot_master_list($conditions=[])
    {
        $this->db->select('e.*,n.FARMER_ID,n.FIRST_NAME,n.MIDDLE_NAME,n.LAST_NAME');
        $this->db->from('plot_master e');
        $this->db->join('nabard_farmers_master n',"n.FARMER_ID=e.FARMER_ID","left");
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('e.id', 'DESC');
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        return $query->result_array();
    }

    function manage_plot_master($data=[], $id='')
    {  
        if($id)
        {       
            $update['FARMER_ID']                = $this->input->post('farmer_id');
            $update['survey_no']                = $this->input->post('survey_no');
            $update['plot_no']                  = $this->input->post('plot_no');
            $update['area']                     = $this->input->post('plot_area');
            $update['future_crop']              = $this->input->post('future_crop');
            $update['soil_type']                = $this->input->post('soil_type');
            $update['status']                   = $this->input->post('status');
            $update['modified_on']              = date('Y-m-d H:i:s');
            $update['modified_by']              = $this->session->userdata('user_id');

            $this->db->where('id', $id);
            $this->db->update('plot_master', $update);                

            if($this->db->affected_rows() > 0)
            {
                $return = ['error' => 0, 'message' => 'Data successfully updated'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to update Data'];
            }
        }
        else
        {   
            $insert['FARMER_ID']                = $this->input->post('farmer_id');
            $insert['survey_no']                = $this->input->post('survey_no');
            $insert['plot_no']                  = $this->input->post('plot_no');
            $insert['area']                     = $this->input->post('plot_area');
            $insert['future_crop']              = $this->input->post('future_crop');
            $insert['soil_type']                = $this->input->post('soil_type');
            $insert['status']                   = $this->input->post('status');
            $insert['created_on']               = date('Y-m-d H:i:s');
            $insert['created_by']               = $this->session->userdata('user_id');
            $insert['modified_on']              = date('Y-m-d H:i:s');
            $insert['modified_by']              = $this->session->userdata('user_id');
            // echo "<pre>=";print_r($insert);
            $this->db->insert('plot_master', $insert);
            $insert_id = $this->db->insert_id(); 
            // echo "<pre>--";print_r($insert_id);exit;

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Data successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Data'];
            }
        }
        return $return;
    }

    function _delete($col, $val) 
    {
        $table      = 'plot_master';
        $this->db->where($col, $val);
        $res        = $this->db->delete($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

}