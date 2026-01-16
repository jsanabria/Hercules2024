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
 * Entity class for "view_grama_pagos" table
 */
#[Entity]
#[Table(name: "view_grama_pagos")]
class ViewGramaPago extends AbstractEntity
{
    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(name: "registro_solicitud", type: "datetime", nullable: true)]
    private ?DateTime $registroSolicitud;

    #[Column(type: "string", nullable: true)]
    private ?string $solicitante;

    #[Column(type: "string", nullable: true)]
    private ?string $difunto;

    #[Column(type: "string", nullable: true)]
    private ?string $ubicacion;

    #[Column(name: "ctto_usd", type: "decimal", nullable: true)]
    private ?string $cttoUsd;

    #[Column(name: "tipo_pago", type: "string", nullable: true)]
    private ?string $tipoPago;

    #[Column(type: "string", nullable: true)]
    private ?string $banco;

    #[Column(type: "string", nullable: true)]
    private ?string $ref;

    #[Column(name: "fecha_cobro", type: "date", nullable: true)]
    private ?DateTime $fechaCobro;

    #[Column(name: "resgitro_pago", type: "date", nullable: true)]
    private ?DateTime $resgitroPago;

    #[Column(name: "cta_destino", type: "string", nullable: true)]
    private ?string $ctaDestino;

    #[Column(name: "monto_bs", type: "decimal", nullable: true)]
    private ?string $montoBs;

    #[Column(name: "monto_usd", type: "decimal", nullable: true)]
    private ?string $montoUsd;

    #[Column(name: "monto_ue", type: "decimal", nullable: true)]
    private ?string $montoUe;

    #[Column(type: "string", nullable: true)]
    private ?string $subtipo;

    #[Column(type: "string", nullable: true)]
    private ?string $estatus;

    public function __construct()
    {
        $this->expediente = "0";
    }

    public function getExpediente(): string
    {
        return $this->expediente;
    }

    public function setExpediente(string $value): static
    {
        $this->expediente = $value;
        return $this;
    }

    public function getRegistroSolicitud(): ?DateTime
    {
        return $this->registroSolicitud;
    }

    public function setRegistroSolicitud(?DateTime $value): static
    {
        $this->registroSolicitud = $value;
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

    public function getDifunto(): ?string
    {
        return HtmlDecode($this->difunto);
    }

    public function setDifunto(?string $value): static
    {
        $this->difunto = RemoveXss($value);
        return $this;
    }

    public function getUbicacion(): ?string
    {
        return HtmlDecode($this->ubicacion);
    }

    public function setUbicacion(?string $value): static
    {
        $this->ubicacion = RemoveXss($value);
        return $this;
    }

    public function getCttoUsd(): ?string
    {
        return $this->cttoUsd;
    }

    public function setCttoUsd(?string $value): static
    {
        $this->cttoUsd = $value;
        return $this;
    }

    public function getTipoPago(): ?string
    {
        return HtmlDecode($this->tipoPago);
    }

    public function setTipoPago(?string $value): static
    {
        $this->tipoPago = RemoveXss($value);
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

    public function getRef(): ?string
    {
        return HtmlDecode($this->ref);
    }

    public function setRef(?string $value): static
    {
        $this->ref = RemoveXss($value);
        return $this;
    }

    public function getFechaCobro(): ?DateTime
    {
        return $this->fechaCobro;
    }

    public function setFechaCobro(?DateTime $value): static
    {
        $this->fechaCobro = $value;
        return $this;
    }

    public function getResgitroPago(): ?DateTime
    {
        return $this->resgitroPago;
    }

    public function setResgitroPago(?DateTime $value): static
    {
        $this->resgitroPago = $value;
        return $this;
    }

    public function getCtaDestino(): ?string
    {
        return HtmlDecode($this->ctaDestino);
    }

    public function setCtaDestino(?string $value): static
    {
        $this->ctaDestino = RemoveXss($value);
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

    public function getMontoUsd(): ?string
    {
        return $this->montoUsd;
    }

    public function setMontoUsd(?string $value): static
    {
        $this->montoUsd = $value;
        return $this;
    }

    public function getMontoUe(): ?string
    {
        return $this->montoUe;
    }

    public function setMontoUe(?string $value): static
    {
        $this->montoUe = $value;
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
