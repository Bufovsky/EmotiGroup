<?php

namespace App\Entity;

use App\Entity\Vacancies;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    private ?string $FirstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $Surname = null;

    #[ORM\Column]
    private ?float $Cost = null;

    #[ORM\OneToOne(targetEntity: Vacancies::class, cascade: ['persist', 'all'])]
    #[ORM\JoinColumn(name: "vacancies_id", referencedColumnName: "id")]
    private ?Vacancies $VacanciesId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): static
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->Cost;
    }

    public function setCost(float $Cost): static
    {
        $this->Cost = $Cost;

        return $this;
    }

    public function getVacanciesId(): ?Vacancies
    {
        return $this->VacanciesId;
    }

    public function setVacanciesId(Vacancies $VacanciesId): static
    {
        $this->VacanciesId = $VacanciesId;

        return $this;
    }
}
