<?php



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


}

