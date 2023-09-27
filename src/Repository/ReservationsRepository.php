<?php

namespace App\Repository;

use App\Entity\Reservations;
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
class ReservationsRepository extends ServiceEntityRepository
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
     * @param Reservations entity prepared to create in databasse
     * @return Reservations if correct object else exception
     */
    public function create(Reservations $reservations): Reservations|string
    {
        try {
            $this->entityManager->persist($reservations);
            $this->entityManager->flush();

            return $reservations;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * Summary of delete
     * @param int $id
     * @return string
     */
    public function delete(int $id): string
    {
        try {
            $reservations = $this->entityManager->getRepository(Reservations::class);
            $reservation = $reservations->find($id);
            $this->entityManager->remove($reservation);
            $this->entityManager->flush();

            return true;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
