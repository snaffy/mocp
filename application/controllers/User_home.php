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
        $this->load->model('User_project');
        $some_data=  json_encode($this->User_project->get_user_projecT($this->userID));
        $data = array (
            'userProjectData' => $some_data
        );
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('HomeView/userHeader.php');
        $this->load->view('HomeView/userCreateProject.php',$data);
        if ($this->input->post('createProject') != null)
        {
            $this->load->model('User_project');
            $projectID =  $this->User_project->create_project();
            $ucID = $this->em->find(\Entity\User::class,$this->userID);
            $rcID = $this->em->find(\Entity\UserRole::class,1);
            $this->User_project->add_user_to_project($ucID,$projectID,$rcID);
        }

    }

    public function profile()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $user = $this->em->find(\Entity\User::class, $this->userID);
            var_dump($this->input->post());
        if ($this->input->post('submitBasicData') != null) {
            if ($this->form_validation->run('basicField') == true) {
                echo "Zapis basic field";
                $this->load->model('User_model');
                $this->User_model->update_user_basic_field($this->userID);
                redirect('profile');
            }
        } elseif ($this->input->post('submitLoginData') != null) {
            if ($this->form_validation->run('passwordUpdate')) {
                echo "Hsła poprawne";
                $this->form_validation->set_rules('currentPassword', 'hasło', 'callback_has_match[' . $user->getPassword() . ']', array('has_match' =>
                    'Aktualne {field} jest niepoprawne.'));
                if ($this->form_validation->run('currentPassword') == true) {
                    $this->load->model('User_model');
                    $this->User_model->update_user_password($this->userID);
                    $this->session->set_flashdata('success_msg', 'success');
                    redirect('profile');
                }
            }
        }elseif(($this->input->post('submitChangeLogin') != null))
        {
            $this->form_validation->set_rules('login','Login','required|min_length[4]');
            if ($this->form_validation->run('login') == true)
            {
                $this->load->model('User_model');
                $this->User_model->update_user_login($this->userID);
                redirect('profile');
            }
        }

        $data['basicUserData'] = array('name' => $user->getName(), 'surname' => $user->getSurname(),
            'email' => $user->getEmail(), 'phoneNumber' => $user->getPhoneNumber(),'login' =>$user->getLogin());
        $this->load->view('HomeView/userHeader.php');
        $this->load->view('HomeView/userProfileContentView.php', $data);
        $this->load->view('HomeView/userFooter.php');
    }
    
    public function test()
    {
        $this->load->helper('url');
        $this->load->view('HomeView/userHeader.php');
        $this->load->view('HomeView/test.php');
        $this->load->view('HomeView/userFooter.php');
    }
    public function has_match($password, $hasshedPasswrd)
    {
        return password_verify($password, $hasshedPasswrd);
    }
    
    public function logout()
    {
        $this->load->helper('url');
        $this->session->unset_userdata('userID');
        $this->session->sess_destroy();
        redirect('login');
    }
}
