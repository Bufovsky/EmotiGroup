<?php

namespace App\Tests\Repository;

use App\Entity\Vacancies;
use App\Service\VacanciesService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTimeImmutable;

/**
 * Summary of VacanciesRepositoryTest
 */
class VacanciesServiceTests extends KernelTestCase
{
    /**
     * Summary of vacancies
     * @var Vacancies
     */
    private Vacancies $vacancies;

    /**
     * Summary of controller
     * @var VacanciesService
     */
    private VacanciesService $repository;


    /**
     * Summary of setUp
     * @return void
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $this->repository = $container->get(VacanciesService::class);
        $this->vacancies = new Vacancies();
        $this->vacancies->setDateFrom(new DateTimeImmutable('2023-09-21 00:00:00'));
        $this->vacancies->setDateTo(new DateTimeImmutable('2023-09-23 00:00:00'));
    }

    /**
     * Summary of testCheckIsVacanciesAvailable
     * @return void
     */
    public function testCheckIsVacanciesAvailable()
    {
        $vacancies = 1;
        $result = $this->repository->checkIsVacanciesAvailable($this->vacancies, $vacancies);

        var_dump($result);

        $this->assertFalse($result);
    }

    /**
     * Summary of testCheckIsVacanciesNotAvailable
     * @return void
     */
    public function testCheckIsVacanciesNotAvailable()
    {
        $vacancies = 5;
        $result = $this->repository->checkIsVacanciesAvailable($this->vacancies, $vacancies);

        $this->assertTrue($result);
    }
}