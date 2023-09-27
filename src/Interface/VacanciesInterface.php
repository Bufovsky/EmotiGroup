<?php

namespace App\Interface;

use App\Entity\Vacancies;
use DatePeriod;

interface VacanciesInterface
{
    public function checkIsVacanciesAvailable(Vacancies $vacancies, string $available): bool;

    public function getDateRange(Vacancies $vacancies): DatePeriod;
}