<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/Restserver/REST_Controller.php';

class data_controller extends \Restserver\REST_Controller{

    public function index_get()
    {
     
        $json['data']  =  $this->load->model('User_project');
//        $this->User_project->add_task($task,$links);
        $tmp = $this->User_project->get_task_as_json();
       // var_dump($tmp);
        $this->response($tmp);

    }

    public function index_post()
    {
        $this->post("http://localhost:449/mocp/project/task"); // POST param
        echo "test";
    }


}