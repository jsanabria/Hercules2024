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
 * Entity class for "sco_reserva_old" table
 */
#[Entity]
#[Table(name: "sco_reserva_old")]
class ScoReservaOld extends AbstractEntity
{
    #[Id]
    #[Column(name: "Nreserva", type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $nreserva;

    #[Column(type: "string", nullable: true)]
    private ?string $capilla;

    #[Column(type: "date", nullable: true)]
    private ?DateTime $fecha;

    #[Column(type: "time", nullable: true)]
    private ?DateTime $hora;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    public function getNreserva(): string
    {
        return $this->nreserva;
    }

    public function setNreserva(string $value): static
    {
        $this->nreserva = $value;
        return $this;
    }

    public function getCapilla(): ?string
    {
        return HtmlDecode($this->capilla);
    }

    public function setCapilla(?string $value): static
    {
        $this->capilla = RemoveXss($value);
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

    public function getHora(): ?DateTime
    {
        return $this->hora;
    }

    public function setHora(?DateTime $value): static
    {
        $this->hora = $value;
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
