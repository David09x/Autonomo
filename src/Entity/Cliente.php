<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
#[ORM\Table(name: "cliente")]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 18, nullable: true)]
    private ?string $telefono = null;

    #[ORM\OneToMany(targetEntity: Citas::class, mappedBy: 'idCliente')]
    private Collection $citas;

    public function __construct()
    {
        $this->citas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

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
            $cita->setIdCliente($this);
        }

        return $this;
    }

    public function removeCita(Citas $cita): static
    {
        if ($this->citas->removeElement($cita)) {
            // set the owning side to null (unless already changed)
            if ($cita->getIdCliente() === $this) {
                $cita->setIdCliente(null);
            }
        }

        return $this;
    }*/

    public function __toArray(){
        $response = [
            'nombre' => $this->getNombre(),
            'telefono' => $this->getTelefono(),
            
        ];

        return $response;
    }
}
