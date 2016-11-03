<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 01.11.2016
 * Time: 00:04
 */

class User_project  extends CI_Model
{

    /**
     * User_project constructor.
     */
    public function __construct()
    {
        $this->load->library('doctrine');
        /** @var $em Doctrine\ORM\EntityManager */
        $em = $this->doctrine->em;
        $this->em = $em;
        parent::__construct();
    }

    public function create_project($idUser,$idRole)
    {
        $pName = $this->input->post('projectName');
        if($pName == null)
        {
            $pName = "Nowy Projekt";
        }
        $pDescrition = $this->input->post('projectDescription');
        $project = new \Entity\Project;
        $project->setName($pName);
        $project->setDescription($pDescrition);
        $this->em->persist($project);
        $this->em->flush();
        $this->add_user_to_project($idUser,$project,$idRole);
    }

    public function edit_project()
    {
        $pName = $this->input->post('projectName');
        $pDescrition = $this->input->post('projectDescription');
        $projecIDToEdit = $this->input->post('projectID');
        $project = $this->em->find(\Entity\Project::class,$projecIDToEdit);
        if($pDescrition != null || $pName != null)
        {
            if($pName != null)
            {
                $project->setName($pName);
            }
            if($pDescrition != null)
            {
                $project->setDescription($pDescrition);
            }
            $this->em->persist($project);
            $this->em->flush();
        }
    }

    public function remove_project()
    {
        $projecIDToRem = $this->input->post('manaRemBtn');
        $project = $this->em->find(\Entity\Project::class,$projecIDToRem);

       $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\UserHasProject::class,'p')
            ->where('p.project=:id')
            ->setParameter('id',$project)
            ->getQuery()->execute();

        $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\Project::class,'p')
            ->where('p.idProject=:id')
            ->setParameter('id',$projecIDToRem)
            ->getQuery()->execute();
    }

    public function add_user_to_project($idUser,$idProject,$idRole)
    {
        $userHasProject = new \Entity\UserHasProject();
        $userHasProject->setUser($idUser);
        $userHasProject->setDateOfJoin(new \DateTime('now'));
        $userHasProject->setProject($idProject);
        $userHasProject->setUserRole($idRole);
        $this->em->persist($userHasProject);
        $this->em->flush();
    }
    
    public function get_user_projecT($idUser)
    {
        $q =$this->em->createQueryBuilder()
            ->select('u.idProject','u.name','u.description')
            ->from(\Entity\UserHasProject::class,'p')
            ->join('p.project','u')
            ->where('p.user=:id')
            ->setParameter('id',5)
            ->getQuery()->getArrayResult();

       return $q ;
    }
}