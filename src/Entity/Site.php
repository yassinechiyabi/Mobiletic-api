<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $domainname = null;

    #[ORM\Column(length: 255,name:'ipaddresse')]
    private ?string $ipaddress = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'sites')]
    #[ORM\JoinColumn(name:'id_serveur')]
    private ?Serveur $id_serveur = null;

    

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

    public function getDomainname(): ?string
    {
        return $this->domainname;
    }

    public function setDomainname(string $domainname): static
    {
        $this->domainname = $domainname;

        return $this;
    }

    public function getIpaddress(): ?string
    {
        return $this->ipaddress;
    }

    public function setIpaddress(string $ipaddress): static
    {
        $this->ipaddress = $ipaddress;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getIdServeur(): ?Serveur
    {
        return $this->id_serveur;
    }

    public function setIdServeur(?Serveur $id_serveur): static
    {
        $this->id_serveur = $id_serveur;

        return $this;
    }

    
}
