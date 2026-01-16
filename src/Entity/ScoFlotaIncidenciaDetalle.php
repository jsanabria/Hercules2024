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
 * Entity class for "sco_flota_incidencia_detalle" table
 */
#[Entity]
#[Table(name: "sco_flota_incidencia_detalle")]
class ScoFlotaIncidenciaDetalle extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nflota_incidencia_detalle", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nflotaIncidenciaDetalle;

    #[Column(name: "flota_incidencia", type: "integer")]
    private int $flotaIncidencia;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $archivo;

    #[Column(type: "integer", nullable: true)]
    private ?int $proveedor;

    #[Column(type: "float", nullable: true)]
    private ?float $costo;

    public function __construct()
    {
        $this->flotaIncidencia = 0;
        $this->costo = 0;
    }

    public function getNflotaIncidenciaDetalle(): string
    {
        return $this->nflotaIncidenciaDetalle;
    }

    public function setNflotaIncidenciaDetalle(string $value): static
    {
        $this->nflotaIncidenciaDetalle = $value;
        return $this;
    }

    public function getFlotaIncidencia(): int
    {
        return $this->flotaIncidencia;
    }

    public function setFlotaIncidencia(int $value): static
    {
        $this->flotaIncidencia = $value;
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

    public function getArchivo(): ?string
    {
        return HtmlDecode($this->archivo);
    }

    public function setArchivo(?string $value): static
    {
        $this->archivo = RemoveXss($value);
        return $this;
    }

    public function getProveedor(): ?int
    {
        return $this->proveedor;
    }

    public function setProveedor(?int $value): static
    {
        $this->proveedor = $value;
        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(?float $value): static
    {
        $this->costo = $value;
        return $this;
    }
}
