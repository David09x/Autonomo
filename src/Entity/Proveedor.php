<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
#[ORM\Table(name: "proveedor")]
class Proveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 38, nullable: true)]
    private ?string $telefono = null;

    #[ORM\OneToMany(targetEntity: Gastos::class, mappedBy: 'idProveedor')]
    private Collection $gastos;

    public function __construct()
    {
        $this->gastos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
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
     * @return Collection<int, Gastos>
     */

    /*
    public function getGastos(): Collection
    {
        return $this->gastos;
    }

    public function addGasto(Gastos $gasto): static
    {
        if (!$this->gastos->contains($gasto)) {
            $this->gastos->add($gasto);
            $gasto->setIdProveedor($this);
        }

        return $this;
    }

    public function removeGasto(Gastos $gasto): static
    {
        if ($this->gastos->removeElement($gasto)) {
            // set the owning side to null (unless already changed)
            if ($gasto->getIdProveedor() === $this) {
                $gasto->setIdProveedor(null);
            }
        }

        return $this;
    }
    */
    public function __toArray(){
        $response = [
            'nombre' => $this->getNombre(),
            'telefono' => $this->getTelefono()
        ];

        return $response;
    }
}
