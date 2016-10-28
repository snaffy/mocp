<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 27.10.2016
 * Time: 03:09
 */
class User_home extends My_controller
{

    /**
     * User_home constructor.
     */
    private $userID;
    public function __construct()
    {
        parent:: __construct();
        // $this->output->enable_profiler(TRUE);
        $this->userID = $this->session->get_userdata()['userID'];
    }

    public function home()
    {
        $this->load->helper('url');
        $this->load->view('HomeView/userHeader.php');
    }

    public function profile()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        //  if($this->input->get('submit') == "Anuluj") redirect('profile');
        if ($this->form_validation->run('basicField') == FALSE) {
            // $this->load->model('User_model');
            // $data = $this->User_model->get_user_data($userID);
            $user = $this->em->find(\Entity\User::class, $this->userID);
            $data['basicUserData'] = array('name' => $user->getName(), 'surname' => $user->getSurname(),
                'email' => $user->getEmail(), 'phoneNumber' => $user->getPhoneNumber());
            $this->load->view('HomeView/userHeader.php');
            $this->load->view('HomeView/userProfileContentView.php', $data);
            $this->load->view('HomeView/userFooter.php');
        } else {
            $this->load->model('User_model');
            $this->User_model->update_user_basic_field($this->userID);
            redirect('profile');
        }
    }

    public function logout()
    {
        $this->load->helper('url');
        $this->session->unset_userdata('userID');
        $this->session->sess_destroy();
        redirect('login');
    }
}
