<?php

namespace App\Interface;

use App\Entity\Reservations;

interface ReservationsInterface
{
    public function get(int $id): ?Reservations;

    public function getList(): array;

    public function create(Reservations $reservation): void;

    public function update(Reservations $reservation): void;

    public function delete(int $id): void;
}
