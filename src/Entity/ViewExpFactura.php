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
 * Entity class for "view_exp_factura" table
 */
#[Entity]
#[Table(name: "view_exp_factura")]
class ViewExpFactura extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $cia;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Id]
    #[Column(name: "Nexpediente", type: "string", nullable: true)]
    private ?string $nexpediente;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "nombre_fallecido", type: "string", nullable: true)]
    private ?string $nombreFallecido;

    #[Column(name: "apellidos_fallecido", type: "string", nullable: true)]
    private ?string $apellidosFallecido;

    #[Column(type: "string", nullable: true)]
    private ?string $factura;

    #[Column(type: "float", nullable: true)]
    private ?float $monto;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function getCia(): ?string
    {
        return HtmlDecode($this->cia);
    }

    public function setCia(?string $value): static
    {
        $this->cia = RemoveXss($value);
        return $this;
    }

    public function getServicioTipo(): ?string
    {
        return HtmlDecode($this->servicioTipo);
    }

    public function setServicioTipo(?string $value): static
    {
        $this->servicioTipo = RemoveXss($value);
        return $this;
    }

    public function getNexpediente(): ?string
    {
        return $this->nexpediente;
    }

    public function setNexpediente(?string $value): static
    {
        $this->nexpediente = $value;
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

    public function getNombreFallecido(): ?string
    {
        return HtmlDecode($this->nombreFallecido);
    }

    public function setNombreFallecido(?string $value): static
    {
        $this->nombreFallecido = RemoveXss($value);
        return $this;
    }

    public function getApellidosFallecido(): ?string
    {
        return HtmlDecode($this->apellidosFallecido);
    }

    public function setApellidosFallecido(?string $value): static
    {
        $this->apellidosFallecido = RemoveXss($value);
        return $this;
    }

    public function getFactura(): ?string
    {
        return HtmlDecode($this->factura);
    }

    public function setFactura(?string $value): static
    {
        $this->factura = RemoveXss($value);
        return $this;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(?float $value): static
    {
        $this->monto = $value;
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

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
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
