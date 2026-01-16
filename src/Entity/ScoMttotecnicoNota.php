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
 * Entity class for "sco_mttotecnico_notas" table
 */
#[Entity]
#[Table(name: "sco_mttotecnico_notas")]
class ScoMttotecnicoNota extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nmttotecnico_notas", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nmttotecnicoNotas;

    #[Column(type: "integer", nullable: true)]
    private ?int $mttotecnico;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    public function getNmttotecnicoNotas(): string
    {
        return $this->nmttotecnicoNotas;
    }

    public function setNmttotecnicoNotas(string $value): static
    {
        $this->nmttotecnicoNotas = $value;
        return $this;
    }

    public function getMttotecnico(): ?int
    {
        return $this->mttotecnico;
    }

    public function setMttotecnico(?int $value): static
    {
        $this->mttotecnico = $value;
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

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getFechaHora(): ?DateTime
    {
        return $this->fechaHora;
    }

    public function setFechaHora(?DateTime $value): static
    {
        $this->fechaHora = $value;
        return $this;
    }
}
