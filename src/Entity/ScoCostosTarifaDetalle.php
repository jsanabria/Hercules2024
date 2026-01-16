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
 * Entity class for "sco_costos_tarifa_detalle" table
 */
#[Entity]
#[Table(name: "sco_costos_tarifa_detalle")]
class ScoCostosTarifaDetalle extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ncostos_tarifa_detalle", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $ncostosTarifaDetalle;

    #[Column(name: "costos_tarifa", type: "integer", nullable: true)]
    private ?int $costosTarifa;

    #[Column(type: "string", nullable: true)]
    private ?string $cap;

    #[Column(type: "string", nullable: true)]
    private ?string $ata;

    #[Column(type: "string", nullable: true)]
    private ?string $obi;

    #[Column(type: "string", nullable: true)]
    private ?string $fot;

    #[Column(type: "string", nullable: true)]
    private ?string $man;

    #[Column(type: "string", nullable: true)]
    private ?string $gas;

    #[Column(type: "string", nullable: true)]
    private ?string $com;

    #[Column(type: "float", nullable: true)]
    private ?float $base;

    #[Column(name: "base_anterior", type: "float", nullable: true)]
    private ?float $baseAnterior;

    #[Column(type: "float", nullable: true)]
    private ?float $variacion;

    #[Column(type: "float", nullable: true)]
    private ?float $porcentaje;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $cerrado;

    public function __construct()
    {
        $this->cerrado = "N";
    }

    public function getNcostosTarifaDetalle(): string
    {
        return $this->ncostosTarifaDetalle;
    }

    public function setNcostosTarifaDetalle(string $value): static
    {
        $this->ncostosTarifaDetalle = $value;
        return $this;
    }

    public function getCostosTarifa(): ?int
    {
        return $this->costosTarifa;
    }

    public function setCostosTarifa(?int $value): static
    {
        $this->costosTarifa = $value;
        return $this;
    }

    public function getCap(): ?string
    {
        return HtmlDecode($this->cap);
    }

    public function setCap(?string $value): static
    {
        $this->cap = RemoveXss($value);
        return $this;
    }

    public function getAta(): ?string
    {
        return HtmlDecode($this->ata);
    }

    public function setAta(?string $value): static
    {
        $this->ata = RemoveXss($value);
        return $this;
    }

    public function getObi(): ?string
    {
        return HtmlDecode($this->obi);
    }

    public function setObi(?string $value): static
    {
        $this->obi = RemoveXss($value);
        return $this;
    }

    public function getFot(): ?string
    {
        return HtmlDecode($this->fot);
    }

    public function setFot(?string $value): static
    {
        $this->fot = RemoveXss($value);
        return $this;
    }

    public function getMan(): ?string
    {
        return HtmlDecode($this->man);
    }

    public function setMan(?string $value): static
    {
        $this->man = RemoveXss($value);
        return $this;
    }

    public function getGas(): ?string
    {
        return HtmlDecode($this->gas);
    }

    public function setGas(?string $value): static
    {
        $this->gas = RemoveXss($value);
        return $this;
    }

    public function getCom(): ?string
    {
        return HtmlDecode($this->com);
    }

    public function setCom(?string $value): static
    {
        $this->com = RemoveXss($value);
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

    public function getBaseAnterior(): ?float
    {
        return $this->baseAnterior;
    }

    public function setBaseAnterior(?float $value): static
    {
        $this->baseAnterior = $value;
        return $this;
    }

    public function getVariacion(): ?float
    {
        return $this->variacion;
    }

    public function setVariacion(?float $value): static
    {
        $this->variacion = $value;
        return $this;
    }

    public function getPorcentaje(): ?float
    {
        return $this->porcentaje;
    }

    public function setPorcentaje(?float $value): static
    {
        $this->porcentaje = $value;
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

    public function getCerrado(): ?string
    {
        return $this->cerrado;
    }

    public function setCerrado(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'cerrado' value");
        }
        $this->cerrado = $value;
        return $this;
    }
}
