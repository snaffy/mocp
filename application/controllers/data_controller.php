<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/Restserver/REST_Controller.php';

class data_controller extends \Restserver\REST_Controller{

    public function __construct($config="rest")
    {
        parent::__construct($config);

    }
//
//    public function index_get()
//    {
//        $this->load->model('User_project');
//        $tmp = $this->User_project->get_task_as_json();
//        $this->response($tmp);
//        var_dump($this->input->post());
//    }


    public function index_post()
    {
        $tmp = $this->post("task"); 
        $this->load->model('User_project');
        $tmp2 = $this->User_project->get_to_test($tmp);

    }


}