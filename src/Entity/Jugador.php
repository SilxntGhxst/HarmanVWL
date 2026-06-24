<?php

namespace App\Entity;

use App\Enum\RangoJugador;
use App\Repository\JugadorRepository;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JugadorRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'assert.jugador.email.unique')]
#[UniqueEntity(fields: ['nickname'], message: 'assert.jugador.nickname.unique')]
class Jugador
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'assert.jugador.nickname.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'assert.jugador.nickname.min',
        maxMessage: 'assert.jugador.nickname.max'
    )]
    private ?string $nickname = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'assert.jugador.email.not_blank')]
    #[Assert\Email(message: 'assert.jugador.email.invalid')]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, enumType: \App\Enum\RangoJugador::class)]
    #[Assert\NotNull(message: 'assert.jugador.rango.not_null')]
    private ?\App\Enum\RangoJugador $rango = null;

    #[ORM\ManyToOne(inversedBy: 'jugadores')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Equipo $equipo = null;

    #[ORM\Column(options: ['default' => 18])]
    #[Assert\NotNull(message: 'assert.jugador.edad.not_null')]
    #[Assert\Range(min: 1, max: 99, notInRangeMessage: 'assert.jugador.edad.range')]
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
