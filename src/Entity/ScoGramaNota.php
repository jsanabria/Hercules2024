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
 * Entity class for "sco_grama_nota" table
 */
#[Entity]
#[Table(name: "sco_grama_nota")]
class ScoGramaNota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nnota", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nnota;

    #[Column(type: "bigint")]
    private string $grama;

    #[Column(type: "text")]
    private string $nota;

    #[Column(type: "string")]
    private string $usuario;

    #[Column(type: "datetime")]
    private DateTime $fecha;

    #[Column(type: "string")]
    private string $estatus;

    public function getNnota(): string
    {
        return $this->nnota;
    }

    public function setNnota(string $value): static
    {
        $this->nnota = $value;
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

    public function getEstatus(): string
    {
        return HtmlDecode($this->estatus);
    }

    public function setEstatus(string $value): static
    {
        $this->estatus = RemoveXss($value);
        return $this;
    }
}
