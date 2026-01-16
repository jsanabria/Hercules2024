<?php

namespace PHPMaker2024\hercules\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\hercules\AbstractEntity;
use PHPMaker2024\hercules\AdvancedSecurity;
use PHPMaker2024\hercules\UserProfile;
use function PHPMaker2024\hercules\Config;
use function PHPMaker2024\hercules\EntityManager;
use function PHPMaker2024\hercules\RemoveXss;
use function PHPMaker2024\hercules\HtmlDecode;
use function PHPMaker2024\hercules\EncryptPassword;

/**
 * Entity class for "sco_orden_salida" table
 */
#[Entity]
#[Table(name: "sco_orden_salida")]
class ScoOrdenSalida extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden_salida", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nordenSalida;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "integer", nullable: true)]
    private ?int $grupo;

    #[Column(type: "string", nullable: true)]
    private ?string $conductor;

    #[Column(type: "integer", nullable: true)]
    private ?int $acompanantes;

    #[Column(type: "string", nullable: true)]
    private ?string $placa;

    #[Column(type: "string", nullable: true)]
    private ?string $motivo;

    #[Column(type: "string", nullable: true)]
    private ?string $observaciones;

    #[Column(type: "string", nullable: true)]
    private ?string $autoriza;

    #[Column(name: "fecha_autoriza", type: "datetime", nullable: true)]
    private ?DateTime $fechaAutoriza;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function __construct()
    {
        $this->acompanantes = 0;
    }

    public function getNordenSalida(): string
    {
        return $this->nordenSalida;
    }

    public function setNordenSalida(string $value): static
    {
        $this->nordenSalida = $value;
        return $this;
    }

    public function getFechaHora(): ?DateTime
    {
        return $this->fechaHora;
    }

    public function setFechaHora(?DateTime $value): static
    {
        $this->fechaHora = $value;
        return $this;
    }

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getGrupo(): ?int
    {
        return $this->grupo;
    }

    public function setGrupo(?int $value): static
    {
        $this->grupo = $value;
        return $this;
    }

    public function getConductor(): ?string
    {
        return HtmlDecode($this->conductor);
    }

    public function setConductor(?string $value): static
    {
        $this->conductor = RemoveXss($value);
        return $this;
    }

    public function getAcompanantes(): ?int
    {
        return $this->acompanantes;
    }

    public function setAcompanantes(?int $value): static
    {
        $this->acompanantes = $value;
        return $this;
    }

    public function getPlaca(): ?string
    {
        return HtmlDecode($this->placa);
    }

    public function setPlaca(?string $value): static
    {
        $this->placa = RemoveXss($value);
        return $this;
    }

    public function getMotivo(): ?string
    {
        return HtmlDecode($this->motivo);
    }

    public function setMotivo(?string $value): static
    {
        $this->motivo = RemoveXss($value);
        return $this;
    }

    public function getObservaciones(): ?string
    {
        return HtmlDecode($this->observaciones);
    }

    public function setObservaciones(?string $value): static
    {
        $this->observaciones = RemoveXss($value);
        return $this;
    }

    public function getAutoriza(): ?string
    {
        return HtmlDecode($this->autoriza);
    }

    public function setAutoriza(?string $value): static
    {
        $this->autoriza = RemoveXss($value);
        return $this;
    }

    public function getFechaAutoriza(): ?DateTime
    {
        return $this->fechaAutoriza;
    }

    public function setFechaAutoriza(?DateTime $value): static
    {
        $this->fechaAutoriza = $value;
        return $this;
    }

    public function getEstatus(): ?string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(?string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }
}
