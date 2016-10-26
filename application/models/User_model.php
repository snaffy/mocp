<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 26.10.2016
 * Time: 20:27
 */

class User_model extends CI_Model
{
    protected $em;
    public function __construct()
    {
        $this->load->library('doctrine');
        /** @var $em Doctrine\ORM\EntityManager */
        $em = $this->doctrine->em;
        $this->em = $em;
        parent::__construct();
    }

    public function register_user()
    {
        $login =  $this->input->post('login');
        $pass = $this->input->post('password');
        $usr = new Entity\User;
        $usr->setPassword("$login");
        $usr->setLogin("$pass");
        $this->em->persist($usr);
        $this->em->flush();
    }
    
    public function test()
    {
        echo "test";
    }
}