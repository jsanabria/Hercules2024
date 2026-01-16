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
 * Entity class for "sco_bloque_horario" table
 */
#[Entity]
#[Table(name: "sco_bloque_horario")]
class ScoBloqueHorario extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nbloque_horario", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $nbloqueHorario;

    #[Column(name: "servicio_tipo", type: "string", nullable: true)]
    private ?string $servicioTipo;

    #[Column(type: "string", nullable: true)]
    private ?string $hora;

    #[Column(type: "string", nullable: true)]
    private ?string $bloque;

    public function getNbloqueHorario(): int
    {
        return $this->nbloqueHorario;
    }

    public function setNbloqueHorario(int $value): static
    {
        $this->nbloqueHorario = $value;
        return $this;
    }

    public function getServicioTipo(): ?string
    {
        return HtmlDecode($this->servicioTipo);
    }

    public function setServicioTipo(?string $value): static
    {
        $this->servicioTipo = RemoveXss($value);
        return $this;
    }

    public function getHora(): ?string
    {
        return HtmlDecode($this->hora);
    }

    public function setHora(?string $value): static
    {
        $this->hora = RemoveXss($value);
        return $this;
    }

    public function getBloque(): ?string
    {
        return HtmlDecode($this->bloque);
    }

    public function setBloque(?string $value): static
    {
        $this->bloque = RemoveXss($value);
        return $this;
    }
}
