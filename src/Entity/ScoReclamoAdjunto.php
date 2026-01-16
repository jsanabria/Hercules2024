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
 * Entity class for "sco_reclamo_adjunto" table
 */
#[Entity]
#[Table(name: "sco_reclamo_adjunto")]
class ScoReclamoAdjunto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nreclamo_adjunto", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nreclamoAdjunto;

    #[Column(type: "integer")]
    private int $reclamo;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $archivo;

    #[Column(type: "string", nullable: true)]
    private ?string $usuario;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    public function __construct()
    {
        $this->reclamo = 0;
    }

    public function getNreclamoAdjunto(): string
    {
        return $this->nreclamoAdjunto;
    }

    public function setNreclamoAdjunto(string $value): static
    {
        $this->nreclamoAdjunto = $value;
        return $this;
    }

    public function getReclamo(): int
    {
        return $this->reclamo;
    }

    public function setReclamo(int $value): static
    {
        $this->reclamo = $value;
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

    public function getArchivo(): ?string
    {
        return HtmlDecode($this->archivo);
    }

    public function setArchivo(?string $value): static
    {
        $this->archivo = RemoveXss($value);
        return $this;
    }

    public function getUsuario(): ?string
    {
        return HtmlDecode($this->usuario);
    }

    public function setUsuario(?string $value): static
    {
        $this->usuario = RemoveXss($value);
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
}
