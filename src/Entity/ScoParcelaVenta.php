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
 * Entity class for "sco_parcela_ventas" table
 */
#[Entity]
#[Table(name: "sco_parcela_ventas")]
class ScoParcelaVenta extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nparcela_ventas", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nparcelaVentas;

    #[Column(name: "fecha_compra", type: "date", nullable: true)]
    private ?DateTime $fechaCompra;

    #[Column(name: "usuario_compra", type: "string", nullable: true)]
    private ?string $usuarioCompra;

    #[Column(type: "string", nullable: true)]
    private ?string $terraza;

    #[Column(type: "string", nullable: true)]
    private ?string $seccion;

    #[Column(type: "string", nullable: true)]
    private ?string $modulo;

    #[Column(type: "string", nullable: true)]
    private ?string $subseccion;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    #[Column(name: "ci_vendedor", type: "string", nullable: true)]
    private ?string $ciVendedor;

    #[Column(type: "string", nullable: true)]
    private ?string $vendedor;

    #[Column(name: "valor_compra", type: "decimal", nullable: true)]
    private ?string $valorCompra;

    #[Column(name: "moneda_compra", type: "string", nullable: true)]
    private ?string $monedaCompra;

    #[Column(name: "tasa_compra", type: "decimal", nullable: true)]
    private ?string $tasaCompra;

    #[Column(name: "fecha_venta", type: "date", nullable: true)]
    private ?DateTime $fechaVenta;

    #[Column(name: "usuario_vende", type: "string", nullable: true)]
    private ?string $usuarioVende;

    #[Column(name: "ci_comprador", type: "string", nullable: true)]
    private ?string $ciComprador;

    #[Column(type: "string", nullable: true)]
    private ?string $comprador;

    #[Column(name: "valor_venta", type: "decimal", nullable: true)]
    private ?string $valorVenta;

    #[Column(name: "moneda_venta", type: "string", nullable: true)]
    private ?string $monedaVenta;

    #[Column(name: "tasa_venta", type: "decimal", nullable: true)]
    private ?string $tasaVenta;

    #[Column(name: "id_parcela", type: "string", nullable: true)]
    private ?string $idParcela;

    #[Column(type: "text", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "numero_factura", type: "string", nullable: true)]
    private ?string $numeroFactura;

    #[Column(name: "orden_pago", type: "string", nullable: true)]
    private ?string $ordenPago;

    public function getNparcelaVentas(): int
    {
        return $this->nparcelaVentas;
    }

    public function setNparcelaVentas(int $value): static
    {
        $this->nparcelaVentas = $value;
        return $this;
    }

    public function getFechaCompra(): ?DateTime
    {
        return $this->fechaCompra;
    }

    public function setFechaCompra(?DateTime $value): static
    {
        $this->fechaCompra = $value;
        return $this;
    }

    public function getUsuarioCompra(): ?string
    {
        return HtmlDecode($this->usuarioCompra);
    }

    public function setUsuarioCompra(?string $value): static
    {
        $this->usuarioCompra = RemoveXss($value);
        return $this;
    }

    public function getTerraza(): ?string
    {
        return HtmlDecode($this->terraza);
    }

    public function setTerraza(?string $value): static
    {
        $this->terraza = RemoveXss($value);
        return $this;
    }

    public function getSeccion(): ?string
    {
        return HtmlDecode($this->seccion);
    }

    public function setSeccion(?string $value): static
    {
        $this->seccion = RemoveXss($value);
        return $this;
    }

    public function getModulo(): ?string
    {
        return HtmlDecode($this->modulo);
    }

    public function setModulo(?string $value): static
    {
        $this->modulo = RemoveXss($value);
        return $this;
    }

    public function getSubseccion(): ?string
    {
        return HtmlDecode($this->subseccion);
    }

    public function setSubseccion(?string $value): static
    {
        $this->subseccion = RemoveXss($value);
        return $this;
    }

    public function getParcela(): ?string
    {
        return HtmlDecode($this->parcela);
    }

    public function setParcela(?string $value): static
    {
        $this->parcela = RemoveXss($value);
        return $this;
    }

    public function getCiVendedor(): ?string
    {
        return HtmlDecode($this->ciVendedor);
    }

    public function setCiVendedor(?string $value): static
    {
        $this->ciVendedor = RemoveXss($value);
        return $this;
    }

    public function getVendedor(): ?string
    {
        return HtmlDecode($this->vendedor);
    }

    public function setVendedor(?string $value): static
    {
        $this->vendedor = RemoveXss($value);
        return $this;
    }

    public function getValorCompra(): ?string
    {
        return $this->valorCompra;
    }

    public function setValorCompra(?string $value): static
    {
        $this->valorCompra = $value;
        return $this;
    }

    public function getMonedaCompra(): ?string
    {
        return HtmlDecode($this->monedaCompra);
    }

    public function setMonedaCompra(?string $value): static
    {
        $this->monedaCompra = RemoveXss($value);
        return $this;
    }

    public function getTasaCompra(): ?string
    {
        return $this->tasaCompra;
    }

    public function setTasaCompra(?string $value): static
    {
        $this->tasaCompra = $value;
        return $this;
    }

    public function getFechaVenta(): ?DateTime
    {
        return $this->fechaVenta;
    }

    public function setFechaVenta(?DateTime $value): static
    {
        $this->fechaVenta = $value;
        return $this;
    }

    public function getUsuarioVende(): ?string
    {
        return HtmlDecode($this->usuarioVende);
    }

    public function setUsuarioVende(?string $value): static
    {
        $this->usuarioVende = RemoveXss($value);
        return $this;
    }

    public function getCiComprador(): ?string
    {
        return HtmlDecode($this->ciComprador);
    }

    public function setCiComprador(?string $value): static
    {
        $this->ciComprador = RemoveXss($value);
        return $this;
    }

    public function getComprador(): ?string
    {
        return HtmlDecode($this->comprador);
    }

    public function setComprador(?string $value): static
    {
        $this->comprador = RemoveXss($value);
        return $this;
    }

    public function getValorVenta(): ?string
    {
        return $this->valorVenta;
    }

    public function setValorVenta(?string $value): static
    {
        $this->valorVenta = $value;
        return $this;
    }

    public function getMonedaVenta(): ?string
    {
        return HtmlDecode($this->monedaVenta);
    }

    public function setMonedaVenta(?string $value): static
    {
        $this->monedaVenta = RemoveXss($value);
        return $this;
    }

    public function getTasaVenta(): ?string
    {
        return $this->tasaVenta;
    }

    public function setTasaVenta(?string $value): static
    {
        $this->tasaVenta = $value;
        return $this;
    }

    public function getIdParcela(): ?string
    {
        return HtmlDecode($this->idParcela);
    }

    public function setIdParcela(?string $value): static
    {
        $this->idParcela = RemoveXss($value);
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

    public function getEstatus(): ?string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(?string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }

    public function getFechaRegistro(): ?DateTime
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?DateTime $value): static
    {
        $this->fechaRegistro = $value;
        return $this;
    }

    public function getNumeroFactura(): ?string
    {
        return HtmlDecode($this->numeroFactura);
    }

    public function setNumeroFactura(?string $value): static
    {
        $this->numeroFactura = RemoveXss($value);
        return $this;
    }

    public function getOrdenPago(): ?string
    {
        return HtmlDecode($this->ordenPago);
    }

    public function setOrdenPago(?string $value): static
    {
        $this->ordenPago = RemoveXss($value);
        return $this;
    }
}
