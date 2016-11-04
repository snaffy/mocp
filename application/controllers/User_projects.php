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

    public function task()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('head.php');
        $this->load->view('ProjectsView/navigation.php');
        $this->load->view('ProjectsView/ganttChart.php');
        $this->load->view('footer.php');
        var_dump($this->input->post());
        $newTask = $this->input->post('addTaskInput');
        $newTaskDecode = json_decode($newTask,false,512,JSON_BIGINT_AS_STRING);
        $task = $newTaskDecode->{'data'};
        $links = $newTaskDecode->{'links'};
        var_dump($task);
        var_dump($links);
        $this->load->model('User_project');
        $this->User_project->add_task($task,$links);

//        $this->load->helper('url');
//        $this->load->view('ProjectsView/gantttest.php');
    }
    
    
}