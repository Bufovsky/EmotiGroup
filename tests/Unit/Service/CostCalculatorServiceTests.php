<?php

namespace App\Tests\Service;

use App\Entity\Reservations;
use App\Entity\Vacancies;
use App\Service\CostCalculatorService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;

/**
 * Summary of CostCalculatorServiceTest
 */
class CostCalculatorServiceTests extends KernelTestCase
{
    /**
     * Summary of service
     * @var CostCalculatorService
     */
    private CostCalculatorService $service;

    /**
     * Summary of entity
     * @var Reservations
     */
    private Reservations $reservations;

    /**
     * Summary of setUp
     * @return void
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $this->service = $container->get(CostCalculatorService::class);
        $this->reservations = new Reservations();
        $vacancies = new Vacancies();
        $vacancies->setDateFrom(new DateTimeImmutable('2023-09-17 00:00:00'));
        $vacancies->setDateTo(new DateTimeImmutable('2023-09-23 00:00:00'));
        $this->reservations->setVacanciesId($vacancies);
    }

    /**
     * Summary of testCount
     * @return void
     */
    public function testCount()
    {
        $result = $this->service->count($this->reservations);

        // The cost should be the sum of parameter values for the days in the date range
        // MONDAY="5"
        // TUESDAY="5"
        // WEDNESDAY="5"
        // THURSDAY="5"
        // FRIDAY="10"
        // SATURDAY="10"
        // SUNDAY="10"
        $this->assertEquals(50.0, $result->getCost());
    }
}