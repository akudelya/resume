<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 50)]
    protected string $name;

    #[Assert\NotBlank]
    #[ORM\Column(length: 50)]
    protected string $site;

    #[Assert\NotBlank]
    #[ORM\Column(length: 50)]
    protected string $address;

    #[Assert\NotBlank]
    #[ORM\Column(length: 20)]
    protected string $phone;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $value): void
    {
        $this->name = $value;
    }

    public function getSite(): string
    {
        return $this->site;
    }

    public function setSite(string $value): void
    {
        $this->site = $value;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $value): void
    {
        $this->address = $value;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $value): void
    {
        $this->phone = $value;
    }
}