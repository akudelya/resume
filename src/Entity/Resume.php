<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use \DateTimeImmutable;
use \InvalidArgumentException;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
class Resume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    /**
     * Many Resumes have Many Companies.
     * @var Collection<int, ResumeToCompany>
     */
    #[JoinTable(name: 'resume_to_company')]
    #[JoinColumn(name: 'company_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'resume_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: 'ResumeToCompany')]
    private Collection $sentToCompanies;

    #[Assert\NotBlank]
    #[ORM\Column(length: 50)]
    protected string $position;

    #[ORM\Column(type: Types::TEXT)]
    protected string $description;

    #[ORM\Column(length: 10)]
    protected string $description_type;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $modifiedAt;
    

    public function __construct()
    {
        $this->sentToCompanies = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $value): void
    {
        $this->position = $value;
    }

    public function getDescriptionType(): string
    {
        return $this->description_type;
    }

    public function setDescriptionType(string $value): void
    {
        if (!in_array($value, ['text', 'file'])) {
            throw new InvalidArgumentException("Invalid value '$value' for field description_type");
        }
        $this->description_type = $value;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $value): void
    {
        $this->description = $value;
    }
    
    public function getDisplayDescription(): string
    {
        if ($this->description_type == 'text') {
            return $this->description;
        }
        $file = unserialize($this->description);
        return $file['filename'];
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $value): void
    {
        $this->createdAt = $value;
    }

    public function getModifiedAt(): DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(DateTimeImmutable $value): void
    {
        $this->modifiedAt = $value;
    }
    
    public function getSentToCompanies(): Collection
    {
        return $this->sentToCompanies;
    }
    
    public function sendToCompany(ResumeToCompany $company): void
    {
        $company->setSentAt(new DateTimeImmutable());
        $this->sentToCompanies[] = $company;
    }
}