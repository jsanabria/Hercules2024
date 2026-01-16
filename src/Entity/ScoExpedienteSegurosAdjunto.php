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
 * Entity class for "sco_expediente_seguros_adjunto" table
 */
#[Entity]
#[Table(name: "sco_expediente_seguros_adjunto")]
class ScoExpedienteSegurosAdjunto extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nexpediente_seguros_adjunto", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nexpedienteSegurosAdjunto;

    #[Column(name: "expediente_seguros", type: "bigint")]
    private string $expedienteSeguros;

    #[Column(type: "string", nullable: true)]
    private ?string $archivo;

    #[Column(type: "string", nullable: true)]
    private ?string $nota;

    public function __construct()
    {
        $this->expedienteSeguros = "0";
    }

    public function getNexpedienteSegurosAdjunto(): string
    {
        return $this->nexpedienteSegurosAdjunto;
    }

    public function setNexpedienteSegurosAdjunto(string $value): static
    {
        $this->nexpedienteSegurosAdjunto = $value;
        return $this;
    }

    public function getExpedienteSeguros(): string
    {
        return $this->expedienteSeguros;
    }

    public function setExpedienteSeguros(string $value): static
    {
        $this->expedienteSeguros = $value;
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
}
