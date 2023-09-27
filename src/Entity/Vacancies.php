<?php

namespace App\Entity;

use App\Repository\VacanciesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VacanciesRepository::class)]
#[ORM\MappedSuperclass()]
class Vacancies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\LessThan(propertyPath: "dateTo", message: "The start date must be less than the end date.")]
    private ?\DateTimeImmutable $dateFrom = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\GreaterThan(propertyPath: "dateFrom", message: "The end date must be greater than the start date.")]
    private ?\DateTimeImmutable $dateTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFrom(): ?\DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeImmutable $dateFrom): static
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): ?\DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTimeImmutable $dateTo): static
    {
        $this->dateTo = $dateTo;

        return $this;
    }
}
