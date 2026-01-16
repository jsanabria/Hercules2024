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
 * Entity class for "sco_expediente_cia" table
 */
#[Entity]
#[Table(name: "sco_expediente_cia")]
class ScoExpedienteCia extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente_cia", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nexpedienteCia;

    #[Column(type: "integer", nullable: true)]
    private ?int $cia;

    #[Column(type: "integer", nullable: true)]
    private ?int $expediente;

    #[Column(name: "servicio_tipo", type: "string")]
    private string $servicioTipo;

    #[Column(type: "string", nullable: true)]
    private ?string $factura;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "decimal", nullable: true)]
    private ?string $monto;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "integer", nullable: true)]
    private ?int $estatus;

    public function __construct()
    {
        $this->estatus = 0;
    }

    public function getNexpedienteCia(): int
    {
        return $this->nexpedienteCia;
    }

    public function setNexpedienteCia(int $value): static
    {
        $this->nexpedienteCia = $value;
        return $this;
    }

    public function getCia(): ?int
    {
        return $this->cia;
    }

    public function setCia(?int $value): static
    {
        $this->cia = $value;
        return $this;
    }

    public function getExpediente(): ?int
    {
        return $this->expediente;
    }

    public function setExpediente(?int $value): static
    {
        $this->expediente = $value;
        return $this;
    }

    public function getServicioTipo(): string
    {
        return HtmlDecode($this->servicioTipo);
    }

    public function setServicioTipo(string $value): static
    {
        $this->servicioTipo = RemoveXss($value);
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

    public function getFecha(): ?DateTime
    {
        return $this->fecha;
    }

    public function setFecha(?DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(?string $value): static
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

    public function getEstatus(): ?int
    {
        return $this->estatus;
    }

    public function setEstatus(?int $value): static
    {
        $this->estatus = $value;
        return $this;
    }
}
