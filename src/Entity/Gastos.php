<?php

namespace App\Entity;

use App\Repository\GastosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GastosRepository::class)]
#[ORM\Table(name: "gastos")]
class Gastos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 38, scale: 0, nullable: true)]
    private ?string $precio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'gastos')]
    #[ORM\JoinColumn(nullable: false, name: 'idProveedor')]
    private ?Proveedor $idProveedor = null;

   

    public function __construct()
    {
        $this->personas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
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

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(?string $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getIdProveedor(): ?Proveedor
    {
        return $this->idProveedor;
    }

    public function setIdProveedor(?Proveedor $idProveedor): static
    {
        $this->idProveedor = $idProveedor;

        return $this;
    }
    public function __toArray(){
        $response = [
            'idProovedor' => $this->getIdProveedor(),
            'descripcion' => $this->getDescripcion(),
            'fecha' => $this->getFecha(),
            'precio' => $this->getPrecio()
        ];

        return $response;
    }
}
