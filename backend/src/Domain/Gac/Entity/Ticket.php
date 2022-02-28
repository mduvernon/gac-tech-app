<?php

namespace Domain\Gac\Entity;

use JsonSerializable;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tickets")
 */
class Ticket implements JsonSerializable
{

    /**
     * The ticket Id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * The ticket account
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $account;

    /**
     * The ticket bill
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $bill;

    /**
     * The ticket subscriber
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $subscriber;

    /**
     * The ticket date
     *
     * @ORM\Column(type="date", nullable=false)
     *
     * @var \DateTime
     */
    private $date;

    /**
     * The ticket date
     *
     * @ORM\Column(type="date", nullable=false)
     *
     * @var \DateTime
     */
    private $hour;

    /**
     * The ticket real duration
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $real_duration;

    /**
     * The ticket volume duration
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $volume_duration;

    /**
     * The ticket type
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $type;

    /**
     * Get the ticket Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the ticket Id
     *
     * @param $id
     * @return $this
     */
    public function setId(?int $id): Ticket
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'slug' => $this->getSlug(),
            'description' => $this->getDescription(),
            'updated_at' => $this->getUpdatedAt()->format(\DATE_ISO8601),
        ];
    }
}