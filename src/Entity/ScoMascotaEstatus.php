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
 * Entity class for "sco_mascota_estatus" table
 */
#[Entity]
#[Table(name: "sco_mascota_estatus")]
class ScoMascotaEstatus extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer")]
    private int $mascota;

    #[Id]
    #[Column(type: "string")]
    private string $estatus;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    public function __construct(int $mascota, string $estatus)
    {
        $this->mascota = $mascota;
        $this->estatus = $estatus;
        $this->mascota = 0;
    }

    public function getMascota(): int
    {
        return $this->mascota;
    }

    public function setMascota(int $value): static
    {
        $this->mascota = $value;
        return $this;
    }

    public function getEstatus(): string
    {
        return $this->estatus;
    }

    public function setEstatus(string $value): static
    {
        $this->estatus = $value;
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
