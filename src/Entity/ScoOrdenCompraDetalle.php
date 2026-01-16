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
 * Entity class for "sco_orden_compra_detalle" table
 */
#[Entity]
#[Table(name: "sco_orden_compra_detalle")]
class ScoOrdenCompraDetalle extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden_compra_detalle", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nordenCompraDetalle;

    #[Column(name: "orden_compra", type: "integer", nullable: true)]
    private ?int $ordenCompra;

    #[Column(name: "tipo_insumo", type: "string", nullable: true)]
    private ?string $tipoInsumo;

    #[Column(type: "string", nullable: true)]
    private ?string $articulo;

    #[Column(name: "unidad_medida", type: "string", nullable: true)]
    private ?string $unidadMedida;

    #[Column(type: "float", nullable: true)]
    private ?float $cantidad;

    #[Column(type: "string", nullable: true)]
    private ?string $descripcion;

    #[Column(type: "string", nullable: true)]
    private ?string $imagen;

    #[Column(type: "string", nullable: true)]
    private ?string $disponible;

    #[Column(name: "unidad_medida_recibida", type: "string", nullable: true)]
    private ?string $unidadMedidaRecibida;

    #[Column(name: "cantidad_recibida", type: "float", nullable: true)]
    private ?float $cantidadRecibida;

    public function __construct()
    {
        $this->disponible = "N";
    }

    public function getNordenCompraDetalle(): int
    {
        return $this->nordenCompraDetalle;
    }

    public function setNordenCompraDetalle(int $value): static
    {
        $this->nordenCompraDetalle = $value;
        return $this;
    }

    public function getOrdenCompra(): ?int
    {
        return $this->ordenCompra;
    }

    public function setOrdenCompra(?int $value): static
    {
        $this->ordenCompra = $value;
        return $this;
    }

    public function getTipoInsumo(): ?string
    {
        return HtmlDecode($this->tipoInsumo);
    }

    public function setTipoInsumo(?string $value): static
    {
        $this->tipoInsumo = RemoveXss($value);
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

    public function getUnidadMedida(): ?string
    {
        return HtmlDecode($this->unidadMedida);
    }

    public function setUnidadMedida(?string $value): static
    {
        $this->unidadMedida = RemoveXss($value);
        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(?float $value): static
    {
        $this->cantidad = $value;
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

    public function getImagen(): ?string
    {
        return HtmlDecode($this->imagen);
    }

    public function setImagen(?string $value): static
    {
        $this->imagen = RemoveXss($value);
        return $this;
    }

    public function getDisponible(): ?string
    {
        return $this->disponible;
    }

    public function setDisponible(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'disponible' value");
        }
        $this->disponible = $value;
        return $this;
    }

    public function getUnidadMedidaRecibida(): ?string
    {
        return HtmlDecode($this->unidadMedidaRecibida);
    }

    public function setUnidadMedidaRecibida(?string $value): static
    {
        $this->unidadMedidaRecibida = RemoveXss($value);
        return $this;
    }

    public function getCantidadRecibida(): ?float
    {
        return $this->cantidadRecibida;
    }

    public function setCantidadRecibida(?float $value): static
    {
        $this->cantidadRecibida = $value;
        return $this;
    }
}
