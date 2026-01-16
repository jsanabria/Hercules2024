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
 * Entity class for "sco_flota_incidencia" table
 */
#[Entity]
#[Table(name: "sco_flota_incidencia")]
class ScoFlotaIncidencia extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nflota_incidencia", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nflotaIncidencia;

    #[Column(name: "fecha_registro", type: "date", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(type: "integer", nullable: true)]
    private ?int $flota;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $falla;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $solicitante;

    #[Column(type: "string", nullable: true)]
    private ?string $diagnostico;

    #[Column(type: "string", nullable: true)]
    private ?string $reparacion;

    #[Column(name: "cambio_aceite", type: "string", nullable: true)]
    private ?string $cambioAceite;

    #[Column(type: "integer", nullable: true)]
    private ?int $kilometraje;

    #[Column(type: "integer", nullable: true)]
    private ?int $cantidad;

    #[Column(type: "integer", nullable: true)]
    private ?int $proveedor;

    #[Column(type: "float", nullable: true)]
    private ?float $monto;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(name: "username_diagnostica", type: "string", nullable: true)]
    private ?string $usernameDiagnostica;

    #[Column(name: "fecha_reparacion", type: "date", nullable: true)]
    private ?DateTime $fechaReparacion;

    public function __construct()
    {
        $this->cambioAceite = "N";
    }

    public function getNflotaIncidencia(): string
    {
        return $this->nflotaIncidencia;
    }

    public function setNflotaIncidencia(string $value): static
    {
        $this->nflotaIncidencia = $value;
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

    public function getFlota(): ?int
    {
        return $this->flota;
    }

    public function setFlota(?int $value): static
    {
        $this->flota = $value;
        return $this;
    }

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
        return $this;
    }

    public function getFalla(): ?string
    {
        return HtmlDecode($this->falla);
    }

    public function setFalla(?string $value): static
    {
        $this->falla = RemoveXss($value);
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

    public function getSolicitante(): ?string
    {
        return HtmlDecode($this->solicitante);
    }

    public function setSolicitante(?string $value): static
    {
        $this->solicitante = RemoveXss($value);
        return $this;
    }

    public function getDiagnostico(): ?string
    {
        return HtmlDecode($this->diagnostico);
    }

    public function setDiagnostico(?string $value): static
    {
        $this->diagnostico = RemoveXss($value);
        return $this;
    }

    public function getReparacion(): ?string
    {
        return HtmlDecode($this->reparacion);
    }

    public function setReparacion(?string $value): static
    {
        $this->reparacion = RemoveXss($value);
        return $this;
    }

    public function getCambioAceite(): ?string
    {
        return $this->cambioAceite;
    }

    public function setCambioAceite(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'cambio_aceite' value");
        }
        $this->cambioAceite = $value;
        return $this;
    }

    public function getKilometraje(): ?int
    {
        return $this->kilometraje;
    }

    public function setKilometraje(?int $value): static
    {
        $this->kilometraje = $value;
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

    public function getProveedor(): ?int
    {
        return $this->proveedor;
    }

    public function setProveedor(?int $value): static
    {
        $this->proveedor = $value;
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

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getUsernameDiagnostica(): ?string
    {
        return HtmlDecode($this->usernameDiagnostica);
    }

    public function setUsernameDiagnostica(?string $value): static
    {
        $this->usernameDiagnostica = RemoveXss($value);
        return $this;
    }

    public function getFechaReparacion(): ?DateTime
    {
        return $this->fechaReparacion;
    }

    public function setFechaReparacion(?DateTime $value): static
    {
        $this->fechaReparacion = $value;
        return $this;
    }
}
