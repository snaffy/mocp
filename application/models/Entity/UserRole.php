<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 *
 * @ORM\Table(name="user_role")
 * @ORM\Entity
 */
class UserRole
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user_role", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserRole;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=45, nullable=true)
     */
    private $role;

    /**
     * @return int
     */
    public function getIdUserRole()
    {
        return $this->idUserRole;
    }

    /**
     * @param int $idUserRole
     */
    public function setIdUserRole($idUserRole)
    {
        $this->idUserRole = $idUserRole;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }


}

