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
 * Entity class for "sco_flota" table
 */
#[Entity]
#[Table(name: "sco_flota")]
class ScoFlota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nflota", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nflota;

    #[Column(name: "tipo_flota", type: "integer", nullable: true)]
    private ?int $tipoFlota;

    #[Column(type: "integer", nullable: true)]
    private ?int $marca;

    #[Column(type: "integer", nullable: true)]
    private ?int $modelo;

    #[Column(type: "string", unique: true, nullable: true)]
    private ?string $placa;

    #[Column(type: "string", nullable: true)]
    private ?string $color;

    #[Column(type: "integer", nullable: true)]
    private ?int $anho;

    #[Column(name: "serial_carroceria", type: "string", nullable: true)]
    private ?string $serialCarroceria;

    #[Column(name: "serial_motor", type: "string", nullable: true)]
    private ?string $serialMotor;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $conductor;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    #[Column(name: "km_oil_next", type: "integer", nullable: true)]
    private ?int $kmOilNext;

    public function __construct()
    {
        $this->activo = "S";
    }

    public function getNflota(): int
    {
        return $this->nflota;
    }

    public function setNflota(int $value): static
    {
        $this->nflota = $value;
        return $this;
    }

    public function getTipoFlota(): ?int
    {
        return $this->tipoFlota;
    }

    public function setTipoFlota(?int $value): static
    {
        $this->tipoFlota = $value;
        return $this;
    }

    public function getMarca(): ?int
    {
        return $this->marca;
    }

    public function setMarca(?int $value): static
    {
        $this->marca = $value;
        return $this;
    }

    public function getModelo(): ?int
    {
        return $this->modelo;
    }

    public function setModelo(?int $value): static
    {
        $this->modelo = $value;
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

    public function getColor(): ?string
    {
        return HtmlDecode($this->color);
    }

    public function setColor(?string $value): static
    {
        $this->color = RemoveXss($value);
        return $this;
    }

    public function getAnho(): ?int
    {
        return $this->anho;
    }

    public function setAnho(?int $value): static
    {
        $this->anho = $value;
        return $this;
    }

    public function getSerialCarroceria(): ?string
    {
        return HtmlDecode($this->serialCarroceria);
    }

    public function setSerialCarroceria(?string $value): static
    {
        $this->serialCarroceria = RemoveXss($value);
        return $this;
    }

    public function getSerialMotor(): ?string
    {
        return HtmlDecode($this->serialMotor);
    }

    public function setSerialMotor(?string $value): static
    {
        $this->serialMotor = RemoveXss($value);
        return $this;
    }

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
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

    public function getActivo(): ?string
    {
        return $this->activo;
    }

    public function setActivo(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'activo' value");
        }
        $this->activo = $value;
        return $this;
    }

    public function getKmOilNext(): ?int
    {
        return $this->kmOilNext;
    }

    public function setKmOilNext(?int $value): static
    {
        $this->kmOilNext = $value;
        return $this;
    }
}
