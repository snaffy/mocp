<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_reg extends CI_Controller {

    public function login()
	{
	$this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('header/log_reg_h');
        $this->load->view('loginRegister/login.php');
        $formSubmit = $this->input->post('submit');
        if($formSubmit == 'Zaloguj')
        {
            $this->load->model('User_model');
            $tmp = $this->User_model->check_user_existence();
            if ($tmp != null)
            {
                $this->load->library('session');
                $this->session->set_userdata('userID', $tmp->getIdUser());
                redirect('/home');
            } else
            {
                $this->session->set_flashdata('message', 'Podano błędne dane lub docelowy użytkownik nie istnieje w systemie !');
                redirect(current_url());
            }
        }
	}

	public function register(){
		
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->form_validation->run('signup') == false)
        {
            $this->load->view('header/log_reg_h');
            $this->load->view('loginRegister/register');
        }else {
            $this->load->model('User_model');
            $login = $this->input->post('login');
            $pass = $this->input->post('password');
           if ($this->User_model->register_user($login,$pass)== true)
           {
               $tmp = $this->User_model->check_user_existence();
               $this->session->set_userdata('userID', $tmp->getIdUser());
               redirect('/home');
           }else
           {
               $this->session->set_flashdata('message', 'Użytkownik o podanym loginie już istnieje.');
               redirect(current_url());
           }
        }
	}
    
    
}
