<?php

namespace App\Entity;

use App\Repository\EquipoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EquipoRepository::class)]
#[UniqueEntity(fields: ['nombre'], message: 'assert.equipo.name.unique')]
#[UniqueEntity(fields: ['codigo_tag'], message: 'assert.equipo.tag.unique')]
class Equipo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'assert.equipo.name.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'assert.equipo.name.min',
        maxMessage: 'assert.equipo.name.max',
    )]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'assert.equipo.tag.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 8,
        minMessage: 'assert.equipo.tag.min',
        maxMessage: 'assert.equipo.tag.max',
    )]
    private ?string $codigo_tag = null;
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'assert.equipo.date.not_null')]
    #[Assert\Type("\DateTimeInterface", message: 'assert.equipo.date.invalid')]
    #[Assert\LessThanOrEqual('today', message: 'assert.equipo.date.future')]
    private ?\DateTime $fecha_creacion = null;

    /**
     * @var Collection<int, Jugador>
     */
    #[ORM\OneToMany(targetEntity: Jugador::class, mappedBy: 'equipo')]
    private Collection $jugadores;

    /**
     * @var Collection<int, Torneo>
     */
    #[ORM\ManyToMany(targetEntity: Torneo::class, mappedBy: 'equipos')]
    private Collection $torneos;

    public function __construct()
    {
        $this->jugadores = new ArrayCollection();
        $this->torneos = new ArrayCollection();
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

    public function getCodigoTag(): ?string
    {
        return $this->codigo_tag;
    }

    public function setCodigoTag(string $codigo_tag): static
    {
        $this->codigo_tag = $codigo_tag;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTime
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTime $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    /**
     * @return Collection<int, Jugador>
     */
    public function getJugadores(): Collection
    {
        return $this->jugadores;
    }

    public function addJugadore(Jugador $jugadore): static
    {
        if (!$this->jugadores->contains($jugadore)) {
            $this->jugadores->add($jugadore);
            $jugadore->setEquipo($this);
        }

        return $this;
    }

    public function removeJugadore(Jugador $jugadore): static
    {
        if ($this->jugadores->removeElement($jugadore)) {
            // set the owning side to null (unless already changed)
            if ($jugadore->getEquipo() === $this) {
                $jugadore->setEquipo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Torneo>
     */
    public function getTorneos(): Collection
    {
        return $this->torneos;
    }

    public function addTorneo(Torneo $torneo): static
    {
        if (!$this->torneos->contains($torneo)) {
            $this->torneos->add($torneo);
            $torneo->addEquipo($this);
        }

        return $this;
    }

    public function removeTorneo(Torneo $torneo): static
    {
        if ($this->torneos->removeElement($torneo)) {
            $torneo->removeEquipo($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre ?? 'Sin nombre';
    }
}
