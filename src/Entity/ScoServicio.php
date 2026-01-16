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
 * Entity class for "sco_servicio" table
 */
#[Entity]
#[Table(name: "sco_servicio")]
class ScoServicio extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Id]
    #[Column(name: "Nservicio", type: "string", unique: true)]
    private string $nservicio;

    #[Column(type: "string", unique: true, nullable: true)]
    private ?string $nombre;

    #[Column(name: "articulo_inventario", type: "string", nullable: true)]
    private ?string $articuloInventario;

    #[Column(type: "integer", nullable: true)]
    private ?int $secuencia;

    #[Column(name: "sto_min", type: "integer", nullable: true)]
    private ?int $stoMin;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    #[Column(type: "string", nullable: true)]
    private ?string $venta;

    public function __construct()
    {
        $this->articuloInventario = "N";
        $this->secuencia = 0;
        $this->stoMin = 0;
        $this->activo = "S";
        $this->venta = "S";
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

    public function getNservicio(): string
    {
        return $this->nservicio;
    }

    public function setNservicio(string $value): static
    {
        $this->nservicio = $value;
        return $this;
    }

    public function getNombre(): ?string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(?string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getArticuloInventario(): ?string
    {
        return $this->articuloInventario;
    }

    public function setArticuloInventario(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'articulo_inventario' value");
        }
        $this->articuloInventario = $value;
        return $this;
    }

    public function getSecuencia(): ?int
    {
        return $this->secuencia;
    }

    public function setSecuencia(?int $value): static
    {
        $this->secuencia = $value;
        return $this;
    }

    public function getStoMin(): ?int
    {
        return $this->stoMin;
    }

    public function setStoMin(?int $value): static
    {
        $this->stoMin = $value;
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

    public function getVenta(): ?string
    {
        return $this->venta;
    }

    public function setVenta(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'venta' value");
        }
        $this->venta = $value;
        return $this;
    }
}
