<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_reg extends My_controller {

    public function login()
	{
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('LogRegView/header');
        $this->load->view('LogRegView/login.php');
        $formSubmit = $this->input->post('submit');
        if($formSubmit == 'loginSubmit')
        {
            $this->load->model('User_model');
            $tmp = $this->User_model->check_user_existence();
            if ($tmp != null)
            {
                $this->load->library('session');
                $this->session->set_userdata('userID', $tmp->getIdUser());
            }
        }else
        {
             
        }

	}

	public function register()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->form_validation->run('signup') === FALSE)
        {
            $this->load->view('LogRegView/header');
            $this->load->view('LogRegView/register');
        }else {
           $this->load->model('User_model');
           $this->User_model->register_user();
        }
	}
    
    
}
