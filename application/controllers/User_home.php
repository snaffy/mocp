<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 27.10.2016
 * Time: 03:09
 */

class User_home extends My_controller
{
    public function home()
    {
        $this->load->helper('url');
        $this->load->view('HomeView/userHomeView.php');
    }
}
