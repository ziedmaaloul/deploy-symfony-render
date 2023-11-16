<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datecomm = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Fournisseur $fournisseur = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeLigne::class)]
    private Collection $commandeLignes;

    public function __construct()
    {
        $this->commandeLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecomm(): ?\DateTimeInterface
    {
        return $this->datecomm;
    }

    public function setDatecomm(?\DateTimeInterface $datecomm): static
    {
        $this->datecomm = $datecomm;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): static
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes->add($commandeLigne);
            $commandeLigne->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): static
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            // set the owning side to null (unless already changed)
            if ($commandeLigne->getCommande() === $this) {
                $commandeLigne->setCommande(null);
            }
        }

        return $this;
    }
}
