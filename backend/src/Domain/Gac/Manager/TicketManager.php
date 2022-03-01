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
        SluggerInterface       $slugger,
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
            'account' => $data['account'],
            'bill' => $data['bill'],
            'subscriber' => $data['subscriber'],
            'hour' => $data['hour'],
            'real_duration' => $data['real_duration'],
            'volume_duration' => $data['volume_duration'],
            'type' => $data['type'],
            'date' => $data['date'],
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
     * @return \Doctrine\DBAL\Result
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findTotalCall()
    {
        $conn = $this->em->getConnection();

        $sql = <<<SQL
SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(t.real_duration))) AS TotalTime
FROM ticket t 
WHERE t.date >= STR_TO_DATE('15/02/2012', '%d/%m/%Y')
AND t.`type` LIKE '%appel%'
SQL;

        $q = $conn->prepare($sql);
        return $q->executeQuery()
            ->fetchAssociative();
    }

    /**
     * @return \Doctrine\DBAL\Result
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findTopTen()
    {
        $conn = $this->em->getConnection();

        $sql = <<<SQL
SELECT * 
FROM ticket t 
JOIN (
    SELECT DISTINCT t2.account 
    FROM ticket t2 
    ORDER BY t2.invoice_duration ASC 
    LIMIT 10
) t3
ON t.account = t3.account
WHERE t.id NOT IN (
	SELECT t1.id from ticket t1 
	WHERE t1.`hour` between '08:00' AND '18:00'
)
AND `type` LIKE '%connexion%'
SQL;

        $q = $conn->prepare($sql);
        return $q->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * @param array|null $criteria
     * @return \Doctrine\DBAL\Result
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findTotalSMS()
    {
        $conn = $this->em->getConnection();

        $sql = <<<SQL
SELECT COUNT(*) 
FROM ticket t 
WHERE t.`type` LIKE '%sms%'
SQL;
        $q = $conn->prepare($sql);
        return $q->executeQuery()
            ->fetchOne();
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
            ->setAccount($data['account'])
            ->setBill($data['bill'])
            ->setSubscriber($data['subscriber'])
            ->setDate($data['date'])
            ->setHour($data['hour'])
            ->setRealDuration($data['real_duration'])
            ->setVolumeDuration($data['volume_duration'])
            ->setType($data['type']);

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