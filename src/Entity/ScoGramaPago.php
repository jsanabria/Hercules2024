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
 * Entity class for "sco_grama_pagos" table
 */
#[Entity]
#[Table(name: "sco_grama_pagos")]
class ScoGramaPago extends AbstractEntity
{
    #[Id]
    #[Column(name: "Ngrama_pagos", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $ngramaPagos;

    #[Column(type: "bigint", nullable: true)]
    private ?string $grama;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $banco;

    #[Column(type: "string", nullable: true)]
    private ?string $ref;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "decimal", nullable: true)]
    private ?string $monto;

    #[Column(type: "string", nullable: true)]
    private ?string $moneda;

    #[Column(type: "decimal", nullable: true)]
    private ?string $tasa;

    #[Column(name: "monto_bs", type: "decimal", nullable: true)]
    private ?string $montoBs;

    #[Column(name: "cta_destino", type: "string", nullable: true)]
    private ?string $ctaDestino;

    #[Column(name: "fecha_registro", type: "date", nullable: true)]
    private ?DateTime $fechaRegistro;

    #[Column(name: "usuario_registra", type: "string", nullable: true)]
    private ?string $usuarioRegistra;

    public function getNgramaPagos(): string
    {
        return $this->ngramaPagos;
    }

    public function setNgramaPagos(string $value): static
    {
        $this->ngramaPagos = $value;
        return $this;
    }

    public function getGrama(): ?string
    {
        return $this->grama;
    }

    public function setGrama(?string $value): static
    {
        $this->grama = $value;
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

    public function getMoneda(): ?string
    {
        return HtmlDecode($this->moneda);
    }

    public function setMoneda(?string $value): static
    {
        $this->moneda = RemoveXss($value);
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

    public function getCtaDestino(): ?string
    {
        return HtmlDecode($this->ctaDestino);
    }

    public function setCtaDestino(?string $value): static
    {
        $this->ctaDestino = RemoveXss($value);
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

    public function getUsuarioRegistra(): ?string
    {
        return HtmlDecode($this->usuarioRegistra);
    }

    public function setUsuarioRegistra(?string $value): static
    {
        $this->usuarioRegistra = RemoveXss($value);
        return $this;
    }
}
