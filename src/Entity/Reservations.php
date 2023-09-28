<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Vacancies;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Summary of Reservations
 */
#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
#[ORM\MappedSuperclass()]
class Reservations
{
    /**
     * Summary of id
     * @var 
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Summary of UserId
     * @var 
     */
    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'all'])]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $UserId = null;

    /**
     * Summary of Cost
     * @var 
     */
    #[ORM\Column]
    private ?float $Cost = null;

    /**
     * Summary of VacanciesId
     * @var 
     */
    #[ORM\OneToOne(targetEntity: Vacancies::class, cascade: ['persist', 'all'])]
    #[ORM\JoinColumn(name: "vacancies_id", referencedColumnName: "id")]
    private ?Vacancies $VacanciesId = null;

    /**
     * Summary of getId
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Summary of setId
     * @param int $id
     * @return static
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Summary of getUserId
     * @return User
     */
    public function getUserId(): User
    {
        return $this->UserId;
    }

    /**
     * Summary of setUserId
     * @param \App\Entity\User $UserId
     * @return static
     */
    public function setUserId(User $UserId): static
    {
        $this->UserId = $UserId;

        return $this;
    }

    /**
     * Summary of getCost
     * @return float|null
     */
    public function getCost(): ?float
    {
        return $this->Cost;
    }

    /**
     * Summary of setCost
     * @param float $Cost
     * @return static
     */
    public function setCost(float $Cost): static
    {
        $this->Cost = $Cost;

        return $this;
    }

    /**
     * Summary of getVacanciesId
     * @return Vacancies|null
     */
    public function getVacanciesId(): ?Vacancies
    {
        return $this->VacanciesId;
    }

    /**
     * Summary of setVacanciesId
     * @param \App\Entity\Vacancies $VacanciesId
     * @return static
     */
    public function setVacanciesId(Vacancies $VacanciesId): static
    {
        $this->VacanciesId = $VacanciesId;

        return $this;
    }
}
