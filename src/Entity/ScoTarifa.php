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
 * Entity class for "sco_tarifa" table
 */
#[Entity]
#[Table(name: "sco_tarifa")]
class ScoTarifa extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ntarifa", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $ntarifa;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string")]
    private string $servicio;

    #[Column(type: "integer")]
    private int $horas;

    #[Column(type: "float", nullable: true)]
    private ?float $precio;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $activo;

    #[Column(name: "crear_nuevo_precio", type: "string", nullable: true)]
    private ?string $crearNuevoPrecio;

    #[Column(name: "porc_recargo", type: "integer", nullable: true)]
    private ?int $porcRecargo;

    public function __construct()
    {
        $this->horas = 0;
        $this->activo = "S";
        $this->crearNuevoPrecio = "N";
        $this->porcRecargo = 0;
    }

    public function getNtarifa(): string
    {
        return $this->ntarifa;
    }

    public function setNtarifa(string $value): static
    {
        $this->ntarifa = $value;
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

    public function getServicio(): string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }

    public function getHoras(): int
    {
        return $this->horas;
    }

    public function setHoras(int $value): static
    {
        $this->horas = $value;
        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(?float $value): static
    {
        $this->precio = $value;
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

    public function getCrearNuevoPrecio(): ?string
    {
        return $this->crearNuevoPrecio;
    }

    public function setCrearNuevoPrecio(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'crear_nuevo_precio' value");
        }
        $this->crearNuevoPrecio = $value;
        return $this;
    }

    public function getPorcRecargo(): ?int
    {
        return $this->porcRecargo;
    }

    public function setPorcRecargo(?int $value): static
    {
        $this->porcRecargo = $value;
        return $this;
    }
}
