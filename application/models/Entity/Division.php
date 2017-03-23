<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Division
 *
 * @ORM\Table(name="division", indexes={@ORM\Index(name="fk_division_user1_idx", columns={"user_id_user"})})
 * @ORM\Entity
 */
class Division
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_division", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDivision;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

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
     * @return int
     */
    public function getIdDivision()
    {
        return $this->idDivision;
    }

    /**
     * @param int $idDivision
     */
    public function setIdDivision($idDivision)
    {
        $this->idDivision = $idDivision;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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


}

