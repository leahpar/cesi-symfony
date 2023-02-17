<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ApiResource]
class Galaxie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'galaxie', targetEntity: Planete::class)]
    private Collection $planetes;

    public function __construct()
    {
        $this->planetes = new ArrayCollection();
    }

    /**
     * @return Collection<int, Planete>
     */
    public function getPlanetes(): Collection
    {
        return $this->planetes;
    }

    public function addPlanete(Planete $planete): self
    {
        if (!$this->planetes->contains($planete)) {
            $this->planetes->add($planete);
            $planete->setGalaxie($this);
        }

        return $this;
    }

    public function removePlanete(Planete $planete): self
    {
        if ($this->planetes->removeElement($planete)) {
            // set the owning side to null (unless already changed)
            if ($planete->getGalaxie() === $this) {
                $planete->setGalaxie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

}
