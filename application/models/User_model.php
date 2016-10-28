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
        $login = $this->input->post('login');
        $pass = $this->input->post('password');
        $usr = new Entity\User;
        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
        $usr->setPassword($hashed_password);
        $usr->setLogin($login);
        $this->em->persist($usr);
        $this->em->flush();
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
        
//
//        $question_marks = array();
//        foreach ($datafields as $d) {
//            $question_marks[] = $d . "=:" . $d;
//        }
//        $question_marks;
//        $bind_data = implode(",", $question_marks);
//        $tablename = \Entity\User::class;

//        $sql = "UPDATE Entity/User SET name = :name WHERE id_user = :id ";
//        $stmt = $this->em->getConnection()->prepare($sql);
//        for($i=0;$i< count($datafields);$i++)
//        {
//            $stmt->bindParam(":" . $datafields[$i], $insert_values[$i]);
//
//        }
//        $name = 'noewa1';
//        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//        $id = '1' ;
//        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
//        $stmt->execute();
//        var_dump($sql);
//        var_dump($stmt);

        //  $sql ="UPDATE Entity\User u SET u.name = 'testzmiany' WHERE u.idUser = 1";


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