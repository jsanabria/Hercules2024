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
 * Entity class for "sco_entrada_salida_detalle" table
 */
#[Entity]
#[Table(name: "sco_entrada_salida_detalle")]
class ScoEntradaSalidaDetalle extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nentrada_salida_detalle", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nentradaSalidaDetalle;

    #[Column(name: "entrada_salida", type: "bigint", nullable: true)]
    private ?string $entradaSalida;

    #[Column(name: "tipo_doc", type: "string", nullable: true)]
    private ?string $tipoDoc;

    #[Column(type: "integer", nullable: true)]
    private ?int $proveedor;

    #[Column(type: "string", nullable: true)]
    private ?string $articulo;

    #[Column(type: "integer", nullable: true)]
    private ?int $cantidad;

    #[Column(type: "float", nullable: true)]
    private ?float $costo;

    #[Column(type: "float", nullable: true)]
    private ?float $total;

    public function __construct()
    {
        $this->cantidad = 0;
        $this->costo = 0;
        $this->total = 0;
    }

    public function getNentradaSalidaDetalle(): string
    {
        return $this->nentradaSalidaDetalle;
    }

    public function setNentradaSalidaDetalle(string $value): static
    {
        $this->nentradaSalidaDetalle = $value;
        return $this;
    }

    public function getEntradaSalida(): ?string
    {
        return $this->entradaSalida;
    }

    public function setEntradaSalida(?string $value): static
    {
        $this->entradaSalida = $value;
        return $this;
    }

    public function getTipoDoc(): ?string
    {
        return HtmlDecode($this->tipoDoc);
    }

    public function setTipoDoc(?string $value): static
    {
        $this->tipoDoc = RemoveXss($value);
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

    public function getArticulo(): ?string
    {
        return HtmlDecode($this->articulo);
    }

    public function setArticulo(?string $value): static
    {
        $this->articulo = RemoveXss($value);
        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(?int $value): static
    {
        $this->cantidad = $value;
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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $value): static
    {
        $this->total = $value;
        return $this;
    }
}
