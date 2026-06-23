<?php

namespace App\Entity;
use App\Enum\EstadoTorneo;

use App\Repository\TorneoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\PseudoTypes\EnumString;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TorneoRepository::class)]
class Torneo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El torneo debe tener un nombre.')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'El nombre del torneo debe tener al menos {{ limit }} caracteres',
        maxMessage: 'El nombre del torneo no puede tener más de {{ limit }} caracteres',
    )]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $juego = null;

    #[ORM\Column]
    #[Assert\Positive(message: 'El premio debe ser positivo')]
    private ?float $bolsa_premios = null;

    #[ORM\Column(length: 255, enumType: EstadoTorneo::class)]
    private ?EstadoTorneo $estado = null;

    /**
     * @var Collection<int, Equipo>
     */
    #[ORM\ManyToMany(targetEntity: Equipo::class, inversedBy: 'torneos')]
    private Collection $equipos;

    public function __construct()
    {
        $this->equipos = new ArrayCollection();
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

    public function getJuego(): ?string
    {
        return $this->juego;
    }

    public function setJuego(string $juego): static
    {
        $this->juego = $juego;

        return $this;
    }

    public function getBolsaPremios(): ?float
    {
        return $this->bolsa_premios;
    }

    public function setBolsaPremios(float $bolsa_premios): static
    {
        $this->bolsa_premios = $bolsa_premios;

        return $this;
    }

    public function getEstado(): ?EstadoTorneo
    {
        return $this->estado;
    }

    public function setEstado(EstadoTorneo $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection<int, Equipo>
     */
    public function getEquipos(): Collection
    {
        return $this->equipos;
    }

    public function addEquipo(Equipo $equipo): static
    {
        if (!$this->equipos->contains($equipo)) {
            $this->equipos->add($equipo);
        }

        return $this;
    }

    public function removeEquipo(Equipo $equipo): static
    {
        $this->equipos->removeElement($equipo);

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre ?? 'Sin nombre';
    }
}
