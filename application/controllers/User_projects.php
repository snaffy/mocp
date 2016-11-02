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
    public function project()
    {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        var_dump($this->input->post());
        $this->load->view('HomeView/userHeader.php');
        $this->load->view('ProjectsView/project.php');
        $this->load->view('HomeView/userFooter.php');


    }
}