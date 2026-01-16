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
 * Entity class for "view_exp_mascota" table
 */
#[Entity]
#[Table(name: "view_exp_mascota")]
class ViewExpMascota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmascota", type: "bigint")]
    #[GeneratedValue]
    private string $nmascota;

    #[Column(name: "nombre_contratante", type: "string", nullable: true)]
    private ?string $nombreContratante;

    #[Column(name: "cedula_contratante", type: "string", nullable: true)]
    private ?string $cedulaContratante;

    #[Column(name: "nombre_mascota", type: "string", nullable: true)]
    private ?string $nombreMascota;

    #[Column(type: "string", nullable: true)]
    private ?string $factura;

    #[Column(type: "float", nullable: true)]
    private ?float $costo;

    #[Column(type: "float", nullable: true)]
    private ?float $tasa;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    public function getNmascota(): string
    {
        return $this->nmascota;
    }

    public function setNmascota(string $value): static
    {
        $this->nmascota = $value;
        return $this;
    }

    public function getNombreContratante(): ?string
    {
        return HtmlDecode($this->nombreContratante);
    }

    public function setNombreContratante(?string $value): static
    {
        $this->nombreContratante = RemoveXss($value);
        return $this;
    }

    public function getCedulaContratante(): ?string
    {
        return HtmlDecode($this->cedulaContratante);
    }

    public function setCedulaContratante(?string $value): static
    {
        $this->cedulaContratante = RemoveXss($value);
        return $this;
    }

    public function getNombreMascota(): ?string
    {
        return HtmlDecode($this->nombreMascota);
    }

    public function setNombreMascota(?string $value): static
    {
        $this->nombreMascota = RemoveXss($value);
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

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(?float $value): static
    {
        $this->costo = $value;
        return $this;
    }

    public function getTasa(): ?float
    {
        return $this->tasa;
    }

    public function setTasa(?float $value): static
    {
        $this->tasa = $value;
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
}
