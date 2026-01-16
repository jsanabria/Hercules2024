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
 * Entity class for "sco_costos" table
 */
#[Entity]
#[Table(name: "sco_costos")]
class ScoCosto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ncostos", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $ncostos;

    #[Column(type: "bigint")]
    private string $id;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(name: "costos_articulos", type: "string", nullable: true)]
    private ?string $costosArticulos;

    #[Column(name: "precio_actual", type: "float", nullable: true)]
    private ?float $precioActual;

    #[Column(name: "porcentaje_aplicado", type: "float", nullable: true)]
    private ?float $porcentajeAplicado;

    #[Column(name: "precio_nuevo", type: "float", nullable: true)]
    private ?float $precioNuevo;

    #[Column(name: "alicuota_iva", type: "float", nullable: true)]
    private ?float $alicuotaIva;

    #[Column(name: "monto_iva", type: "float", nullable: true)]
    private ?float $montoIva;

    #[Column(type: "float", nullable: true)]
    private ?float $total;

    #[Column(type: "string", nullable: true)]
    private ?string $cerrado;

    public function __construct()
    {
        $this->id = "0";
        $this->precioActual = 0;
        $this->porcentajeAplicado = 0;
        $this->precioNuevo = 0;
        $this->alicuotaIva = 0;
        $this->montoIva = 0;
        $this->total = 0;
        $this->cerrado = "N";
    }

    public function getNcostos(): string
    {
        return $this->ncostos;
    }

    public function setNcostos(string $value): static
    {
        $this->ncostos = $value;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): static
    {
        $this->id = $value;
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

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }

    public function getCostosArticulos(): ?string
    {
        return HtmlDecode($this->costosArticulos);
    }

    public function setCostosArticulos(?string $value): static
    {
        $this->costosArticulos = RemoveXss($value);
        return $this;
    }

    public function getPrecioActual(): ?float
    {
        return $this->precioActual;
    }

    public function setPrecioActual(?float $value): static
    {
        $this->precioActual = $value;
        return $this;
    }

    public function getPorcentajeAplicado(): ?float
    {
        return $this->porcentajeAplicado;
    }

    public function setPorcentajeAplicado(?float $value): static
    {
        $this->porcentajeAplicado = $value;
        return $this;
    }

    public function getPrecioNuevo(): ?float
    {
        return $this->precioNuevo;
    }

    public function setPrecioNuevo(?float $value): static
    {
        $this->precioNuevo = $value;
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
