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
 * Entity class for "sco_reclamo_nota" table
 */
#[Entity]
#[Table(name: "sco_reclamo_nota")]
class ScoReclamoNota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nreclamo_nota", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nreclamoNota;

    #[Column(type: "integer")]
    private int $reclamo;

    #[Column(type: "text")]
    private string $nota;

    #[Column(type: "string")]
    private string $usuario;

    #[Column(type: "datetime")]
    private DateTime $fecha;

    public function getNreclamoNota(): string
    {
        return $this->nreclamoNota;
    }

    public function setNreclamoNota(string $value): static
    {
        $this->nreclamoNota = $value;
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

    public function getNota(): string
    {
        return HtmlDecode($this->nota);
    }

    public function setNota(string $value): static
    {
        $this->nota = RemoveXss($value);
        return $this;
    }

    public function getUsuario(): string
    {
        return HtmlDecode($this->usuario);
    }

    public function setUsuario(string $value): static
    {
        $this->usuario = RemoveXss($value);
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $value): static
    {
        $this->fecha = $value;
        return $this;
    }
}
