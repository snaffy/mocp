<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 27.10.2016
 * Time: 03:09
 */
class User_home extends My_Controller
{
    public function __construct()
    {
        parent:: __construct();
        if($this->userID == null)
        {
            $this->load->helper('url');
            redirect('/login');
        }
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function home()
    {
        $this->load->model('Project_model');
        if ($this->input->post('createEditSubmit') == 'Utwórz') {
            $userID = $this->em->find(\Entity\User::class, $this->userID);
            $roleID = $this->em->find(\Entity\UserRole::class, 1);
            $projectCost = floatval($this->input->post('projectCost')) ;
            $pName = $this->input->post('projectName');
            $pDescrition = $this->input->post('projectDescription');
            $this->Project_model->create_project($userID, $roleID,$pName,$pDescrition,$projectCost);
            redirect('home', 'refresh');
        } elseif ($this->input->post('createEditSubmit') == 'Edytuj') {
            $pName = $this->input->post('projectName');
            $pDescrition = $this->input->post('projectDescription');
            $projecIDToEdit = $this->input->post('projectID');
            $projectCost = floatval($this->input->post('projectCost')) ;
            $result = $this->Project_model->check_possibility_to_edit_project($this->userID, $projecIDToEdit);
            if ($result) {
                $this->Project_model->edit_project($pName, $pDescrition,$projectCost, $projecIDToEdit);
                redirect('home', 'refresh');
            }else {$data['status'] = 'Brak uprawnień dla zadanej operacji';}
        } elseif ($this->input->post('selectedProjectIDToRem') != null) {
            $project = $this->input->post('selectedProjectIDToRem');
//            var_dump($this->userID);
            $result = $this->Project_model->check_possibility_to_edit_project($this->userID, $project);
            if($result)
            {
                $this->Project_model->remove_project($project);
                redirect('home', 'refresh');
            }else {
               $data['status'] = 'Brak uprawnień dla zadanej operacji';
                $this->Project_model->leave_project($this->userID, $project);
//                redirect('home', 'refresh');
            }

        }
        $this->load->view('header/project_h.php');
        $this->load->view('home/create_project.php',$data);
        if ($this->invitations == true)
        {
            $this->load->view('invitationNotify.php');
        }
        $this->load->view('footer.php');
    }

    public function activeinv()
    {
        $this->load->model('Project_model');
        $getInvDec = $this->input->post('operation');
        if ($getInvDec == "accept") {
            $idUserInProject = $this->input->post('idUserInProject');
            $idInvitation = $this->input->post('idInvitation');
            $this->Project_model->add_user_to_project_by_invitation($idInvitation, $idUserInProject);
        } elseif ($getInvDec == "reject")
        {
            $idInvitation = $this->input->post('idInvitation');
            $this->Project_model->reject_invitation_to_project($idInvitation);
        }
        $this->load->view('header/project_h.php');
        $this->load->view('home/active_inv.php');
        $this->load->view('footer.php');
    }

    public function profile()
    {
        $this->load->library('form_validation');
        $user = $this->em->find(\Entity\User::class, $this->userID);
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
        } elseif (($this->input->post('submitChangeLogin') != null)) {
            $this->form_validation->set_rules('login', 'Login', 'required|min_length[4]');
            if ($this->form_validation->run('login') == true) {
                $this->load->model('User_model');
                $this->User_model->update_user_login($this->userID);
                redirect('profile');
            }
        }

        $data['basicUserData'] = array('name' => $user->getName(), 'surname' => $user->getSurname(),
            'email' => $user->getEmail(), 'phoneNumber' => $user->getPhoneNumber(), 'login' => $user->getLogin());
        $this->load->view('header/project_h.php');
        $this->load->view('home/profile_content.php', $data);
        $this->load->view('footer.php');
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
