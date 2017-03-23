<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 02.01.2017
 * Time: 02:01
 */
class My_Controller extends CI_Controller
{
    protected $invitations;
    protected $userID;
    protected $em;
    function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
        /** @var $em Doctrine\ORM\EntityManager */
        $em = $this->doctrine->em;
        $this->em = $em;

        $this->load->library('session');
        $this->userID = $this->session->get_userdata()['userID'];
        $this->load->helper('url');

        if($this->userID == null)
        {
            redirect('/login', 'refresh');
        }

        $this->load->model('Project_model');
        if ($this->Project_model->check_notification($this->userID) == null)
        {
            $this->invitations = false;
        }else $this->invitations = true;
    }
}