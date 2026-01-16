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
 * Entity class for "view_orden_compra" table
 */
#[Entity]
#[Table(name: "view_orden_compra")]
class ViewOrdenCompra extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden_compra", type: "integer")]
    #[GeneratedValue]
    private int $nordenCompra;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    #[Column(name: "unidad_solicitante", type: "string", nullable: true)]
    private ?string $unidadSolicitante;

    #[Column(type: "text", nullable: true)]
    private ?string $nota;

    #[Column(name: "tipo_insumo", type: "string", nullable: true)]
    private ?string $tipoInsumo;

    #[Column(type: "string", nullable: true)]
    private ?string $articulo;

    #[Column(type: "float", nullable: true)]
    private ?float $cantidad;

    #[Column(name: "cantidad_recibida", type: "float", nullable: true)]
    private ?float $cantidadRecibida;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function getNordenCompra(): int
    {
        return $this->nordenCompra;
    }

    public function setNordenCompra(int $value): static
    {
        $this->nordenCompra = $value;
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

    public function getUnidadSolicitante(): ?string
    {
        return HtmlDecode($this->unidadSolicitante);
    }

    public function setUnidadSolicitante(?string $value): static
    {
        $this->unidadSolicitante = RemoveXss($value);
        return $this;
    }

    public function getNota(): ?string
    {
        return HtmlDecode($this->nota);
    }

    public function setNota(?string $value): static
    {
        $this->nota = RemoveXss($value);
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

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(?float $value): static
    {
        $this->cantidad = $value;
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

    public function getEstatus(): ?string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(?string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }
}
