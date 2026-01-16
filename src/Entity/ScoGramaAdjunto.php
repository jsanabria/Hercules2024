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
 * Entity class for "sco_grama_adjunto" table
 */
#[Entity]
#[Table(name: "sco_grama_adjunto")]
class ScoGramaAdjunto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nadjunto", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nadjunto;

    #[Column(type: "bigint")]
    private string $grama;

    #[Column(type: "string", nullable: true)]
    private ?string $archivo;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "string")]
    private string $activo;

    public function __construct()
    {
        $this->grama = "0";
        $this->activo = "S";
    }

    public function getNadjunto(): string
    {
        return $this->nadjunto;
    }

    public function setNadjunto(string $value): static
    {
        $this->nadjunto = $value;
        return $this;
    }

    public function getGrama(): string
    {
        return $this->grama;
    }

    public function setGrama(string $value): static
    {
        $this->grama = $value;
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

    public function getNota(): ?string
    {
        return HtmlDecode($this->nota);
    }

    public function setNota(?string $value): static
    {
        $this->nota = RemoveXss($value);
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

    public function getActivo(): string
    {
        return HtmlDecode($this->activo);
    }

    public function setActivo(string $value): static
    {
        $this->activo = RemoveXss($value);
        return $this;
    }
}
