<?php

namespace App\Interface;

use App\Entity\Reservations;

interface CostCalculatorInterface
{
    public function count(Reservations $reservations): Reservations;
}