<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="login_UNIQUE", columns={"login"})}, indexes={@ORM\Index(name="fk_user_user_role1_idx", columns={"user_role_iduser_role"}), @ORM\Index(name="fk_user_city1_idx", columns={"city_idcity"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_details_iduser_details", type="integer", nullable=true)
     */
    private $userDetailsIduserDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=45, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=11, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_acc_number", type="string", length=36, nullable=true)
     */
    private $bankAccNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=45, nullable=true)
     */
    private $street;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=64, nullable=true)
     */
    private $salt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expired", type="boolean", nullable=true)
     */
    private $expired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    private $expiresAt;

    /**
     * @var \City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_idcity", referencedColumnName="id_city")
     * })
     */
    private $citycity;

    /**
     * @var \UserRole
     *
     * @ORM\ManyToOne(targetEntity="UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_role_iduser_role", referencedColumnName="id_user_role")
     * })
     */
    private $userRoleuserRole;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="useruser")
     * @ORM\JoinTable(name="user_has_project",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_iduser", referencedColumnName="id_user")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Project_idProject", referencedColumnName="id_project")
     *   }
     * )
     */
    private $projectproject;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projectproject = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getUserDetailsIduserDetails()
    {
        return $this->userDetailsIduserDetails;
    }

    /**
     * @param int $userDetailsIduserDetails
     */
    public function setUserDetailsIduserDetails($userDetailsIduserDetails)
    {
        $this->userDetailsIduserDetails = $userDetailsIduserDetails;
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
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getBankAccNumber()
    {
        return $this->bankAccNumber;
    }

    /**
     * @param string $bankAccNumber
     */
    public function setBankAccNumber($bankAccNumber)
    {
        $this->bankAccNumber = $bankAccNumber;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return \City
     */
    public function getCitycity()
    {
        return $this->citycity;
    }

    /**
     * @param \City $citycity
     */
    public function setCitycity($citycity)
    {
        $this->citycity = $citycity;
    }

    /**
     * @return \UserRole
     */
    public function getUserRoleuserRole()
    {
        return $this->userRoleuserRole;
    }

    /**
     * @param \UserRole $userRoleuserRole
     */
    public function setUserRoleuserRole($userRoleuserRole)
    {
        $this->userRoleuserRole = $userRoleuserRole;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectproject()
    {
        return $this->projectproject;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $projectproject
     */
    public function setProjectproject($projectproject)
    {
        $this->projectproject = $projectproject;
    }
    
    

}

