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
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @param string $account
     * @return Ticket
     */
    public function setAccount(string $account): Ticket
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return string
     */
    public function getBill(): string
    {
        return $this->bill;
    }

    /**
     * @param string $bill
     * @return Ticket
     */
    public function setBill(string $bill): Ticket
    {
        $this->bill = $bill;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubscriber(): string
    {
        return $this->subscriber;
    }

    /**
     * @param string $subscriber
     * @return Ticket
     */
    public function setSubscriber(string $subscriber): Ticket
    {
        $this->subscriber = $subscriber;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Ticket
     */
    public function setDate(\DateTime $date): Ticket
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHour(): \DateTime
    {
        return $this->hour;
    }

    /**
     * @param \DateTime $hour
     * @return Ticket
     */
    public function setHour(\DateTime $hour): Ticket
    {
        $this->hour = $hour;
        return $this;
    }

    /**
     * @return string
     */
    public function getRealDuration(): string
    {
        return $this->real_duration;
    }

    /**
     * @param string $real_duration
     * @return Ticket
     */
    public function setRealDuration(string $real_duration): Ticket
    {
        $this->real_duration = $real_duration;
        return $this;
    }

    /**
     * @return string
     */
    public function getVolumeDuration(): string
    {
        return $this->volume_duration;
    }

    /**
     * @param string $volume_duration
     * @return Ticket
     */
    public function setVolumeDuration(string $volume_duration): Ticket
    {
        $this->volume_duration = $volume_duration;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Ticket
     */
    public function setType(string $type): Ticket
    {
        $this->type = $type;
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