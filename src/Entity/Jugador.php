<?php

namespace App\Entity;

use App\Enum\RangoJugador;
use App\Repository\JugadorRepository;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JugadorRepository::class)]
class Jugador
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Assert\NotBlank(message: 'El jugador debe tener un nombre.')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'El nickname del jugador debe tener al menos {{ limit }} caracteres',
        maxMessage: 'El nickname del jugador no puede tener más de {{ limit }} caracteres'
    )]
    private ?string $nickname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, enumType: \App\Enum\RangoJugador::class)]
    private ?\App\Enum\RangoJugador $rango = null;

    #[ORM\ManyToOne(inversedBy: 'jugadores')]
    private ?Equipo $equipo = null;

    #[ORM\Column(options: ['default' => 18])]
    #[Assert\Range(min: 1, max: 99)]
    private ?int $edad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRango(): ?\App\Enum\RangoJugador
    {
        return $this->rango;
    }

    public function setRango(?\App\Enum\RangoJugador $rango): static
    {
        $this->rango = $rango;

        return $this;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->equipo;
    }

    public function setEquipo(?Equipo $equipo): static
    {
        $this->equipo = $equipo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this ->nickname;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(int $edad): static
    {
        $this->edad = $edad;

        return $this;
    }
}
