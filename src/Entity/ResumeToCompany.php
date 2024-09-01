<?php

namespace App\Entity;

use \DateTimeImmutable;
use \InvalidArgumentException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ResumeToCompany
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Resume::class)]
    private Resume $resume;
    
    #[ORM\ManyToOne(targetEntity: Company::class)]
    private Company $company;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options:["default" => null])]
    protected ?int $rating = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $sentAt;

    public function getId(): int
    {
        return $this->id;
    }
    
    public function getResume(): Resume
    {
        return $this->resume;
    }

    public function setResume(Resume $value): void
    {
        $this->resume = $value;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $value): void
    {
        $this->company = $value;
    }
    
    public function getRating(): int|null
    {
        return $this->rating;
    }

    public function setRating(int $value): void
    {
        $this->rating = $value;
    }
    
    public function getSentAt(): DateTimeImmutable
    {
        return $this->sentAt;
    }

    public function setSentAt(DateTimeImmutable $value): void
    {
        $this->sentAt = $value;
    }
}