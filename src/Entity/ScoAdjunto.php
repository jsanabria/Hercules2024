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
 * Entity class for "sco_adjunto" table
 */
#[Entity]
#[Table(name: "sco_adjunto")]
class ScoAdjunto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nadjunto", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nadjunto;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "string", nullable: true)]
    private ?string $archivo;

    #[Column(type: "bigint")]
    private string $expediente;

    #[Column(type: "string")]
    private string $servicio;

    #[Column(type: "integer")]
    private int $flota;

    #[Column(name: "flota_incidencia", type: "integer")]
    private int $flotaIncidencia;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string")]
    private string $activo;

    public function __construct()
    {
        $this->expediente = "0";
        $this->servicio = "0";
        $this->flota = 0;
        $this->flotaIncidencia = 0;
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

    public function getTipo(): ?string
    {
        return HtmlDecode($this->tipo);
    }

    public function setTipo(?string $value): static
    {
        $this->tipo = RemoveXss($value);
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

    public function getExpediente(): string
    {
        return $this->expediente;
    }

    public function setExpediente(string $value): static
    {
        $this->expediente = $value;
        return $this;
    }

    public function getServicio(): string
    {
        return HtmlDecode($this->servicio);
    }

    public function setServicio(string $value): static
    {
        $this->servicio = RemoveXss($value);
        return $this;
    }

    public function getFlota(): int
    {
        return $this->flota;
    }

    public function setFlota(int $value): static
    {
        $this->flota = $value;
        return $this;
    }

    public function getFlotaIncidencia(): int
    {
        return $this->flotaIncidencia;
    }

    public function setFlotaIncidencia(int $value): static
    {
        $this->flotaIncidencia = $value;
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
