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
 * Entity class for "sco_proveedor" table
 */
#[Entity]
#[Table(name: "sco_proveedor")]
class ScoProveedor extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nproveedor", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nproveedor;

    #[Column(type: "string")]
    private string $rif;

    #[Column(type: "string")]
    private string $nombre;

    #[Column(type: "string", nullable: true)]
    private ?string $sucursal;

    #[Column(type: "string", nullable: true)]
    private ?string $responsable;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono3;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono4;

    #[Column(type: "string", nullable: true)]
    private ?string $fax;

    #[Column(type: "string")]
    private string $correo;

    #[Column(name: "correo_adicional", type: "string", nullable: true)]
    private ?string $correoAdicional;

    #[Column(type: "integer")]
    private int $estado;

    #[Column(type: "string")]
    private string $localidad;

    #[Column(type: "string", nullable: true)]
    private ?string $direccion;

    #[Column(type: "text", nullable: true)]
    private ?string $observacion;

    #[Column(name: "tipo_proveedor", type: "string", nullable: true)]
    private ?string $tipoProveedor;

    #[Column(type: "string")]
    private string $activo;

    public function __construct()
    {
        $this->activo = "S";
    }

    public function getNproveedor(): int
    {
        return $this->nproveedor;
    }

    public function setNproveedor(int $value): static
    {
        $this->nproveedor = $value;
        return $this;
    }

    public function getRif(): string
    {
        return HtmlDecode($this->rif);
    }

    public function setRif(string $value): static
    {
        $this->rif = RemoveXss($value);
        return $this;
    }

    public function getNombre(): string
    {
        return HtmlDecode($this->nombre);
    }

    public function setNombre(string $value): static
    {
        $this->nombre = RemoveXss($value);
        return $this;
    }

    public function getSucursal(): ?string
    {
        return HtmlDecode($this->sucursal);
    }

    public function setSucursal(?string $value): static
    {
        $this->sucursal = RemoveXss($value);
        return $this;
    }

    public function getResponsable(): ?string
    {
        return HtmlDecode($this->responsable);
    }

    public function setResponsable(?string $value): static
    {
        $this->responsable = RemoveXss($value);
        return $this;
    }

    public function getTelefono1(): ?string
    {
        return HtmlDecode($this->telefono1);
    }

    public function setTelefono1(?string $value): static
    {
        $this->telefono1 = RemoveXss($value);
        return $this;
    }

    public function getTelefono2(): ?string
    {
        return HtmlDecode($this->telefono2);
    }

    public function setTelefono2(?string $value): static
    {
        $this->telefono2 = RemoveXss($value);
        return $this;
    }

    public function getTelefono3(): ?string
    {
        return HtmlDecode($this->telefono3);
    }

    public function setTelefono3(?string $value): static
    {
        $this->telefono3 = RemoveXss($value);
        return $this;
    }

    public function getTelefono4(): ?string
    {
        return HtmlDecode($this->telefono4);
    }

    public function setTelefono4(?string $value): static
    {
        $this->telefono4 = RemoveXss($value);
        return $this;
    }

    public function getFax(): ?string
    {
        return HtmlDecode($this->fax);
    }

    public function setFax(?string $value): static
    {
        $this->fax = RemoveXss($value);
        return $this;
    }

    public function getCorreo(): string
    {
        return HtmlDecode($this->correo);
    }

    public function setCorreo(string $value): static
    {
        $this->correo = RemoveXss($value);
        return $this;
    }

    public function getCorreoAdicional(): ?string
    {
        return HtmlDecode($this->correoAdicional);
    }

    public function setCorreoAdicional(?string $value): static
    {
        $this->correoAdicional = RemoveXss($value);
        return $this;
    }

    public function getEstado(): int
    {
        return $this->estado;
    }

    public function setEstado(int $value): static
    {
        $this->estado = $value;
        return $this;
    }

    public function getLocalidad(): string
    {
        return HtmlDecode($this->localidad);
    }

    public function setLocalidad(string $value): static
    {
        $this->localidad = RemoveXss($value);
        return $this;
    }

    public function getDireccion(): ?string
    {
        return HtmlDecode($this->direccion);
    }

    public function setDireccion(?string $value): static
    {
        $this->direccion = RemoveXss($value);
        return $this;
    }

    public function getObservacion(): ?string
    {
        return HtmlDecode($this->observacion);
    }

    public function setObservacion(?string $value): static
    {
        $this->observacion = RemoveXss($value);
        return $this;
    }

    public function getTipoProveedor(): ?string
    {
        return HtmlDecode($this->tipoProveedor);
    }

    public function setTipoProveedor(?string $value): static
    {
        $this->tipoProveedor = RemoveXss($value);
        return $this;
    }

    public function getActivo(): string
    {
        return $this->activo;
    }

    public function setActivo(string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'activo' value");
        }
        $this->activo = $value;
        return $this;
    }
}
