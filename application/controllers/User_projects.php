<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 02.11.2016
 * Time: 00:40
 */

class User_projects extends My_controller
{
    private $userID;
    public function __construct()
    {
        parent:: __construct();
        // $this->output->enable_profiler(TRUE);
        $this->userID = $this->session->get_userdata()['userID'];
    }
    public function project_overview()
    {
        echo "everwiew"; 
        $this->load->helper('url');
        var_dump($this->input->post());
        $this->load->view('head.php');
        $this->load->view('ProjectsView/navigation.php');
        $this->load->view('footer.php');
    }

    public function data()
    {
        $this->load->helper('url');
        $this->load->model('User_project');
        echo $this->User_project->get_task_as_json();

    }

    public function task()
    {
        $this->load->helper('url');
        $this->load->helper('form');

        $newTask = $this->input->post('addTaskInput');
        $newTaskDecode = json_decode($newTask,false,512,JSON_BIGINT_AS_STRING);
        var_dump($this->input->post());
        $task = $newTaskDecode->{'data'};
        $links = $newTaskDecode->{'links'};
        var_dump($task,$links);
        $this->load->model('User_project');
//        $this->User_project->add_task($task,$links);
        $data['task_data'] = $this->User_project->get_task_as_json();
        $data['task_data'] = json_encode($data['task_data']);

       var_dump( $data['task_data']) ;
        $this->load->view('head.php');
        $this->load->view('ProjectsView/navigation.php');
      //  $this->load->view('data.php',$data);
        $this->load->view('ProjectsView/ganttChart.php',$data);
        $this->load->view('footer.php');
      //  var_dump($data);
    }
    
    
}