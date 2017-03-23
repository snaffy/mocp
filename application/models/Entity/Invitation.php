<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation", indexes={@ORM\Index(name="fk_invitation_user1_idx", columns={"user_id_user"}), @ORM\Index(name="fk_invitation_user_in_project1_idx", columns={"user_in_project_id_user_in_project"})})
 * @ORM\Entity
 */
class Invitation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_invitation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInvitation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_invitation", type="date", nullable=true)
     */
    private $dateOfInvitation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_acceptance", type="date", nullable=true)
     */
    private $dateOfAcceptance;

    /**
     * @var string
     *
     * @ORM\Column(name="status",  type="string", length=20, nullable=false)
     */
    private $status;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_user", referencedColumnName="id_user")
     * })
     */
    private $userSendInv;

    /**
     * @var \UserInProject
     *
     * @ORM\ManyToOne(targetEntity="UserInProject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_in_project_id_user_in_project", referencedColumnName="id_user_in_project")
     * })
     */
    private $userRecInv;

    /**
     * @return int
     */
    public function getIdInvitation()
    {
        return $this->idInvitation;
    }

    /**
     * @param int $idInvitation
     */
    public function setIdInvitation($idInvitation)
    {
        $this->idInvitation = $idInvitation;
    }

    /**
     * @return DateTime
     */
    public function getDateOfInvitation()
    {
        return $this->dateOfInvitation;
    }

    /**
     * @param DateTime $dateOfInvitation
     */
    public function setDateOfInvitation($dateOfInvitation)
    {
        $this->dateOfInvitation = $dateOfInvitation;
    }

    /**
     * @return DateTime
     */
    public function getDateOfAcceptance()
    {
        return $this->dateOfAcceptance;
    }

    /**
     * @param DateTime $dateOfAcceptance
     */
    public function setDateOfAcceptance($dateOfAcceptance)
    {
        $this->dateOfAcceptance = $dateOfAcceptance;
    }

    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getUserSendInv()
    {
        return $this->userSendInv;
    }

    /**
     * @param User $userSendInv
     */
    public function setUserSendInv($userSendInv)
    {
        $this->userSendInv = $userSendInv;
    }

    /**
     * @return UserInProject
     */
    public function getUserRecInv()
    {
        return $this->userRecInv;
    }

    /**
     * @param UserInProject $userRecInv
     */
    public function setUserRecInv($userRecInv)
    {
        $this->userRecInv = $userRecInv;
    }



}

