<?php

namespace App\Service;


use App\Entity\Vacancies;
use App\Interface\VacanciesInterface;
use App\Repository\VacanciesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DateInterval;
use DatePeriod;

/**
 * Summary of VacanciesService
 */
class VacanciesService implements VacanciesInterface
{

    /**
     * Summary of __construct
     * @param mixed $container
     * @param mixed $vacanciesRepository
     * @param mixed $doctrine
     * @param mixed $dateRange
     * @param mixed $dates
     */
    public function __construct(
        protected ?ContainerInterface $container = null,
        private ?VacanciesRepository $vacanciesRepository = null,
        private ?ManagerRegistry $doctrine = null,
        private ?DatePeriod $dateRange = null,
        private ?array $dates = null
    ) {}

    /**
     * Summary of checkIsVacanciesAvailable
     * @param \App\Entity\Vacancies $vacancies
     * @param string $available
     * @return bool
     */
    public function checkIsVacanciesAvailable(Vacancies $vacancies, string $available): bool
    {
        $dateRange = $this->getDateRange($vacancies);

        foreach ($dateRange as $date) {
            $this->dates[] = $date->format('Y-m-d H:i:s');
        }

        return $this->vacanciesRepository->checkIsVacanciesAlavable($this->dates, $available);
    }
    

    /**
     * Summary of getDateRange
     * @param \App\Entity\Vacancies $vacancies
     * @return \DatePeriod
     */
    public function getDateRange(Vacancies $vacancies): DatePeriod
    {
        $dateFrom = $vacancies->getDateFrom();
        $dateTo = $vacancies->getDateTo()->setTime(0,0,1);
        $dateInterval = new DateInterval('P1D');
        $dateRange = new DatePeriod($dateFrom, $dateInterval, $dateTo);

        return $dateRange;
    }
}