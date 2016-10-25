<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogReg extends CI_Controller {
	
	public function login()
	{
		$this->load->helper('url');
        $this->load->view('LogRegView/header');
		$this->load->view('LogRegView/login.html');
	}

	public function register()
	{
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        if ($this->form_validation->run('signup') === FALSE)
        {
            $this->load->view('LogRegView/header');
            $this->load->view('LogRegView/register', $data);
        }else {
            echo $this->input->post('login');
            echo $this->input->post('password');
        }

	}

    public function added()
    {
        echo $this->input->post();
    }
}
