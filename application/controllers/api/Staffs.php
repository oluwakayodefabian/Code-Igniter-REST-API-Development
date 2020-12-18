<?php

date_default_timezone_set('Africa/Lagos');

defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Staffs extends REST_Controller
{
    public $data = [];
    public $staff_id = NULL;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['api/staff_model']);
        $this->load->library(['form_validation']);
    }
    public function index_post()
    {
        $this->data = $this->security->xss_clean($this->input->post());
        $this->form_validation->set_data($this->data);
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('surname', 'Surname', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone_no', 'Phone Number', 'required|numeric');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('course_being_taught', 'Course', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->set_response([
                'status'     => FALSE,
                'error'      => $this->form_validation->error_array(),
                'message'    => validation_errors()
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->data = [
                'first_name'        => $this->input->post('first_name'),
                'surname'           => $this->input->post('surname'),
                'email'             => $this->input->post('email'),
                'phone_no'          => $this->input->post('phone_no'),
                'role'              => $this->input->post('role'),
                'course_being_taught' => $this->input->post('course_being_taught')
            ];
            if ($this->staff_model->insert_staff($this->data)) {
                $this->set_response(['status' => 1, 'Staff Added Successfully'], REST_Controller::HTTP_OK);
            } else {
                $this->set_response(['status' => FALSE, 'Operation failed'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function index_get()
    {
        $this->data = $this->staff_model->get_all_staffs();
        if (!$this->data) {
            throw new Exception("Error Processing Request");
        } else {
            if (count($this->data) > 0) {
                $this->set_response(['status' => 1, 'Staff\'s data retrieved Successfully', 'data' => $this->data], REST_Controller::HTTP_OK);
            } else {
                $this->set_response(['status' => FALSE, 'Operation failed'], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
    public function index_put()
    {
        $this->data = json_decode(file_get_contents('php://input'));
        if (!isset($this->data->id) && !isset($this->data->first_name) && !isset($this->data->surname) && !isset($this->data->email) && !isset($this->data->phone_no) && !isset($this->data->role) && !isset($this->data->course_being_taught)) {
            $this->set_response(['status' => FALSE, "message" => 'All fields are required'], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->staff_id = $this->data->id;
            $this->data = [
                'first_name' => $this->data->first_name,
                'surname'    => $this->data->surname,
                'email'      => $this->data->email,
                'phone_no'   => $this->data->phone_no,
                'role'       => $this->data->role,
                'course_being_taught' => $this->data->course_being_taught,
            ];
            if ($this->staff_model->update_staff_info($this->staff_id, $this->data)) {
                $this->set_response(['status' => 1, 'message' => 'Staff Info Updated Successfully'], REST_Controller::HTTP_OK);
            } else {
                $this->response(array('status' => 0, 'message' => 'Registration Failed'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function index_delete()
    {
        $this->data = json_decode(file_get_contents('php://input'));
        $this->staff_id = $this->security->xss_clean($this->data->id);
        if ($this->staff_model->delete_staff($this->staff_id)) {
            $this->set_response(['status' => 1, 'message' => 'Staff Info Deleted Successfully'], parent::HTTP_OK);
        } else {
            $this->set_response(array('status' => 0, 'message' => 'Failed to delete staff'), REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
/** End of file Staffs.php **/
