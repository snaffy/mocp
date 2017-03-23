<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GanttLinks
 *
 * @ORM\Table(name="gantt_links")
 * @ORM\Entity
 */
class GanttLinks
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="source", type="integer", nullable=false)
     */
    private $source;

    /**
     * @var integer
     *
     * @ORM\Column(name="target", type="integer", nullable=false)
     */
    private $target;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=1, nullable=false)
     */
    private $type;


}

