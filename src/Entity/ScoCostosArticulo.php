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
 * Entity class for "sco_costos_articulos" table
 */
#[Entity]
#[Table(name: "sco_costos_articulos")]
class ScoCostosArticulo extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Id]
    #[Column(name: "Ncostos_articulo", type: "string", unique: true)]
    private string $ncostosArticulo;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "float", nullable: true)]
    private ?float $precio;

    #[Column(type: "float", nullable: true)]
    private ?float $variacion;

    #[Column(name: "tipo_hercules", type: "string", nullable: true)]
    private ?string $tipoHercules;

    #[Column(name: "articulo_hercules", type: "string", unique: true, nullable: true)]
    private ?string $articuloHercules;

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }

    public function getNcostosArticulo(): string
    {
        return $this->ncostosArticulo;
    }

    public function setNcostosArticulo(string $value): static
    {
        $this->ncostosArticulo = $value;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return HtmlDecode($this->descripcion);
    }

    public function setDescripcion(?string $value): static
    {
        $this->descripcion = RemoveXss($value);
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

    public function getVariacion(): ?float
    {
        return $this->variacion;
    }

    public function setVariacion(?float $value): static
    {
        $this->variacion = $value;
        return $this;
    }

    public function getTipoHercules(): ?string
    {
        return HtmlDecode($this->tipoHercules);
    }

    public function setTipoHercules(?string $value): static
    {
        $this->tipoHercules = RemoveXss($value);
        return $this;
    }

    public function getArticuloHercules(): ?string
    {
        return HtmlDecode($this->articuloHercules);
    }

    public function setArticuloHercules(?string $value): static
    {
        $this->articuloHercules = RemoveXss($value);
        return $this;
    }
}
