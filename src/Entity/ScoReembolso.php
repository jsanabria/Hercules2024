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
 * Entity class for "sco_reembolso" table
 */
#[Entity]
#[Table(name: "sco_reembolso")]
class ScoReembolso extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nreembolso", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nreembolso;

    #[Column(type: "bigint", nullable: true)]
    private ?string $expediente;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(name: "monto_usd", type: "decimal", nullable: true)]
    private ?string $montoUsd;

    #[Column(name: "fecha_tasa", type: "date", nullable: true)]
    private ?DateTime $fechaTasa;

    #[Column(type: "decimal", nullable: true)]
    private ?string $tasa;

    #[Column(name: "monto_bs", type: "decimal", nullable: true)]
    private ?string $montoBs;

    #[Column(type: "string", nullable: true)]
    private ?string $banco;

    #[Column(name: "nro_cta", type: "string", nullable: true)]
    private ?string $nroCta;

    #[Column(type: "string", nullable: true)]
    private ?string $titular;

    #[Column(name: "ci_rif", type: "string", nullable: true)]
    private ?string $ciRif;

    #[Column(type: "string", nullable: true)]
    private ?string $correo;

    #[Column(name: "nro_ref", type: "string", nullable: true)]
    private ?string $nroRef;

    #[Column(type: "string", nullable: true)]
    private ?string $motivo;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    #[Column(type: "string", nullable: true)]
    private ?string $coordinador;

    #[Column(type: "string", nullable: true)]
    private ?string $pagador;

    #[Column(name: "fecha_pago", type: "date", nullable: true)]
    private ?DateTime $fechaPago;

    #[Column(name: "email_enviado", type: "string", nullable: true)]
    private ?string $emailEnviado;

    public function __construct()
    {
        $this->emailEnviado = "N";
    }

    public function getNreembolso(): string
    {
        return $this->nreembolso;
    }

    public function setNreembolso(string $value): static
    {
        $this->nreembolso = $value;
        return $this;
    }

    public function getExpediente(): ?string
    {
        return $this->expediente;
    }

    public function setExpediente(?string $value): static
    {
        $this->expediente = $value;
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

    public function getMontoUsd(): ?string
    {
        return $this->montoUsd;
    }

    public function setMontoUsd(?string $value): static
    {
        $this->montoUsd = $value;
        return $this;
    }

    public function getFechaTasa(): ?DateTime
    {
        return $this->fechaTasa;
    }

    public function setFechaTasa(?DateTime $value): static
    {
        $this->fechaTasa = $value;
        return $this;
    }

    public function getTasa(): ?string
    {
        return $this->tasa;
    }

    public function setTasa(?string $value): static
    {
        $this->tasa = $value;
        return $this;
    }

    public function getMontoBs(): ?string
    {
        return $this->montoBs;
    }

    public function setMontoBs(?string $value): static
    {
        $this->montoBs = $value;
        return $this;
    }

    public function getBanco(): ?string
    {
        return HtmlDecode($this->banco);
    }

    public function setBanco(?string $value): static
    {
        $this->banco = RemoveXss($value);
        return $this;
    }

    public function getNroCta(): ?string
    {
        return HtmlDecode($this->nroCta);
    }

    public function setNroCta(?string $value): static
    {
        $this->nroCta = RemoveXss($value);
        return $this;
    }

    public function getTitular(): ?string
    {
        return HtmlDecode($this->titular);
    }

    public function setTitular(?string $value): static
    {
        $this->titular = RemoveXss($value);
        return $this;
    }

    public function getCiRif(): ?string
    {
        return HtmlDecode($this->ciRif);
    }

    public function setCiRif(?string $value): static
    {
        $this->ciRif = RemoveXss($value);
        return $this;
    }

    public function getCorreo(): ?string
    {
        return HtmlDecode($this->correo);
    }

    public function setCorreo(?string $value): static
    {
        $this->correo = RemoveXss($value);
        return $this;
    }

    public function getNroRef(): ?string
    {
        return HtmlDecode($this->nroRef);
    }

    public function setNroRef(?string $value): static
    {
        $this->nroRef = RemoveXss($value);
        return $this;
    }

    public function getMotivo(): ?string
    {
        return HtmlDecode($this->motivo);
    }

    public function setMotivo(?string $value): static
    {
        $this->motivo = RemoveXss($value);
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

    public function getCoordinador(): ?string
    {
        return HtmlDecode($this->coordinador);
    }

    public function setCoordinador(?string $value): static
    {
        $this->coordinador = RemoveXss($value);
        return $this;
    }

    public function getPagador(): ?string
    {
        return HtmlDecode($this->pagador);
    }

    public function setPagador(?string $value): static
    {
        $this->pagador = RemoveXss($value);
        return $this;
    }

    public function getFechaPago(): ?DateTime
    {
        return $this->fechaPago;
    }

    public function setFechaPago(?DateTime $value): static
    {
        $this->fechaPago = $value;
        return $this;
    }

    public function getEmailEnviado(): ?string
    {
        return $this->emailEnviado;
    }

    public function setEmailEnviado(?string $value): static
    {
        if (!in_array($value, ["S", "N"])) {
            throw new \InvalidArgumentException("Invalid 'email_enviado' value");
        }
        $this->emailEnviado = $value;
        return $this;
    }
}
