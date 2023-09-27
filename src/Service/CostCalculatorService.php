<?php

namespace App\Service;


use App\Entity\Reservations;
use App\Interface\CostCalculatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateInterval;
use DatePeriod;


class CostCalculatorService extends AbstractController implements CostCalculatorInterface
{
    /**
     * Summary of sum
     * @var float
     */
    private float $sum = 0;

    /**
     * Summary of count
     * @param \App\Entity\Reservations $reservations
     * @return \App\Entity\Reservations
     */
    public function count(Reservations $reservations): Reservations
    {
        $dateRange = $this->getDateRange($reservations);

        foreach ($dateRange as $date) {
            $dayOfWeek = $date->format('l');
            $this->sum += $this->getParameter($dayOfWeek);
        }

        $reservations->setCost($this->sum);

        return $reservations;
    }

    /**
     * Summary of getDateRange
     * @param \App\Entity\Reservations $reservations
     * @return \DatePeriod
     */
    private function getDateRange(Reservations $reservations): DatePeriod
    {
        $dateFrom = $reservations->getVacanciesId()->getDateFrom();
        $dateTo = $reservations->getVacanciesId()->getDateTo()->setTime(0,0,1);;
        $dateInterval = new DateInterval('P1D');
        $dateRange = new DatePeriod($dateFrom, $dateInterval, $dateTo);

        return $dateRange;
    }
}