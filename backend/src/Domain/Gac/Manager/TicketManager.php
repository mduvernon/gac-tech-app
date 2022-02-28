<?php

namespace Domain\Gac\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\ResultSetMapping;
use Domain\Gac\Exception\TicketNotFoundException;
use Domain\Gac\Entity\Ticket;
use Easybook\SluggerInterface;

/**
 * Class TicketManager
 *
 * This class will perform Create Read Update Delete all tickets Actions
 */
class TicketManager implements TicketManagerInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * TicketManager constructor.
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     *
     * @param $class
     */
    public function __construct(
        EntityManagerInterface $em,
        SluggerInterface $slugger,
        $class
    )
    {
        $this->em = $em;
        $this->slugger = $slugger;

        $this->repository = $this->em->getRepository($class);

        $metadata = $this->em->getClassMetadata($class ?: Ticket::class);
        $this->class = $metadata->name;
    }

    /**
     * Create Ticket with the given data
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $conn = $this->em->getConnection();

        $updated_at = new \DateTime();

        $sql = <<<SQL
INSERT INTO tickets SET 
    `account`=:account, 
    `bill`=:bill, 
    `subscriber`=:subscriber, 
    `hour`=:hour, 
    `real_duration`=:real_duration, 
    `volume_duration`=:volume_duration, 
    `type`=:type, 
    `date`=:date;
SQL;

        $params = [
            'name' => $data['name'],
            'slug' => $this->slugger->slugify($data['name']),
            'description' => $data['description'],
            'updated_at' => $updated_at->format('Y-m-d H:i:s')
        ];

        $q = $conn->prepare($sql);
        return $q->execute($params);
    }

    /**
     * Find all tickets and paginate by the given criteria
     *
     * @param int $start
     * @param int $end
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public function findAllPaginate(int $start = 0, $end = self::PAGINATE_MAX, array $criteria = []): array
    {
        $countQB = $this->em->createQueryBuilder();
        $totalCount = 0;
        $tickets = [];

        $countQB->select("COUNT(s.id)")
            ->from('Domain\Gac\Entity\Ticket', "s");
        $sql = "SELECT s FROM Domain\Gac\Entity\Ticket s ";

        if (isset($criteria['account'])) {
            $sql .= " WHERE s.name LIKE '%" . $criteria['account'] . "%' ";
            $countQB->where("s.account LIKE '%:account%")
                ->setParameters(['account' => $criteria['account']]);
        }

        $q = $this->em->createQuery($sql);
        $q->setParameters($criteria);

        $totalCount = $countQB->getQuery()->getSingleScalarResult();

        return [
            'items' => $q->getArrayResult(),
            'totalCount' => $totalCount
        ];
    }

    /**
     * Find One ticket by the given id
     *
     * @param int $id
     * @return object|Ticket
     */
    public function finOneById(int $id): Ticket
    {
        $params = ['id' => $id];

        return $this->repository->findOneBy($params);
    }

    /**
     * Update one Ticket with the given criteria
     *
     * @param Ticket $ticket
     * @param array $data
     * @return mixed
     */
    public function update(Ticket $ticket, array $data)
    {
        $ticket
            ->setUpdatedAt(new \DateTime())
            ->setName($data['name'])
            ->setSlug($this->slugger->slugify($data['name']))
            ->setDescription($data['description']);

        #do persist the ticket
        $this->em->persist($ticket);
        #renew the unit of work
        $this->em->flush();

        return true;
    }


    /**
     * Delete one Ticket by the given criteria
     *
     * @param Ticket $ticket
     * @return bool
     */
    public function delete(Ticket $ticket)
    {
        # remove the given Ticket
        $this->em->remove($ticket);
        # renew the unit of work
        $this->em->flush();

        return true;
    }
}