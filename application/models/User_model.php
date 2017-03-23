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
// TODO przeniesc dane pobierane bezposrednio z widoku->model do widok->kont->model 
    public function __construct()
    {
        $this->load->library('doctrine');
        /** @var $em Doctrine\ORM\EntityManager */
        $em = $this->doctrine->em;
        $this->em = $em;
        parent::__construct();
    }

    public function register_user($login,$pass)
    {
        $usrExist = $this->em->getRepository(\Entity\User::class)->findBy(array('login' => $login));
        if($usrExist == null)
        {
            $usr = new Entity\User;
            $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
            $usr->setPassword($hashed_password);
            $usr->setLogin($login);
            $this->em->persist($usr);
            $this->em->flush();
            return true;
        }return false;
    }

    public function update_user_basic_field($idUser)
    {
        $data = $this->input->post();
        array_pop($data);
        $data = array_filter($data);
        if( !empty($data))
        {
            $datafields = array_keys($data);
            $insert_values = array_values($data);
            for ($i = 0; $i < count($datafields); $i++) {
                $temp[] = "u." . $datafields[$i] . ' = ' . "'" . $insert_values[$i] . "'";
            }

            $bdI = implode(',', $temp);
            $sql = "UPDATE Entity\User u SET " . $bdI . " WHERE u.idUser = $idUser";
            $this->em->createQuery($sql)->execute();
        }
    }
    public function update_user_password($idUser)
    {
        $pass = $this->input->post('password');
        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
        $q =$this->em->createQueryBuilder()
            ->update(\Entity\User::class,'u')
            ->set('u.password','?1')
            ->where('u.idUser = :id')
            ->setParameter(1,$hashed_password)
            ->setParameter('id',$idUser)
            ->getQuery();
        $q->execute();
    }

    public function update_user_login($idUser)
    {
        $newLogin = $this->input->post('login');
        $q =$this->em->createQueryBuilder()
            ->select('u')
            ->from(\Entity\User::class,'u')
            ->where('u.login = :login')
            ->setParameter('login',$newLogin)
            ->getQuery()
            ->getOneOrNullResult();

        if($q == null)
        {
            $q =$this->em->createQueryBuilder()
                ->update(\Entity\User::class,'u')
                ->set('u.login',':login')
                ->where('u.idUser = :id')
                ->setParameter('login',$newLogin)
                ->setParameter('id',$idUser)
                ->getQuery();
            $q->execute();
        }
    }
    public function check_user_existence()
    {
        $login = $this->input->post('login');
        $pass = $this->input->post('password');
        $qbResult = $this->em->createQueryBuilder()
            ->select('u')
            ->from(\Entity\User::class, 'u')
            ->where('u.login =:l')
            ->setParameter('l', $login)
            ->getQuery()->getOneOrNullResult();
        //  var_dump($qbResult);
        if ($qbResult != null) {
            $passHashed = $qbResult->getPassword();
            if (password_verify($pass, $passHashed))
                return $qbResult;
        }
        return null;
    }

    public function get_user_data($idUser)
    {
        return $this->em->find(\Entity\User::class,$idUser);
    }
}