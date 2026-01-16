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
 * Entity class for "view_reclamo_lapida" table
 */
#[Entity]
#[Table(name: "view_reclamo_lapida")]
class ViewReclamoLapida extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nreclamo", type: "integer")]
    #[GeneratedValue]
    private int $nreclamo;

    #[Column(type: "string", nullable: true)]
    private ?string $solicitante;

    #[Column(type: "string", nullable: true)]
    private ?string $parentesco;

    #[Column(name: "ci_difunto", type: "string", nullable: true)]
    private ?string $ciDifunto;

    #[Column(name: "nombre_difunto", type: "string", nullable: true)]
    private ?string $nombreDifunto;

    #[Column(type: "string", nullable: true)]
    private ?string $tipo;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $registro;

    #[Column(type: "string", nullable: true)]
    private ?string $registra;

    public function getNreclamo(): int
    {
        return $this->nreclamo;
    }

    public function setNreclamo(int $value): static
    {
        $this->nreclamo = $value;
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

    public function getParentesco(): ?string
    {
        return HtmlDecode($this->parentesco);
    }

    public function setParentesco(?string $value): static
    {
        $this->parentesco = RemoveXss($value);
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

    public function getNombreDifunto(): ?string
    {
        return HtmlDecode($this->nombreDifunto);
    }

    public function setNombreDifunto(?string $value): static
    {
        $this->nombreDifunto = RemoveXss($value);
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

    public function getRegistro(): ?DateTime
    {
        return $this->registro;
    }

    public function setRegistro(?DateTime $value): static
    {
        $this->registro = $value;
        return $this;
    }

    public function getRegistra(): ?string
    {
        return HtmlDecode($this->registra);
    }

    public function setRegistra(?string $value): static
    {
        $this->registra = RemoveXss($value);
        return $this;
    }
}
