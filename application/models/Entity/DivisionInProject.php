<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DivisionInProject
 *
 * @ORM\Table(name="division_in_project", indexes={@ORM\Index(name="fk_division_in_project_division1_idx", columns={"division_id_division"}), @ORM\Index(name="fk_division_in_project_project1_idx", columns={"project_id_project"})})
 * @ORM\Entity
 */
class DivisionInProject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_division_in_project", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDivisionInProject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_create", type="datetime", nullable=true)
     */
    private $dateOfCreate;

    /**
     * @var \Division
     *
     * @ORM\ManyToOne(targetEntity="Division",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="division_id_division", referencedColumnName="id_division")
     * })
     */
    private $division;

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
     * @return int
     */
    public function getIdDivisionInProject()
    {
        return $this->idDivisionInProject;
    }

    /**
     * @param int $idDivisionInProject
     */
    public function setIdDivisionInProject($idDivisionInProject)
    {
        $this->idDivisionInProject = $idDivisionInProject;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfCreate()
    {
        return $this->dateOfCreate;
    }

    /**
     * @param \DateTime $dateOfCreate
     */
    public function setDateOfCreate($dateOfCreate)
    {
        $this->dateOfCreate = $dateOfCreate;
    }

    /**
     * @return \Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @param \Division $division
     */
    public function setDivision($division)
    {
        $this->division = $division;
    }

    /**
     * @return \Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }


}

