<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use App\Traits\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[
    ORM\Entity(repositoryClass: PersonRepository::class),
    ORM\HasLifecycleCallbacks()
]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    use TimestampTrait;

    #[
        ORM\Column(length: 50),
        Assert\NotBlank(message: 'Ce champ est obligatoire')
    ]
    private ?string $name = null;

    #[
        ORM\Column(type: Types::SMALLINT),
        Assert\NotBlank(message: 'Ce champ est obligatoire'),
        Assert\LessThanOrEqual(60, message: 'Sayeb a3lik bara erta7 khirlek :D')
    ]
    private ?int $age = null;

    #[ORM\Column(length: 50),         Assert\NotBlank(message: 'Ce champ est obligatoire')]
    private ?string $firstname = null;

    #[ORM\ManyToOne(inversedBy: 'people')]
    private ?Cours $cours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): static
    {
        $this->cours = $cours;

        return $this;
    }

    public function __toString(): string
    {
        return $this->firstname." ".$this->name;
    }
}
