<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {
    private $query;
    private $result;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function insert_student($data = [])
    {
        $this->query = $this->db->insert('students', $data);
        return $this->db->insert_id();
    }
    public function get_all_students()
    {
        $this->query = $this->db->get('students');
        $this->result = $this->query->result();
        return $this->result;
    }
    public function update_student($student_id, $data)
    {
        $this->query = $this->db->where("id", $student_id)->update('students', $data);
        return 
        $this->db->affected_rows();
    }
    public function delete_student(int $student_id)
    {
        $this->db->delete('students', ['id' => $student_id]);
        return $this->db->affected_rows();
    }

}

/* End of file Student_model.php */
