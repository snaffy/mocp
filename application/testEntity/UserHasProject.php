<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * UserHasProject
 *
 * @ORM\Table(name="user_has_project", indexes={@ORM\Index(name="fk_user_has_Project_Project1_idx", columns={"Project_idProject"}), @ORM\Index(name="fk_user_has_Project_user_idx", columns={"user_iduser"}), @ORM\Index(name="fk_user_has_Project_user_role1_idx", columns={"user_role_id_user_role"})})
 * @ORM\Entity
 */
class UserHasProject
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_join", type="date", nullable=true)
     */
    private $dateOfJoin;

    /**
     * @var \Project
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_idProject", referencedColumnName="id_project")
     * })
     */
    private $projectproject;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="id_user")
     * })
     */
    private $useruser;

    /**
     * @var \UserRole
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_role_id_user_role", referencedColumnName="id_user_role")
     * })
     */
    private $userRoleUserRole;


}

