<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 01.11.2016
 * Time: 00:04
 */
class Project_model extends CI_Model
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

    public function create_project($idUser, $idRole, $pName, $pDescrition, $pCost)
    {
        $project = new \Entity\Project;
        $project->setName($pName);
        $project->setDescription($pDescrition);
        $project->setBudget($pCost);
        $this->em->persist($project);
        $this->em->flush();
        $this->add_user_to_project($idUser, $project, $idRole);
    }

    public function check_possibility_to_edit_project($userID, $projectID)
    {

        $user = $this->em->find(\Entity\User::class, $userID);
        $project = $this->em->find(\Entity\Project::class, $projectID);
        $q = $this->em->createQueryBuilder()
            ->select('ur.role AS role')
            ->from(\Entity\UserInProject::class, 'uin')
            ->innerJoin(\Entity\UserRole::class, 'ur', 'WITH', 'uin.userRole = ur.idUserRole')
            ->andwhere('uin.project=:project AND uin.user=:user')
            ->setParameter('project', $project)
            ->setParameter('user', $user)
            ->getQuery()->getSingleResult();
        if ($q['role'] != 'Właściciel') return false;
        else return true;
    }

    public function edit_project($pName, $pDescrition, $pCost, $projecIDToEdit)
    {
        $project = $this->em->find(\Entity\Project::class, $projecIDToEdit);
        if ($pDescrition != null || $pName != null || $pCost != null) {
            if ($pName != null) {
                $project->setName($pName);
            }
            if ($pDescrition != null) {
                $project->setDescription($pDescrition);
            }
            if ($pCost != null) {
                $project->setBudget($pCost);
            }
            $this->em->persist($project);
            $this->em->flush();
        }
    }

    public function remove_project($projecIDToRem)
    {
        $project = $this->em->find(\Entity\Project::class, $projecIDToRem);
        $tmp = $this->em->createQueryBuilder()
            ->select('p.idUserInProject')
            ->from(\Entity\UserInProject::class,'p')
            ->where('p.project=:id')
            ->setParameter('id',$project)
            ->getQuery()->getArrayResult();
//        var_dump($tmp);
        foreach ($tmp as $value)
        {
//            var_dump($value['idUserInProject']);
            $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\Invitation::class, 'p')
            ->where('p.userRecInv=:id')
            ->setParameter('id', $value['idUserInProject'])
            ->getQuery()->execute();
        }

        $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\UserInProject::class, 'p')
            ->where('p.project=:id')
            ->setParameter('id', $project)
           ->getQuery()->execute();

        $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\DivisionInProject::class, 'd')
            ->where('d.project=:id')
            ->setParameter('id', $project)
            ->getQuery()->execute();

        $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\Project::class, 'p')
            ->where('p.idProject=:id')
            ->setParameter('id', $projecIDToRem)
            ->getQuery()->execute();
    }

    public function leave_project($idUser, $idProject)
    {
//        var_dump($idUser);
        $tmp = $this->em->createQueryBuilder()
            ->select('p.idUserInProject')
            ->from(\Entity\UserInProject::class,'p')
            ->where('p.project=:idProject AND p.user =:idUser')
            ->setParameter('idProject',$idProject)
            ->setParameter('idUser',$idUser)
            ->getQuery()->getSingleResult();
//    var_dump($tmp['idUserInProject']);
        $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\Invitation::class, 'p')
            ->where('p.userRecInv=:id')
            ->setParameter('id', $tmp['idUserInProject'])
            ->getQuery()->execute();

        $this->em->createQueryBuilder()
            ->delete()
            ->from(\Entity\UserInProject::class, 'p')
            ->where('p.idUserInProject=:id')
            ->setParameter('id', $tmp['idUserInProject'])
            ->getQuery()->execute();
    }

    public function add_user_to_project($idUser, $idProject, $idRole)
    {
        $userHasProject = new \Entity\UserInProject();
        $userHasProject->setUser($idUser);
        $userHasProject->setDateOfJoin(new \DateTime('now'));
        $userHasProject->setProject($idProject);
        $userHasProject->setUserRole($idRole);
        $this->em->persist($userHasProject);
        $this->em->flush();
    }

    public function get_user_projecT($idUser)
    {
        $q = $this->em->createQueryBuilder()
            ->select('u.idProject', 'u.name', 'u.description', 'u.budget')
            ->from(\Entity\UserInProject::class, 'p')
            ->join('p.project', 'u')
            ->where('p.user=:id AND p.dateOfJoin is not null')
            ->setParameter('id', $idUser)
            ->getQuery()->getArrayResult();

        return $q;
    }

    //*********************** TASK **************************/

    private function format_data(&$data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['startDate'] = $data[$i]['startDate']->format('Y-m-d');
            $data[$i]['endDate'] = $data[$i]['endDate']->format('Y-m-d');
            $data[$i]['dateDiff'] = date_diff($data[$i]['endDate'], date('Y-m-d'));
        }
        return $data;
    }


    private function format_data_to_show(&$data, $completed)
    {
        $today = new DateTime();

        for ($i = 0; $i < count($data); $i++) {
            if ($completed == false) {
                $dateDiff = date_diff($data[$i]['endDate'], $today)->format('%R%a');
                if ($dateDiff[0] == '+') {
                    $data[$i]['dateDiff'] = 'Opóźnienie ' . ltrim($dateDiff, '+') . ' dni';
                } else {
                    $data[$i]['dateDiff'] = 'Do zakończenia pozostało ' . ltrim($dateDiff, '-') . ' dni';
                }

                $data[$i]['progress'] = number_format($data[$i]['progress'], 2, '.', ',') * 100;
            }
            $data[$i]['startDate'] = $data[$i]['startDate']->format('Y-m-d');
            $data[$i]['endDate'] = $data[$i]['endDate']->format('Y-m-d');

            if ($data[$i]['priority'] == 1) {
                $data[$i]['priority'] = 'Wysoki';
            } elseif ($data[$i]['priority'] == 2) {
                $data[$i]['priority'] = 'Normlany';
            } else $data[$i]['priority'] = 'Niski';
        }

        return $data;
    }

    public function get_user_permission_in_project($idUser, $idProject)
    {
        $user = $this->em->getRepository(\Entity\User::class)->find($idUser);
        $project = $this->em->getRepository(\Entity\Project::class)->find($idProject);
        $q = $this->em->createQueryBuilder()
            ->select('IDENTITY(uin.userRole) as role')
            ->from(\Entity\UserInProject::class, 'uin')
            ->andWhere('uin.project=:project')
            ->andWhere('uin.user=:user')
            ->setParameter('project', $project)
            ->setParameter('user', $user)
            ->getQuery()->getSingleResult();
        $role = $this->em->getRepository(\Entity\UserRole::class)->find($q[role]);
        if ($role->getRole() == 'Właściciel' || $role->getRole() == 'Menadżer') return 'true';
        else return 'false';
    }

    public function get_users_to_task($idProject)
    {
        $project = $this->em->getRepository(\Entity\Project::class)->find($idProject);
        $q = $this->em->createQueryBuilder()
            ->select('IDENTITY (uin.user) as userID')
            ->from(\Entity\UserInProject::class, 'uin')
            ->innerJoin(\Entity\UserRole::class, 'ur', 'WITH', 'uin.userRole = ur.idUserRole')
            ->andWhere('uin.project=:project')
            ->andWhere('ur.role=:role')
            ->setParameter('project', $project)
            ->setParameter('role', "Członek")
            ->getQuery()->getResult();
//        var_dump($q);
        if ($q != null) {
            $tmp = array();
            for ($i = 0; $i < count($q); $i++) {
                $user = $this->em->getRepository(\Entity\User::class)->find($q[$i]['userID']);
                $tmp[$i]['id'] = $user->getIdUser();
                $tmp[$i]['name'] = $user->getName();
                $tmp[$i]['email'] = $user->getEmail();
            }
//            var_dump($tmp);
            return $tmp;
        }
        return null;
    }

    public function get_task_to_excel($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('t.text', 't.startDate', 't.endDate', 't.priority', 't.budget')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject')
            ->setParameter('idProject', $idProject)
            ->getQuery()->getArrayResult();
        return $this->format_data_to_show($q, false);
    }

    public function get_highest_date($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('t.endDate')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject')
            ->setParameter('idProject', $idProject)
            ->getQuery()->getArrayResult();
        if ($q != null) {
            $tmp = max($q);
            return $tmp['endDate'];
        } else return null;
    }

    public function get_ongoing_task($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('t.id,t.text,t.startDate,t.endDate,t.progress,t.priority')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject AND t.progress != 1')
            ->setParameter('idProject', $idProject)
            ->getQuery()->getArrayResult();
        return $this->format_data_to_show($q, false);
    }

    public function get_completed_task($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('t.id,t.text,t.startDate,t.endDate,t.priority')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject AND t.progress = 1')
            ->setParameter('idProject', $idProject)
            ->getQuery()->getArrayResult();
//        var_dump($this->format_data_to_show($q,true));
        return $this->format_data_to_show($q, true);
    }

    public function get_counted_task($idProject)
    {
        $q_all_task = $this->em->createQueryBuilder()
            ->select('COUNT(t)')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject')
            ->setParameter('idProject', $idProject)
            ->getQuery()->getSingleResult();

        $q_completed_task = $this->em->createQueryBuilder()
            ->select('COUNT(t)')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject AND t.progress = 1')
            ->setParameter('idProject', $idProject)
            ->getQuery()->getSingleResult();

        $q_behinded_task = $this->em->createQueryBuilder()
            ->select('COUNT(t)')
            ->from(\Entity\GanttTasks::class, 't')
            ->where('t.idProject=:idProject AND t.endDate < :endDate AND t.progress != 1')
            ->setParameters(array('idProject' => $idProject, 'endDate' => new DateTime()))
            ->getQuery()->getSingleResult();
        $data = array('allTask' => $q_all_task['1'],
            'completedTask' => $q_completed_task['1'],
            'behindTask' => $q_behinded_task['1'],
            'onGointTask' => $q_all_task['1'] - $q_completed_task['1'] - $q_behinded_task['1']);
        return $data;
    }

    //******************* Budget *******************************
    public function get_project_budget($idProject, $startDate, $endDate, $taskKind)
    {
        if($startDate != null && $endDate != null)
        {
            $condition = 'AND (p.startDate BETWEEN :sDate AND :eDate) 
            AND (p.endDate BETWEEN :sDate AND :eDate)';
            $param = array('idProject' => $idProject,'sDate' => $startDate,'eDate' => $endDate);
        }elseif ($startDate != null)
        {
            $condition = 'AND (p.startDate >= :sDate)';
            $param = array('idProject' => $idProject,'sDate' => $startDate);
        }elseif( $endDate != null)
        {
            $condition = 'AND (p.endDate <= :eDate)';
            $param = array('idProject' => $idProject,'eDate' => new DateTime());
        }else
        {
            $condition ='';
            $param = array('idProject' => $idProject);
        }
        switch ($taskKind) {
            case 'all':
                $q = $this->em->createQueryBuilder()
                    ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
                    ->from(\Entity\GanttTasks::class, 'p')
                    ->where('p.idProject=:idProject AND p.budget > 0'.$condition)
                    ->setParameters($param)
                    ->getQuery()->getResult();
                break;
            case 'completed':
                $q = $this->em->createQueryBuilder()
                    ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
                    ->from(\Entity\GanttTasks::class, 'p')
                    ->where('p.idProject=:idProject AND p.budget > 0 AND p.progress = 1'.$condition)
                    ->setParameters($param)
                    ->getQuery()->getResult();
                break;
            case 'uncompleted':
                $q = $this->em->createQueryBuilder()
                    ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
                    ->from(\Entity\GanttTasks::class, 'p')
                    ->where('p.idProject=:idProject AND p.budget > 0 AND p.progress != 1'.$condition)
                    ->setParameters($param)
                    ->getQuery()->getResult();
//                var_dump($q);
                break;
            case 'ongoing':
                $today = new DateTime();
                $param['today'] = $today;
                $q = $this->em->createQueryBuilder()
                    ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
                    ->from(\Entity\GanttTasks::class, 'p')
                    ->where('p.idProject=:idProject AND p.budget > 0 AND p.endDate > :today AND p.progress != 1'.$condition)
                    ->setParameters($param)
                    ->getQuery()->getResult();
//                var_dump($q);
                break;
        }
        if ($q != null)
        {
//            for ($i = 0; $i < count($q); $i++) {
//                $q[$i]['startDate'] = $q[$i]['startDate']->format('Y-m-d');
//                $q[$i]['endDate'] = $q[$i]['endDate']->format('Y-m-d');
//                $q[$i]['progress'] = number_format($q[$i]['progress'], 2, '.', ',') * 100;
//            }
            $tmp = '';
            for ($i = 0; $i < count($q); $i++) {
                $q[$i]['startDate'] = $q[$i]['startDate']->format('Y-m-d');
                $q[$i]['endDate'] = $q[$i]['endDate']->format('Y-m-d');
                $q[$i]['progress'] = number_format($q[$i]['progress'], 2, '.', ',') * 100;
                $tmp = $tmp.'["'.$q[$i]['text'].'","'.$q[$i]['startDate'].'","'.$q[$i]['endDate'].'","'
                    .$q[$i]['progress'].'","'.$q[$i]['budget'].'"],';
            }
//            var_dump($q);
            return $q;
        }else return null;

    }

    public function get_budget_all_task($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.budget > 0')
            ->setParameters(array('idProject' => $idProject))
            ->getQuery()->getResult();
//        var_dump($q);

        for ($i = 0; $i < count($q); $i++) {
            $q[$i]['startDate'] = $q[$i]['startDate']->format('Y-m-d');
            $q[$i]['endDate'] = $q[$i]['endDate']->format('Y-m-d');
            $q[$i]['progress'] = number_format($q[$i]['progress'], 2, '.', ',') * 100;
//            var_dump(number_format($q[$i]['progress'],2,'.',',')*100);

        }
        return $q;
    }

    public function get_sum_whole_task($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('SUM(p.budget) as budgetSum')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.budget > 0')
            ->setParameter(':idProject', $idProject)
            ->getQuery()->getSingleResult();
        return $q['budgetSum'];
    }

    public function get_sum_completed_task($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select('SUM(p.budget) as budgetSum')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.budget > 0 AND p.progress=1')
            ->setParameter(':idProject', $idProject)
            ->getQuery()->getSingleResult();
//        var_dump($q);
        return $q['budgetSum'];
    }

    public function get_sum_ongoing_task($idProject)
    {
        $today = new DateTime();
        $q = $this->em->createQueryBuilder()
            ->select('SUM(p.budget) as budgetSum')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.budget > 0 AND p.endDate > :today AND p.progress != 1')
            ->setParameter(':idProject', $idProject)
            ->setParameter(':today', $today)
            ->getQuery()->getSingleResult();
        return $q['budgetSum'];
    }

    public function get_sum_uncompleted_task($idProject)
    {
        $today = new DateTime();
        $q = $this->em->createQueryBuilder()
            ->select( 'SUM(p.budget) as budgetSum')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.budget > 0 AND p.endDate < :today AND p.progress != 1')
            ->setParameter(':idProject', $idProject)
            ->setParameter(':today',$today)
            ->getQuery()->getSingleResult();
        return $q['budgetSum'];
    }

    public function get_project_buget($idProject)
    {
        $q = $this->em->createQueryBuilder()
            ->select( 'SUM(p.budget) AS projectBudget')
            ->from(\Entity\Project::class, 'p')
            ->where('p.idProject=:idProject')
            ->setParameter(':idProject', $idProject)
            ->getQuery()->getSingleResult();
        return $q['projectBudget'];
    }


    public function get_budget_since($idProject, $startDate)
    {
        $q = $this->em->createQueryBuilder()
            ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.startDate >= :sDate AND p.budget > 0')
            ->setParameters(array('idProject' => $idProject, 'sDate' => $startDate))
            ->getQuery()->getResult();
//        var_dump($q);

        for ($i = 0; $i < count($q); $i++) {
            $q[$i]['startDate'] = $q[$i]['startDate']->format('Y-m-d');
            $q[$i]['endDate'] = $q[$i]['endDate']->format('Y-m-d');
            $q[$i]['progress'] = number_format($q[$i]['progress'], 2, '.', ',') * 100;
        }
//        var_dump($q);
        return $q;
    }

    public function get_budget_until($idProject, $endDate)
    {
        $q = $this->em->createQueryBuilder()
            ->select('p.text', 'p.startDate', 'p.endDate', 'p.progress', 'p.budget')
            ->from(\Entity\GanttTasks::class, 'p')
            ->where('p.idProject=:idProject AND p.endDate <= :eDate AND p.budget > 0')
            ->setParameters(array('idProject' => $idProject, 'eDate' => $endDate))
            ->getQuery()->getResult();
//        var_dump($q);

        for ($i = 0; $i < count($q); $i++) {
            $q[$i]['startDate'] = $q[$i]['startDate']->format('Y-m-d');
            $q[$i]['endDate'] = $q[$i]['endDate']->format('Y-m-d');
            $q[$i]['progress'] = number_format($q[$i]['progress'], 2, '.', ',') * 100;
        }
//        var_dump($q);
        return $q;
    }

    //************************* HR *****************************//

    public function send_invitation($idUserSendInv, $userEmailRecInv, $divName, $idUserRole, $idProject)
    {
        $userRecInv = $this->em->getRepository(\Entity\User::class)->findOneBy(array('email' => $userEmailRecInv));
        $userSendInv = $this->em->find(\Entity\User::class, $idUserSendInv);
        $project = $this->em->find(\Entity\Project::class, $idProject);
        $q = $this->em->createQueryBuilder()
            ->select('din')
            ->from(\Entity\DivisionInProject::class, 'din')
            ->innerJoin(\Entity\Division::class, 'd', 'WITH', 'din.division = d.idDivision')
            ->andWhere('d.name=:name')
            ->andWhere('d.user=:user')
            ->setParameter(':name', $divName)
            ->setParameter(':user', $userRecInv)
            ->getQuery()->getResult();
//        var_dump($q);
        if ($q == null) {
            $division = new \Entity\Division();
            $division->setName($divName);
            $division->setUser($userRecInv);
            $divisionInProject = new \Entity\DivisionInProject();
            $divisionInProject->setDivision($division);
            $divisionInProject->setProject($project);
            $divisionInProject->setDateOfCreate(new \DateTime('now'));
            $this->em->persist($divisionInProject);
            $this->em->flush();
        }

        $role = $this->em->find(\Entity\UserRole::class, $idUserRole);
        $userInProject = new \Entity\UserInProject();
        $userInProject->setUserRole($role);
        $userInProject->setProject($project);
        $userInProject->setUser($userRecInv);
        $this->em->persist($userInProject);
        $this->em->flush();

        $invitation = new  \Entity\Invitation();
        $invitation->setDateOfInvitation(new \DateTime('now'));
        $invitation->setUserSendInv($userSendInv);
        $invitation->setStatus('Oczekujący');
        $invitation->setUserRecInv($userInProject);
        $this->em->persist($invitation);
        $this->em->flush();
    }


    public function check_possibility_of_invitation($userSendInvID, $userEmailRecInv)
    {
        $userRecInvID = $this->em->getRepository(\Entity\User::class)->findOneBy(array('email' => $userEmailRecInv));
        if ($userRecInvID == null) {

            $op['status'] = 'false';
            $op['msg'] = 'Użytknik o podanym adresie E-mail nie istnieje';
            return $op;
        }
        $op = array();
        if ($userRecInvID->getIdUser() == $userSendInvID) {
            $op['status'] = 'false';
            $op['msg'] = 'Podano własny adres E-mail';
            return $op;
        }
        $q = $this->em->createQueryBuilder()
            ->select('n.status')
            ->from(\Entity\Invitation::class, 'n')
            ->innerJoin(\Entity\UserInProject::class, 'p', 'WITH', 'n.userRecInv = p.idUserInProject')
            ->andWhere('n.userSendInv=:userSendInv')
            ->andWhere('p.user=:userRecInv')
            ->setParameter(':userSendInv', $userSendInvID)
            ->setParameter(':userRecInv', $userRecInvID)
            ->getQuery()->getResult();
        if ($q != null) {
            $op['status'] = 'false';
            $op['msg'] = 'Zaproszenie zadanego użytkownika zostało już wysłane';
            return $op;
        } else {
            $op['status'] = 'true';
            $op['msg'] = 'Poprawnie wysłano zaproszenie';
            return $op;
        }
    }

    public function check_notification($userID)
    {
//        var_dump($userID);
        $q = $this->em->createQueryBuilder()
            ->select('n.idInvitation, IDENTITY(n.userSendInv) AS userSendInv', 'IDENTITY(p.project) AS project',
                'IDENTITY(p.user) AS userInProject', 'IDENTITY(p.userRole) AS userRole', 'p.idUserInProject AS idUserInProject')
            ->from(\Entity\Invitation::class, 'n')
            ->innerJoin(\Entity\UserInProject::class, 'p', 'WITH', 'n.userRecInv = p.idUserInProject')
            ->andWhere('p.user=' . $userID)
            ->andWhere('n.status = :status')
            ->setParameter(':status', 'Oczekujący')
            ->groupBy('p.project')
            ->getQuery()->getResult();
//        var_dump($q);
        if ($q != null) {
            for ($i = 0; $i < count($q); $i++) {
                $q[$i]['userSendInv'] = $this->em->find(\Entity\User::class, $q[$i]['userSendInv']);
                $q[$i]['project'] = $this->em->find(\Entity\Project::class, $q[$i]['project']);
                $q[$i]['userInProject'] = $this->em->find(\Entity\User::class, $q[$i]['userInProject']);
                $q[$i]['userRole'] = $this->em->find(\Entity\UserRole::class, $q[$i]['userRole']);
                $tmp[$i]['nameUserSendInv'] = $q[$i]['userSendInv']->getName();
                $tmp[$i]['surnameUserSendInv'] = $q[$i]['userSendInv']->getSurname();
                $tmp[$i]['project'] = $q[$i]['project']->getName();
                $tmp[$i]['idUserInProject'] = $q[$i]['idUserInProject'];
                $tmp[$i]['idInvitation'] = $q[$i]['idInvitation'];
            }
//            var_dump( /*$q,*/$tmp);
            return $tmp;

        }
        return $q;
    }

    public function add_user_to_project_by_invitation($idInvitation, $idUserInProject)
    {
        $updateInv = $this->em->find(\Entity\Invitation::class, $idInvitation);
        $dateAccept = new \DateTime('now');
        $updateInv->setDateOfAcceptance($dateAccept);
        $updateInv->setStatus("Zaakceptowany ");
        $this->em->persist($updateInv);
        $this->em->flush();

        $updateUserInProject = $this->em->find(\Entity\UserInProject::class, $idUserInProject);
        $updateUserInProject->setDateOfJoin($dateAccept);
        $this->em->persist($updateUserInProject);
        $this->em->flush();
//        var_dump($updateInv);
    }

    public function reject_invitation_to_project($idInvitation)
    {
        $updateInv = $this->em->find(\Entity\Invitation::class, $idInvitation);
        $updateInv->setStatus("Odrzucony");
        $this->em->persist($updateInv);
        $this->em->flush();
    }

    public function get_user_data_by_project($projectID)
    {
        $q = $this->em->createQueryBuilder()
            ->select('IDENTITY(uin.user) AS user', 'IDENTITY(uin.userRole) AS userRole',
                'inv.status AS status')
            ->from(\Entity\UserInProject::class, 'uin')
            ->leftJoin(\Entity\Invitation::class, 'inv', 'WITH', 'inv.userRecInv = uin.idUserInProject')
            ->where('uin.project=:projectID'/*,'uin.dateOfJoin is not null'*/)
            ->setParameter(':projectID', $projectID)
            ->getQuery()->getResult();
//        var_dump($q);
//        $q2 = $this->em->createQueryBuilder()
//            ->select('d')
//            ->from(\Entity\DivisionInProject::class, 'din')
//            ->innerJoin(\Entity\Division::class, 'd', 'WITH', 'din.division = d.idDivision')
//            ->where('din.project=:projectID'/*,'uin.dateOfJoin is not null'*/)
//            ->setParameter(':projectID', $projectID)
//            ->getQuery()->getResult();
//        var_dump($q2);
        $tmp['total'] = count($q);
        for ($i = 0; $i < count($q); $i++) {
            $q[$i]['user'] = $this->em->find(\Entity\User::class, $q[$i]['user']);
//            $userID = $q[$i]['user']->getIdUser();
            $q[$i]['userRole'] = $this->em->find(\Entity\UserRole::class, $q[$i]['userRole']);
//            $q[$i]['company'] = $this->em->find(\Entity\Company::class, $q[$i]['company']);
            $tmp['rows'][$i]['id'] = $q[$i]['user']->getIdUser();
            $tmp['rows'][$i]['name'] = $q[$i]['user']->getName();
            $tmp['rows'][$i]['surname'] = $q[$i]['user']->getSurname();
            $tmp['rows'][$i]['email'] = $q[$i]['user']->getEmail();
            $tmp['rows'][$i]['role'] = $q[$i]['userRole']->getRole();
            $div = $this->em->getRepository(\Entity\Division::class)->findOneBy(array('user' => $q[$i]['user']));
//            var_dump($div);
            if ($div != null) {
                $tmp['rows'][$i]['company'] = $div->getName();
            } else $tmp['rows'][$i]['company'] = null;

            $tmp['rows'][$i]['status'] = $q[$i]['status'];
        }

//        var_dump($tmp);
        return $tmp;
    }

    public function get_division_by_project($projectID)
    {
        $project = $this->em->find(\Entity\Project::class, $projectID);
        $q = $this->em->createQueryBuilder()
            ->select('DISTINCT d.name')
            ->from(\Entity\DivisionInProject::class, 'din')
            ->innerJoin(\Entity\Division::class, 'd', 'WITH', 'din.division = d.idDivision')
            ->andWhere('din.project=:project')
            ->setParameter(':project', $project)
            ->getQuery()->getResult();
        if ($q != null) {
            for ($i = 0; $i < count($q); $i++) {
                $tmp[] = $q[$i]['name'];
            }
            return $tmp;
        } else return null;
    }
}