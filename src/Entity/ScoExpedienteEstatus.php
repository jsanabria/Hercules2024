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
 * Entity class for "sco_expediente_estatus" table
 */
#[Entity]
#[Table(name: "sco_expediente_estatus")]
class ScoExpedienteEstatus extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer")]
    private int $expediente;

    #[Id]
    #[Column(type: "integer")]
    private int $estatus;

    #[Column(name: "fecha_hora", type: "datetime", nullable: true)]
    private ?DateTime $fechaHora;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "string", nullable: true)]
    private ?string $halcon;

    public function __construct(int $expediente, int $estatus)
    {
        $this->expediente = $expediente;
        $this->estatus = $estatus;
        $this->expediente = 0;
        $this->estatus = 0;
    }

    public function getExpediente(): int
    {
        return $this->expediente;
    }

    public function setExpediente(int $value): static
    {
        $this->expediente = $value;
        return $this;
    }

    public function getEstatus(): int
    {
        return $this->estatus;
    }

    public function setEstatus(int $value): static
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

    public function getHalcon(): ?string
    {
        return HtmlDecode($this->halcon);
    }

    public function setHalcon(?string $value): static
    {
        $this->halcon = RemoveXss($value);
        return $this;
    }
}
