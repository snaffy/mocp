<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInProject
 *
 * @ORM\Table(name="user_in_project", indexes={@ORM\Index(name="fk_user_in_project_user_role1_idx", columns={"user_role_id_user_role"}), @ORM\Index(name="fk_user_in_project_user1_idx", columns={"user_id_user"}), @ORM\Index(name="fk_user_in_project_project1_idx", columns={"project_id_project"})})
 * @ORM\Entity
 */
class UserInProject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user_in_project", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserInProject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_join", type="date", nullable=true)
     */
    private $dateOfJoin;

    /**
     * @var \Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id_project", referencedColumnName="id_project")
     * })
     */
    private $project;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_user", referencedColumnName="id_user")
     * })
     */
    private $user;

    /**
     * @var \UserRole
     *
     * @ORM\ManyToOne(targetEntity="UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_role_id_user_role", referencedColumnName="id_user_role")
     * })
     */
    private $userRole;

    /**
     * @return int
     */
    public function getIdUserInProject()
    {
        return $this->idUserInProject;
    }

    /**
     * @param int $idUserInProject
     */
    public function setIdUserInProject($idUserInProject)
    {
        $this->idUserInProject = $idUserInProject;
    }

    /**
     * @return DateTime
     */
    public function getDateOfJoin()
    {
        return $this->dateOfJoin;
    }

    /**
     * @param DateTime $dateOfJoin
     */
    public function setDateOfJoin($dateOfJoin)
    {
        $this->dateOfJoin = $dateOfJoin;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return UserRole
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @param UserRole $userRole
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;
    }


}

