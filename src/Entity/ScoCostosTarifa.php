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
 * Entity class for "sco_costos_tarifa" table
 */
#[Entity]
#[Table(name: "sco_costos_tarifa")]
class ScoCostosTarifa extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ncostos_tarifa", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $ncostosTarifa;

    #[Column(type: "string", nullable: true)]
    private ?string $localidad;

    #[Column(name: "tipo_servicio", type: "string", nullable: true)]
    private ?string $tipoServicio;

    #[Column(type: "string", nullable: true)]
    private ?string $horas;

    #[Column(type: "float", nullable: true)]
    private ?float $base;

    #[Column(name: "alicuota_iva", type: "float", nullable: true)]
    private ?float $alicuotaIva;

    #[Column(name: "monto_iva", type: "float", nullable: true)]
    private ?float $montoIva;

    #[Column(type: "float", nullable: true)]
    private ?float $total;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    public function __construct()
    {
        $this->activo = "S";
    }

    public function getNcostosTarifa(): int
    {
        return $this->ncostosTarifa;
    }

    public function setNcostosTarifa(int $value): static
    {
        $this->ncostosTarifa = $value;
        return $this;
    }

    public function getLocalidad(): ?string
    {
        return HtmlDecode($this->localidad);
    }

    public function setLocalidad(?string $value): static
    {
        $this->localidad = RemoveXss($value);
        return $this;
    }

    public function getTipoServicio(): ?string
    {
        return HtmlDecode($this->tipoServicio);
    }

    public function setTipoServicio(?string $value): static
    {
        $this->tipoServicio = RemoveXss($value);
        return $this;
    }

    public function getHoras(): ?string
    {
        return HtmlDecode($this->horas);
    }

    public function setHoras(?string $value): static
    {
        $this->horas = RemoveXss($value);
        return $this;
    }

    public function getBase(): ?float
    {
        return $this->base;
    }

    public function setBase(?float $value): static
    {
        $this->base = $value;
        return $this;
    }

    public function getAlicuotaIva(): ?float
    {
        return $this->alicuotaIva;
    }

    public function setAlicuotaIva(?float $value): static
    {
        $this->alicuotaIva = $value;
        return $this;
    }

    public function getMontoIva(): ?float
    {
        return $this->montoIva;
    }

    public function setMontoIva(?float $value): static
    {
        $this->montoIva = $value;
        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $value): static
    {
        $this->total = $value;
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
}
