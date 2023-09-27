<?php

namespace App\Repository;

use App\Entity\Reservations;
use App\Interface\ReservationsInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository implements ReservationsInterface
{
    /**
     * Summary of __construct
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, Reservations::class);
    }
    
    /**
     * Summary of get
     * @param int $id
     * @return Reservations|null
     */
    public function get(int $id): ?Reservations
    {
        $repository = $this->entityManager->getRepository(Reservations::class);

        return $repository->find($id);
    }

    /**
     * Summary of getList
     * @return array
     */
    public function getList(): array
    {
        $repository = $this->entityManager->getRepository(Reservations::class);

        return $repository->findAll();
    }

    /**
     * Summary of create
     * @param \App\Entity\Reservations $reservation
     * @return void
     */
    public function create(Reservations $reservation): void
    {
        $this->entityManager->persist($reservation->getVacanciesId());
        $this->entityManager->flush();
        
        $this->entityManager->persist($reservation->getUserId());
        $this->entityManager->flush();

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }

    /**
     * Summary of update
     * @param \App\Entity\Reservations $reservation
     * @return void
     */
    public function update(Reservations $reservation): void
    {
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }

    /**
     * Summary of delete
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $entity = $this->get($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
