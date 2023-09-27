<?php

namespace App\Repository;

use App\Entity\Vacancies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vacancies>
 *
 * @method Vacancies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vacancies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vacancies[]    findAll()
 * @method Vacancies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacanciesRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Vacancies::class);
    }

   /**
    * USED NATIVE QUERY BECOUSE QUERYBUILDER DONT ACCEPT SUBQUERY IN LEFT JOIN
    *
    * @return Vacancies[] Returns an array of Vacancies objects
    */
    public function checkIsVacanciesAlavable(array $dates, string $vacancies) : bool
    {
        $query = "SELECT
                    subquery.date_to_check,
                    COUNT(t.id) AS count_of_records
                FROM (";

        foreach ( $dates as $date ) {
            $query .= ( $dates[(count($dates) - 1)] === $date ) ? "SELECT '$date' AS date_to_check " : "SELECT '$date' AS date_to_check UNION ALL ";
        }

        $query .= ") AS subquery
                LEFT JOIN vacancies AS t ON subquery.date_to_check BETWEEN t.date_from AND t.date_to
                GROUP BY subquery.date_to_check
                HAVING count_of_records >= $vacancies";

        $conn = $this->entityManager->getConnection();
        $stmt = $conn->executeQuery($query);

        return count($stmt->fetchAll()) == "0";
    }
}