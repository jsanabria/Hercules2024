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
 * Entity class for "sco_grama" table
 */
#[Entity]
#[Table(name: "sco_grama")]
class ScoGrama extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ngrama", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $ngrama;

    #[Column(name: "ci_solicitante", type: "string", nullable: true)]
    private ?string $ciSolicitante;

    #[Column(type: "string", nullable: true)]
    private ?string $solicitante;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono1;

    #[Column(type: "string", nullable: true)]
    private ?string $telefono2;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $subtipo;

    #[Column(type: "decimal", nullable: true)]
    private ?string $monto;

    #[Column(type: "decimal")]
    private string $tasa;

    #[Column(name: "monto_bs", type: "decimal")]
    private string $montoBs;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $contrato;

    #[Column(type: "string", nullable: true)]
    private ?string $seccion;

    #[Column(type: "string", nullable: true)]
    private ?string $modulo;

    #[Column(name: "sub_seccion", type: "string", nullable: true)]
    private ?string $subSeccion;

    #[Column(type: "string", nullable: true)]
    private ?string $parcela;

    #[Column(type: "string", nullable: true)]
    private ?string $boveda;

    #[Column(name: "ci_difunto", type: "string", nullable: true)]
    private ?string $ciDifunto;

    #[Column(type: "string", nullable: true)]
    private ?string $apellido1;

    #[Column(type: "string", nullable: true)]
    private ?string $apellido2;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre1;

    #[Column(type: "string", nullable: true)]
    private ?string $nombre2;

    #[Column(name: "fecha_solucion", type: "datetime", nullable: true)]
    private ?DateTime $fechaSolucion;

    #[Column(name: "fecha_desde", type: "datetime", nullable: true)]
    private ?DateTime $fechaDesde;

    #[Column(name: "fecha_hasta", type: "datetime", nullable: true)]
    private ?DateTime $fechaHasta;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(name: "fecha_registro", type: "datetime", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "usuario_registro", type: "string", nullable: true)]
    private ?string $usuarioRegistro;

    #[Column(name: "email_renovacion", type: "string", nullable: true)]
    private ?string $emailRenovacion;

    public function __construct()
    {
        $this->emailRenovacion = "N";
    }

    public function getNgrama(): string
    {
        return $this->ngrama;
    }

    public function setNgrama(string $value): static
    {
        $this->ngrama = $value;
        return $this;
    }

    public function getCiSolicitante(): ?string
    {
        return HtmlDecode($this->ciSolicitante);
    }

    public function setCiSolicitante(?string $value): static
    {
        $this->ciSolicitante = RemoveXss($value);
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

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
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

    public function getSubtipo(): ?string
    {
        return HtmlDecode($this->subtipo);
    }

    public function setSubtipo(?string $value): static
    {
        $this->subtipo = RemoveXss($value);
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

    public function getTasa(): string
    {
        return $this->tasa;
    }

    public function setTasa(string $value): static
    {
        $this->tasa = $value;
        return $this;
    }

    public function getMontoBs(): string
    {
        return $this->montoBs;
    }

    public function setMontoBs(string $value): static
    {
        $this->montoBs = $value;
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

    public function getContrato(): ?string
    {
        return HtmlDecode($this->contrato);
    }

    public function setContrato(?string $value): static
    {
        $this->contrato = RemoveXss($value);
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

    public function getSubSeccion(): ?string
    {
        return HtmlDecode($this->subSeccion);
    }

    public function setSubSeccion(?string $value): static
    {
        $this->subSeccion = RemoveXss($value);
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

    public function getBoveda(): ?string
    {
        return HtmlDecode($this->boveda);
    }

    public function setBoveda(?string $value): static
    {
        $this->boveda = RemoveXss($value);
        return $this;
    }

    public function getCiDifunto(): ?string
    {
        return HtmlDecode($this->ciDifunto);
    }

    public function setCiDifunto(?string $value): static
    {
        $this->ciDifunto = RemoveXss($value);
        return $this;
    }

    public function getApellido1(): ?string
    {
        return HtmlDecode($this->apellido1);
    }

    public function setApellido1(?string $value): static
    {
        $this->apellido1 = RemoveXss($value);
        return $this;
    }

    public function getApellido2(): ?string
    {
        return HtmlDecode($this->apellido2);
    }

    public function setApellido2(?string $value): static
    {
        $this->apellido2 = RemoveXss($value);
        return $this;
    }

    public function getNombre1(): ?string
    {
        return HtmlDecode($this->nombre1);
    }

    public function setNombre1(?string $value): static
    {
        $this->nombre1 = RemoveXss($value);
        return $this;
    }

    public function getNombre2(): ?string
    {
        return HtmlDecode($this->nombre2);
    }

    public function setNombre2(?string $value): static
    {
        $this->nombre2 = RemoveXss($value);
        return $this;
    }

    public function getFechaSolucion(): ?DateTime
    {
        return $this->fechaSolucion;
    }

    public function setFechaSolucion(?DateTime $value): static
    {
        $this->fechaSolucion = $value;
        return $this;
    }

    public function getFechaDesde(): ?DateTime
    {
        return $this->fechaDesde;
    }

    public function setFechaDesde(?DateTime $value): static
    {
        $this->fechaDesde = $value;
        return $this;
    }

    public function getFechaHasta(): ?DateTime
    {
        return $this->fechaHasta;
    }

    public function setFechaHasta(?DateTime $value): static
    {
        $this->fechaHasta = $value;
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

    public function getUsuarioRegistro(): ?string
    {
        return HtmlDecode($this->usuarioRegistro);
    }

    public function setUsuarioRegistro(?string $value): static
    {
        $this->usuarioRegistro = RemoveXss($value);
        return $this;
    }

    public function getEmailRenovacion(): ?string
    {
        return $this->emailRenovacion;
    }

    public function setEmailRenovacion(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'email_renovacion' value");
        }
        $this->emailRenovacion = $value;
        return $this;
    }
}
