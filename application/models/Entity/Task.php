<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task", indexes={@ORM\Index(name="fk_task_Project1_idx", columns={"Project_idProject"}), @ORM\Index(name="fk_description_user1_idx", columns={"user_iduser"})})
 * @ORM\Entity
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_task", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idTask;

    /**
     * @var string
     *
     * @ORM\Column(name="taske_name", type="string", length=45, nullable=false)
     */
    private $taskeName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="budget", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $budget;

    /**
     * @var string
     *
     * @ORM\Column(name="app_extra_cost", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $appExtraCost;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     */
    private $description;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="id_user")
     * })
     */
    private $useruser;

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


}

