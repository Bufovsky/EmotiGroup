<?php

namespace App\Service;


use App\Entity\Reservations;
use App\Interface\ReservationsInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Summary of ReservationsService
 */
class ReservationsService implements ReservationsInterface
{
    /**
     * ReservationsService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
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
