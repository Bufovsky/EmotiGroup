<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Summary of User
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
#[ORM\MappedSuperclass()]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Summary of id
     * @var 
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    /**
     * Summary of email
     * @var 
     */
    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * Summary of password
     * @var 
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private ?string $password = null;

    /**
     * Summary of roles
     * @var array
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * Summary of getId
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Summary of getEmail
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Summary of setEmail
     * @param string $email
     * @return \App\Entity\User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Summary of setPassword
     * @param string $password
     * @return \App\Entity\User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    /**
     * Summary of setRoles
     * @param array $roles
     * @return \App\Entity\User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    // public function __toString() {
    //     return (string) $this->getId();
    // }
}
