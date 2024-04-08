<?php

namespace App\Entity;

use App\Repository\CitasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitasRepository::class)]
class Citas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hora = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: false, name: 'idCliente')]
    private ?Cliente $idCliente = null;

    #[ORM\ManyToOne(inversedBy: 'citas')]
    #[ORM\JoinColumn(nullable: false, name: 'idServicio')]
    private ?Servicios $idServicio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHora(): ?string
    {
        return $this->hora;
    }

    public function setHora(?string $hora): static
    {
        $this->hora = $hora;

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

    public function getIdCliente(): ?Cliente
    {
        return $this->idCliente;
    }

    public function setIdCliente(?Cliente $idCliente): static
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getIdServicio(): ?Servicios
    {
        return $this->idServicio;
    }

    public function setIdServicio(?Servicios $idServicio): static
    {
        $this->idServicio = $idServicio;

        return $this;
    }

    public function __toArray(){
        $response = [
            'idCliente' => $this->getIdCliente()->getNombre(),
            'idServicio' => $this->getIdServicio()->getTipo(),
            'Hora' => $this->getHora(),
            'fecha' => $this->getFecha()
        ];

        return $response;
    }
}
