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
 * Entity class for "sco_alertas" table
 */
#[Entity]
#[Table(name: "sco_alertas")]
class ScoAlerta extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nalerta", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nalerta;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    #[Column(name: "fecha_end", type: "datetime", nullable: true)]
    private ?DateTime $fechaEnd;

    #[Column(name: "descripcion_corta", type: "string", nullable: true)]
    private ?string $descripcionCorta;

    #[Column(name: "descripcion_larga", type: "string", nullable: true)]
    private ?string $descripcionLarga;

    #[Column(type: "integer", nullable: true)]
    private ?int $orden;

    #[Column(type: "integer", nullable: true)]
    private ?int $activo;

    public function __construct()
    {
        $this->orden = 1;
        $this->activo = 1;
    }

    public function getNalerta(): int
    {
        return $this->nalerta;
    }

    public function setNalerta(int $value): static
    {
        $this->nalerta = $value;
        return $this;
    }

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }

    public function getFechaEnd(): ?DateTime
    {
        return $this->fechaEnd;
    }

    public function setFechaEnd(?DateTime $value): static
    {
        $this->fechaEnd = $value;
        return $this;
    }

    public function getDescripcionCorta(): ?string
    {
        return HtmlDecode($this->descripcionCorta);
    }

    public function setDescripcionCorta(?string $value): static
    {
        $this->descripcionCorta = RemoveXss($value);
        return $this;
    }

    public function getDescripcionLarga(): ?string
    {
        return HtmlDecode($this->descripcionLarga);
    }

    public function setDescripcionLarga(?string $value): static
    {
        $this->descripcionLarga = RemoveXss($value);
        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(?int $value): static
    {
        $this->orden = $value;
        return $this;
    }

    public function getActivo(): ?int
    {
        return $this->activo;
    }

    public function setActivo(?int $value): static
    {
        $this->activo = $value;
        return $this;
    }
}
