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
 * Entity class for "sco_orden_compra" table
 */
#[Entity]
#[Table(name: "sco_orden_compra")]
class ScoOrdenCompra extends AbstractEntity
{
    #[Id]
    #[Column(name: "Norden_compra", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nordenCompra;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    #[Column(name: "tipo_proveedor", type: "string", nullable: true)]
    private ?string $tipoProveedor;

    #[Column(type: "integer", nullable: true)]
    private ?int $proveedor;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(name: "unidad_solicitante", type: "string", nullable: true)]
    private ?string $unidadSolicitante;

    #[Column(type: "text", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(name: "username_estatus", type: "string", nullable: true)]
    private ?string $usernameEstatus;

    #[Column(name: "fecha_aprobacion", type: "datetime", nullable: true)]
    private ?DateTime $fechaAprobacion;

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

    public function getTipoProveedor(): ?string
    {
        return HtmlDecode($this->tipoProveedor);
    }

    public function setTipoProveedor(?string $value): static
    {
        $this->tipoProveedor = RemoveXss($value);
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

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
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

    public function getEstatus(): ?string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(?string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }

    public function getUsernameEstatus(): ?string
    {
        return HtmlDecode($this->usernameEstatus);
    }

    public function setUsernameEstatus(?string $value): static
    {
        $this->usernameEstatus = RemoveXss($value);
        return $this;
    }

    public function getFechaAprobacion(): ?DateTime
    {
        return $this->fechaAprobacion;
    }

    public function setFechaAprobacion(?DateTime $value): static
    {
        $this->fechaAprobacion = $value;
        return $this;
    }
}
