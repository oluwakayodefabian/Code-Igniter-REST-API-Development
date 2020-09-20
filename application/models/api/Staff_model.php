<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model 
{
    private $query = NULL;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function insert_staff(array $data = [])
    {
        $this->query = $this->db->insert('staffs', $data);
        return $this->db->insert_id();
    }
    public function get_all_staffs(){
        $this->query = $this->db->get('staffs');
        return $this->query->result();
    }
    public function update_staff_info($id, $data)
    {
        $this->query = $this->db->where(['id' => $id])->update('staffs', $data);
        return $this->db->affected_rows();
    }
    public function delete_staff($id)
    {
        $this->query = $this->db->delete('staffs', ['id' => $id]);
        return $this->db->affected_rows();
        
    }
}

/* End of file Staff_model.php */
