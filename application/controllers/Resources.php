<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 27.11.2016
 * Time: 03:08
 */
class Resources extends My_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Project_model');
        $this->load->model('User_model');
    }

    public function projects_data()
    {
        $some_data=  json_encode($this->Project_model->get_user_projecT($this->userID));
        print_r($some_data) ;
    }

    public function invitations_data()
    {
        $invitations = json_encode($this->Project_model->check_notification($this->userID)) ;
        print_r($invitations);
    }

    public function user_in_project_data()
    {
       $idProject = $this->session->get_userdata()['projectID'];
       $userData = $this->Project_model->get_user_data_by_project($idProject);
       print_r(json_encode($userData));
    }
}