<?php

namespace App\Entity;

use App\Repository\ServiciosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiciosRepository::class)]
class Servicios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 38, scale: 0, nullable: true)]
    private ?string $precio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo = null;

    #[ORM\OneToMany(targetEntity: Citas::class, mappedBy: 'idServicio')]
    private Collection $citas;

    public function __construct()
    {
        $this->citas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(?string $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }
    /*
    /**
     * @return Collection<int, Citas>
     */
    /*
    public function getCitas(): Collection
    {
        return $this->citas;
    }

    public function addCita(Citas $cita): static
    {
        if (!$this->citas->contains($cita)) {
            $this->citas->add($cita);
            $cita->setIdServicio($this);
        }

        return $this;
    }

    public function removeCita(Citas $cita): static
    {
        if ($this->citas->removeElement($cita)) {
            // set the owning side to null (unless already changed)
            if ($cita->getIdServicio() === $this) {
                $cita->setIdServicio(null);
            }
        }

        return $this;
    }*/
    public function __toArray(){
        $response = [
            'precio' => $this->getPrecio(),
            'tipo' => $this->getTipo()
        ];

        return $response;
    }

}
