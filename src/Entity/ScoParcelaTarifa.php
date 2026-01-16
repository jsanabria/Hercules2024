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
 * Entity class for "sco_parcela_tarifa" table
 */
#[Entity]
#[Table(name: "sco_parcela_tarifa")]
class ScoParcelaTarifa extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nparcela_tarifa", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nparcelaTarifa;

    #[Column(type: "text", nullable: true)]
    private ?string $seccion;

    #[Column(type: "decimal", nullable: true)]
    private ?string $monto;

    #[Column(name: "fecha_actualizacion", type: "date", nullable: true)]
    private ?DateTime $fechaActualizacion;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    public function getNparcelaTarifa(): int
    {
        return $this->nparcelaTarifa;
    }

    public function setNparcelaTarifa(int $value): static
    {
        $this->nparcelaTarifa = $value;
        return $this;
    }

    public function getSeccion(): ?string
    {
        return HtmlDecode($this->seccion);
    }

    public function setSeccion(?string $value): static
    {
        $this->seccion = RemoveXss($value);
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

    public function getFechaActualizacion(): ?DateTime
    {
        return $this->fechaActualizacion;
    }

    public function setFechaActualizacion(?DateTime $value): static
    {
        $this->fechaActualizacion = $value;
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
}
