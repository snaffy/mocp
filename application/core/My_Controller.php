<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 26.10.2016
 * Time: 04:42
 */

class My_controller extends CI_Controller
{
    protected $em;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
        /** @var $em Doctrine\ORM\EntityManager */
        $em = $this->doctrine->em;
        $this->em = $em;
    }
}