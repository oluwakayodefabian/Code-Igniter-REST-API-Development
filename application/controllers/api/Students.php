<?php

use phpDocumentor\Reflection\Types\Parent_;

defined("BASEPATH") or exit("No direct script access allowed");

require_once APPPATH . 'libraries/REST_Controller.php';

class Students extends REST_Controller
{
    public $data        = NULL;
    public $name        = NULL;
    public $email       = NULL;
    public $phone_no    = NULL;
    public $course      = NULL;
    function __construct()
    {
        parent::__construct();
        $this->load->model(['api/student_model']);
        $this->load->library('form_validation');;
    }
    //GET: project url/index.php/controller_name
    public function index_get()
    {
        $students_data = $this->student_model->get_all_students();
        // Check if there is any data
        if (count($students_data) > 0) {
            $this->response(array('status' => 1, 'message' => 'students found', 'data' => $students_data), parent::HTTP_OK); // returns data(response) in json format
        } else {
            $this->response(array('status' => 0, 'message' => 'students data not found', 'data' => $students_data), parent::HTTP_NOT_FOUND);
        }
    }
    public function index_post()
    {
        $student_data = $this->security->xss_clean($this->input->post());
        /**
         * the set_data function is actually used to validate
         * arrays that does not originate from the $_POST data, 
         * so you can decide not to use it on $_POST
         */
        $this->form_validation->set_data($student_data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone_no', 'Phone_no', 'required|numeric');
        $this->form_validation->set_rules('course', 'Course', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Form Validation Errors
            $this->set_response([
                'status' => FALSE,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            ], parent::HTTP_NOT_FOUND);
        } else {
            $student_data = [
                'name'          => $this->input->post('name'),
                'email'         => $this->input->post('email'),
                'phone_no'      => $this->input->post('phone_no'),
                'course'        => $this->input->post('course'),
            ];
            if ($this->student_model->insert_student($student_data)) {
                $this->set_response(['status' => 1, 'message' => 'Student registered successfully'], parent::HTTP_OK);
            }
        }
    }
    public function index_put()
    {
        $this->data = json_decode(file_get_contents("php://input"));
        if (!isset($this->data->id) && !isset($this->data->name) && !isset($this->data->email) && !isset($this->data->phone_no) && !isset($this->data->course)) {
            $this->response(array('status' => 0, 'message' => 'All fields are required'), parent::HTTP_NOT_FOUND);
        } else {
            $student_id = $this->data->id;
            $this->data = [
                'name'      => $this->data->name,
                'email'     => $this->data->email,
                'phone_no'  => $this->data->phone_no,
                'course'    => $this->data->course
            ];
            if ($this->student_model->update_student($student_id, $this->data)) {
                $this->response(array('status' => 1, 'message' => 'student info was updated successful'), REST_Controller::HTTP_OK);
            } else {
                $this->response(array('status' => 0, 'message' => 'Registration Failed'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    public function index_delete()
    {
        $this->data = json_decode(file_get_contents("php://input"));
        $student_id = $this->security->xss_clean($this->data->id);
        if ($this->student_model->delete_student($student_id)) {
            $this->set_response(['status' => 1, 'message' => 'student deleted successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->set_response(['status' => 0, 'message' => 'Failed to delete students'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
