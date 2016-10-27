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
        $hashed_password = password_hash($pass,PASSWORD_BCRYPT);
        $usr->setPassword($hashed_password);
        $usr->setLogin($login);
        $this->em->persist($usr);
        $this->em->flush();
    }

    public function check_user_existence()
    {
        $login =  $this->input->post('login');
        $pass = $this->input->post('password');
        $qbResult = $this->em->createQueryBuilder()
            ->select('u')
            ->from(\Entity\User::class,'u')
            ->where('u.login =:l')
            ->setParameter('l',$login)
            ->getQuery()->getOneOrNullResult();
          //  var_dump($qbResult);
        if ($qbResult != null)
        {
            $passHashed = $qbResult->getPassword();
           if(password_verify($pass,$passHashed)) 
               return $qbResult; 
        }
            return null ; 
        
        
    }
    
    public function phash()
    {
//        $pass = $this->input->post('password');
//       // $hashed_password = crypt($pass);
//        $hp = 
//        var_dump($hp);
    }
}